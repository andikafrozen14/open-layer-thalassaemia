<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
    
    private $upload_data;
    private $upload_dir;
    private $upload_error;
    private $avatar_name;
    private $uid;
    
    public function __construct() {
        parent::__construct();
        $this->upload_dir = 'assets/img/uploads/avatars/';
    }
    
    public function index() {
        $this->access_arg('access settings user-list');
        $vars['roles'] = $this->model->role_options();
        $vars['user_form'] = $this->load->view('pages/user/user-form', $vars, true);
        $this->template->add_js('assets/js/user.js');
        $this->template->breadcrumbs('Manajemen Pengguna');
        $this->template->pre_title('<i class="ti-settings"></i> Konfigurasi');
        $this->template->page_title('Manajemen Pengguna');
        $this->template->display('user/user', $vars);
    }
    
    public function user_list() {
        $this->access_arg('access settings user-list', 'json');
        $vars['users'] = $this->model->user_list();
        $vars['authentication'] = $this->authentication();
        $this->load->view('pages/user/user-list', $vars);
    }
    
    public function user_profile() {
        $name = $this->uri->segment(2);
        $user = $this->model->user_by_name($name);
        if (!empty($user)) {
            $trail = $this->model->get_last_user_trail('last_login', $user->id);
            $vars['account'] = $user;
            $vars['last_login'] = $trail;
            $vars['authentication'] = $this->authentication();
            if ($this->authentication()->user->name == $name) {
                $vars['profile_form'] = $this->load->view('pages/user/user-profile-edit', $vars, true);
            }

            $this->template->add_js('assets/js/user.js');
            $this->template->breadcrumbs('Profil Akun Pengguna');
            $this->template->page_title('Profil Akun Pengguna');
            $this->template->display('user/user-profile', $vars);
        } else {
            $this->_404();
        }
    }
    
    public function update_avatar() {
        $name = $this->input->post('user_id');
        $auth = $this->authentication();
        if (!empty($name)) {
            if ($name == $auth->user->name) {
                if ($this->_avatar_document_validate('edit')) {
                    
                    $uid = $auth->user->id;
                    $meta = $this->model->user_meta($uid);
                    $md = !empty($meta)? (array) json_decode($meta) : array();
                    
                    $path = '';
                    if (!empty($this->upload_data)) {
                        $path = $this->upload_dir . $this->avatar_name . $this->upload_data->file_ext;
                    }
                    
                    if (!empty($path)) $md['path'] = $path;
                    $meta = new stdClass();
                    $meta->meta_data = json_encode($md);
                    $this->model->user_meta_save($uid, $meta, 'edit');
                    $this->session->set_userdata('upload_success', true);
                    redirect('user-profile/' . $auth->user->name);
                }
            }
        }
        
        redirect();
    }
    
    private function _avatar_document_validate($action_type = 'add') {
        $bool = true;
        if (!empty($_FILES['user_avatar']['name'])) {
            $user_id = $_POST['user_id'];
            if (!empty($user_id)) {
                $this->upload_error = '';
                $this->avatar_name = 'avatar-' . slugify($user_id);
                $config['upload_path']      = $this->upload_dir;
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']         = 2048;
                $config['overwrite']        = true;
                $config['file_name']        = $this->avatar_name;
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('user_avatar')) {
                    $this->upload_error = $this->upload->display_errors('<span>', '</span>');
                    $bool = false;
                } else {
                    $this->upload_data = (object) $this->upload->data();
                }
            }
        }
        
        return $bool;
    }
    
    public function username_validate($input) {
        $bool = true;
        $terms = array('name' => strtolower($input));
        $row = $this->model->user_validate($terms);
        if (!empty($row)) {
            $message = 'User ID sudah terdaftar. Silahkan ubah dengan nama lain.';
            $this->form_validation->set_message('username_validate', $message);
            $bool = false;
        }
        
        return $bool;
    }
    
    public function email_validate($input) {
        $bool = true;
        $terms = array('email' => strtolower($input));
        if (!empty($this->uid)) {
            $terms['id <>'] = $this->uid;
        }
        
        $row = $this->model->user_validate($terms);
        if (!empty($row)) {
            $message = 'E-mail sudah terdaftar. Silahkan ubah dengan email lain.';
            $this->form_validation->set_message('email_validate', $message);
            $bool = false;
        }
        
        return $bool;
    }
    
    private function user_form_validate($post) {
        
        $password_regex = '/^[a-zA-Z0-9!@#$%^&*_.\\-]*$/';
        if ($post->user_form_action == 'add') {
            $this->form_validation->set_rules('user_id', 'ID Pengguna', 'trim|required|min_length[8]|regex_match[/^[a-zA-Z0-9_@.\\-]*$/]|callback_username_validate');
            $this->form_validation->set_rules('user_password', 'Kata Sandi', 'trim|required|min_length[8]|regex_match[' . $password_regex . ']');
            $this->form_validation->set_rules('user_repassword', 'Ulangi Kata Sandi', 'trim|required|matches[user_password]');
        } else {
            $act = explode('-', $post->user_form_action);
            $this->uid = $act[1];
            if (!empty($post->user_password)) {
                $this->form_validation->set_rules('user_password', 'Kata Sandi', 'trim|min_length[8]|regex_match[' . $password_regex . ']');
                $this->form_validation->set_rules('user_repassword', 'Ulangi Kata Sandi', 'trim|required|matches[user_password]');
            }
        }
        
        $this->form_validation->set_rules('user_role', 'Tipe Pengguna', 'trim|required');
        $this->form_validation->set_rules('user_screen', 'Nama Lengkap', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('user_phone', 'No. Telepon', 'trim|min_length[7]');
        $this->form_validation->set_rules('user_email', 'E-mail', 'trim|required|valid_email|callback_email_validate');
        return $this->form_validation->run();
    }
    
    public function user_save() {
        
        $this->uid = null;
        $data['code'] = 200;
        $post = (object) $this->input->post();
        $upload = $this->_avatar_document_validate($post->user_form_action);
        
        if (!$this->user_form_validate($post) || !$upload) {
            $errs = array(
                'user-id' => $this->form_error_render('user_id'),
                'user-screen' => $this->form_error_render('user_screen'),
                'user-email' => $this->form_error_render('user_email'),
                'user-password' => $this->form_error_render('user_password'),
                'user-repassword' => $this->form_error_render('user_repassword'),
                'user-role' => $this->form_error_render('user_role'),
                'user-phone' => $this->form_error_render('user_phone'),
                'user-avatar' => $this->upload_error,
            );

            $data['code'] = 400;
            $data['errors'] = $errs;
        } else {
            $meta_act = 'add';
            $user = new stdClass();
            $user->screen = $post->user_screen;
            $user->email = strtolower($post->user_email);
            $user->rid = $post->user_role;
            if ($post->user_form_action == 'add') {
                $this->access_arg('access settings user-add', 'json');
                $user->name = strtolower($post->user_id);
                $user->password = password_hash($post->user_password, PASSWORD_BCRYPT);
                $this->uid = $this->model->record_save('user', $user);
                $this->audit('log-user-add', 'user', 'menambah data akun pengguna "<span class="text-muted">' . $post->user_id . '</span>"');
            } else {
                $this->access_arg('access settings user-edit', 'json');
                if (!empty($post->user_password)) {
                    $user->password = password_hash($post->user_password, PASSWORD_BCRYPT);
                }
                
                $meta_act = 'update';
                $exp = explode('-', $post->user_form_action);
                $this->uid = $exp[1];
                $this->model->record_update('user', $this->uid, $user);
                $this->audit('log-user-edit', 'user', 'mengubah data akun pengguna "<span class="text-muted">' . $post->user_id . '</span>"');
            }
            
            $path = '';
            $md = array('phone' => $post->user_phone);
            if (!empty($this->upload_data)) {
                $path = $this->upload_dir . $this->avatar_name . $this->upload_data->file_ext;
            } else {
                if ($meta_act == 'update') {
                    $current_meta = $this->model->user_meta($this->uid);
                    if (!empty($current_meta)) {
                        $current_meta = json_decode($current_meta);
                        if (!empty($current_meta->path)) {
                            $path = $current_meta->path;
                        }
                    }
                }
            }
            
            #print_r($post);die();
            if (!empty($path)) $md['path'] = $path;
            $meta = new stdClass();
            $meta->user_id = $this->uid;
            $meta->meta_data = json_encode($md);
            $this->model->user_meta_save($this->uid, $meta, $meta_act);
            
            $message = 'Identitas pengguna <b>' . $post->user_screen . '</b> tersimpan.';
            $data['message'] = $message;
        }
        
        echo json_encode($data);
        exit;
    }
    
    public function user_lock() {
        $this->access_arg('access settings user-locking', 'json');
        $post = (object) $this->input->post();
        $lock = $post->lock == 'true' ? 1 : 0;
        if ($lock == 1) {
            $this->audit('log-user-locking', 'user', 
                    'menon-aktifkan data akun pengguna "<span class="text-muted">' . $post->name . '</span>"');
        } else {
            $this->audit('log-user-locking', 'user', 
                    'mengaktifkan kembali data akun pengguna "<span class="text-muted">' . $post->name . '</span>"');
        }
        
        $this->model->record_update('user', $post->uid, array('locked' => $lock));
        exit;
    }
    
    public function user_delete() {
        $this->access_arg('access settings user-remove', 'json');
        $uid = $this->uri->segment(4);
        $user = $this->model->load_by_id('user', $uid);
        if (!empty($user)) {
            $this->model->record_update('user', $uid, array('status' => 0));
            $this->audit('log-user-delete', 'user', 
                    'menghapus data akun pengguna "<span class="text-muted">' . $user->name . '</span>"');
        }
        
        exit;
    }
    
    public function update_profile() {
        if (!empty($this->authentication()) && !empty($this->input->post('user_screen'))) {
            $code = 400;
            $errs = array();
            $name = '';
            $post = (object) $this->input->post();
            #print_r($post);

            $this->uid = $this->authentication()->user->id;
            $this->form_validation->set_rules('user_screen', 'Nama Lengkap', 'trim|required|min_length[2]');
            $this->form_validation->set_rules('user_phone', 'No. Telepon', 'trim|min_length[7]');
            $this->form_validation->set_rules('user_email', 'E-mail', 'trim|required|valid_email|callback_email_validate');
            if (!$this->form_validation->run()) {
                $errs = array(
                    'user-screen' => $this->form_error_render('user_screen'),
                    'user-email' => $this->form_error_render('user_email'),
                    'user-phone' => $this->form_error_render('user_phone'),
                );
            } else {
                $user = new stdClass();
                $user->screen   = $post->user_screen;
                $user->email    = $post->user_email;
                $user->updated  = date('Y-m-d H:i:s');
                $this->model->record_update('user', $this->uid, $user);
                
                $auth = $this->authentication();
                $name = $auth->user->name;
                
                $auth->user->screen = $post->user_screen;
                $auth->user->email  = $post->user_email;
                $meta = json_decode($auth->user->meta_data);
                $meta->phone = $post->user_phone;
                $auth->user->meta_data = json_encode($meta);
                
                $md = array('meta_data' => json_encode($meta));
                $this->model->user_meta_save($this->uid, $md, 'edit');
                $this->session->set_userdata('user_auth', $auth);
                
                $code = 200;
                $this->session->set_userdata('profile_edit_success', true);
                $this->audit('log-profile-edit', 'profile', 'mengubah data profil pribadinya.');
            }

            $resp = array('code' => $code, 'errors' => $errs, 'user' => $name);
            echo json_encode($resp);
        }
    }
}
