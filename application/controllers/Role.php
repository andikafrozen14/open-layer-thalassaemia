<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends MY_Controller {
    
    private $form_action;

    public function index() {
        $this->access_arg('access settings role-list');
        $vars['authentication'] = $this->authentication();
        $vars['role_form'] = $this->load->view('pages/role/role-form', $vars, true);
        $this->template->add_js('assets/js/role.js');
        $this->template->breadcrumbs('Tipe Pengguna');
        $this->template->pre_title('<i class="ti-settings"></i> Konfigurasi');
        $this->template->page_title('Tipe Pengguna');
        $this->template->display('role/role', $vars);
    }
    
    public function role_data() {
        $this->access_arg('access settings role-list');
        $vars['authentication'] = $this->authentication();
        $vars['roles'] = $this->model->roles();
        $this->load->view('pages/role/role-list', $vars);
    }
    
    public function role_access() {
        $this->access_arg('access settings role-privilege');
        $this->config->load('customs/privilege');
        $vars['perms'] = $this->config->item('privileges');
        
        $rid = $this->uri->segment(4);
        if (!empty($rid)) {
            $vars['role_perms'] = $this->model->role_access($rid);
        }
        
        $this->load->view('pages/role/role-access', $vars);
    }
    
    public function role_save() {
        $code = 204;
        $fail = '';
        $post = (object) $this->input->post();
        $this->form_action = $post->role_form_action;
        $rules = 'trim|required|min_length[3]|regex_match[/^[a-zA-Z0-9\s]*$/]|callback_role_name_is_unique';
        $this->form_validation->set_rules('role_screen', 'Nama Tipe Pengguna', $rules);
        if ($this->form_validation->run()) {
            
            $rid = null;
            $role = new stdClass();
            $role->name = slugify($post->role_screen);
            $role->screen = $post->role_screen;
            if ($this->form_action == 'add') {
                $this->access_arg('access settings role-add', 'json');
                $rid = $this->model->record_save('role', $role);
                $this->audit('log-role-add', 'role', 'menambah tipe pengguna <span class="text-muted">"' . $role->screen . '"</span>.');
            } else {
                $this->access_arg('access settings role-edit', 'json');
                $exp = explode('-', $this->form_action);
                $rid = $exp[1];
                $this->model->record_update('role', $rid, $role);
                $this->audit('log-role-edit', 'role', 'memodifikasi tipe pengguna <span class="text-muted">"' . $role->screen . '"</span>.');
            }
            
            if (!empty($rid)) {
                $perms = !empty($post->role_perms) ? $post->role_perms : null;
                $this->model->perm_save($rid, $perms);
            }
            
            $code = 200;
        } else {
            $code = 500;
            $fail = $this->form_error_render('role_screen');
        }
        
        $result = array('code' => $code, 'error' => $fail);
        echo json_encode($result);
        die();
    }
    
    public function role_name_is_unique($input) {
        $bool = true;
        $role = $this->model->role_by_name(slugify($input));
        if ($this->form_action != 'add') {
            if (!empty($role)) {
                $exp = explode('-', $this->form_action);
                if ($role->id != $exp[1]) {
                    $bool = false;
                }
            }
        } else {
            if (!empty($role)) {
                $bool = false;
            }
        }
        
        if (!$bool) {
            $msg = 'Tipe Pengguna sudah terdaftar. Silahkan ubah dengan nama lain.';
            $this->form_validation->set_message('role_name_is_unique', $msg);
        }
        
        return $bool;
    }
    
    public function role_lock() {
        $this->access_arg('access settings role-locking', 'json');
        $post = (object) $this->input->post();
        $lock = $post->lock == 'true' ? 1 : 0;
        $this->model->record_update('role', $post->uid, array('locked' => $lock));
        if ($lock == 1) {
            $this->audit('log-role-locking', 'role', 'menon-aktifkan tipe pengguna <span class="text-muted">"' . $post->screen . '"</span>.');
        } else {
            $this->audit('log-role-locking', 'role', 'mengaktifkan kembali tipe pengguna <span class="text-muted">"' . $post->screen . '"</span>.');
        }
        
        exit;
    }
    
    public function role_delete() {
        $this->access_arg('access settings role-remove', 'json');
        $rid = $this->uri->segment(4);
        $role = $this->model->load_by_id('role', $rid);
        if (!empty($role)) {
            $this->model->record_update('role', $rid, array('status' => 0));
            $this->audit('log-role-delete', 'role', 'menghapus tipe pengguna <span class="text-muted">"' . $role->screen . '"</span>.');
        }
        
        exit;
    }
}
