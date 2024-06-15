<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security extends MY_Controller {

    public function login() {
        
        $post = (object) $this->input->post();
        $setup = $this->model->variable_load('app_setup');
        if (!empty($setup)) $setup = json_decode($setup);
        
        if (!empty($post->login_act)) {
            $direct = 'login';
            $user = $this->model->user_login($post->name, $post->password);
            if (!empty($user)) {
                unset($user->password);
                $perms = $this->model->role_access($user->rid);
                
                $auth = new stdClass();
                $auth->user = $user;
                $auth->privileges = $perms;
                $this->session->set_userdata('user_auth', $auth);
                $this->session->set_userdata('user_dasboard', true);
                
                $this->session->set_userdata('app_setup', $setup);
                $this->_custom_thalassaemia();
                
                $direct = '/';
                $this->audit('log-user-login', 'last_login', 'Login Aplikasi.');
            } else {
                $this->session->set_userdata('invalid_login', 1);
            }
            
            redirect($direct);
        }
        
        $vars['application'] = $setup;
        $this->load->view('pages/login', $vars);
    }
    
    private function _custom_thalassaemia() {
        $this->load->model('screening_model', 'screening');
        $obj = $this->screening->last_event();
        if (!empty($obj)) {
            $this->session->set_userdata('last_event', $obj->event);
        }
    }
    
    public function logout() {
        $this->audit('log-user-logout', 'logout', 'Keluar Aplikasi.');
        $this->session->unset_userdata('user_auth');
        redirect('login');
    }
    
    public function goto404() {
        $this->overide_404();
    }
    
    public function update_password() {
        $vars = array();
        $this->template->add_js('assets/js/security.js');
        $this->template->breadcrumbs(anchor('user-profile/' . $this->authentication()->user->name, 'Profil Akun'));
        $this->template->breadcrumbs('Ubah Sandi');
        $this->template->page_title('Ubah Sandi');
        $this->template->display('support/update-password', $vars);
    }
    
    public function update_password_submit() {
        
        $post = (object) $this->input->post();
        $code = 400;
        $errs = null;
        
        $password_regex = '/^[a-zA-Z0-9!@#$%^&*_.\\-]*$/';
        $this->form_validation->set_rules('user_old_password', 'Kata Sandi', 'trim|required|callback_old_password_validate');
        $this->form_validation->set_rules('user_new_password', 'Kata Sandi', 'trim|required|min_length[8]|regex_match[' . $password_regex . ']');
        $this->form_validation->set_rules('user_new_repassword', 'Kata Sandi', 'trim|required|matches[user_new_password]');
        if (!$this->form_validation->run()) {
            $errs = array(
                'user-old-password' => $this->form_error_render('user_old_password'),
                'user-new-password' => $this->form_error_render('user_new_password'),
                'user-new-repassword' => $this->form_error_render('user_new_repassword'),
            );
        } else {
            $uid = $this->authentication()->user->id;
            $data['password'] = password_hash($post->user_new_password, PASSWORD_BCRYPT);
            $this->model->record_update('user', $uid, $data);
            $this->audit('log-change-password', 'update-password', 'mengubah kata sandi akun.');
            $code = 200;
        }
        
        $resp = array('code' => $code, 'errors' => $errs);
        echo json_encode($resp);
        die();
    }
    
    public function old_password_validate($password) {
        $bool = true;
        if (!empty($password)) {
            $name = $this->authentication()->user->name;
            $user = $this->model->user_login($name, $password);
            if (empty($user)) {
                $bool = false;
                $message = 'Pengisian Kata Sandi tidak valid.';
                $this->form_validation->set_message('old_password_validate', $message);
            }
        }
        
        return $bool;
    }
}
