<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
    public function __construct() {
        parent::__construct();        
        $this->auth_verify();
        $this->load->helper('application');
        $this->load->library('template');
        $this->load->model('base_model', 'model');
        $this->load->model('fact_model', 'fact');
    }
    
    protected function setup() {
        return $this->session->userdata('app_setup');
    }
    
    protected function authentication() {
        return $this->session->userdata('user_auth');
    }
    
    protected function auth_verify() {
        $uri = $this->uri->segment(1);
        if (empty($this->authentication()) && ($uri != 'login')) {
            redirect('login');
        }
    }
    
    protected function access_arg($key, $intercept_type = '') {
        if (!in_array($key, $this->authentication()->privileges)) {
            
            /*if ($intercept_type == 'json') {
                $data = array('code' => 404, 'messsage' => 'Page not found.');
                echo json_encode($data);
                exit;
            }*/
            
            $this->_404();
        }
    }
    
    protected function _404() {
        $obj = &get_instance();
        $obj->template->display('custom-404');
        echo $obj->output->get_output();
        exit;
    }
    
    protected function overide_404() {
        $this->template->display('custom-404');
    }
    
    protected function form_error_render($field) {
        return form_error($field, '<span>', '</span>');
    }
    
    protected function audit($key, $type, $activity) {
        $bool = false;
        $setup = $this->setup();
        if (!empty($setup->app_tick_logging)) {
            $bool = in_array($key, $setup->app_tick_logging);
            if ($bool) {
                $uid = $this->authentication()->user->id;
                $this->model->save_user_trail($uid, $type, $activity);
            }
        }
        
        return $bool;
    }
    
    protected function logging_collection() {
        return array(
            'log-user-add' => 'Menambahkan pengguna baru.',
            'log-user-edit' => 'Mengubah data pengguna.',
            'log-user-locking' => 'Mengaktif / non-aktifkan data pengguna.',
            'log-user-delete' => 'Menghapus data pengguna.',
            'log-role-add' => 'Menambahkan tipe pengguna baru dan pengaturan akses tipe pengguna.',
            'log-role-edit' => 'Mengubah data tipe pengguna dan pengaturan akses tipe pengguna.',
            'log-role-locking' => 'Mengaktif / non-aktifkan data tipe pengguna.',
            'log-role-delete' => 'Menghapus data tipe pengguna.',
            'log-profile-edit' => 'Mengubah data profil pribadi.',
            'log-change-password' => 'Mengubah kata sandi akun pribadi.',
            'log-user-login' => 'Masuk / Login Aplikasi.',
            'log-user-logout' => 'Keluar / Logout Aplikasi.',
            'log-patient-add' => 'Menambahkan data sahabat thalassaemia baru.',
            'log-patient-edit' => 'Mengubah data sahabat thalassaemia.',
            'log-patient-print-card' => 'Mencetak kartu sahabat thalassaemia.',
            'log-patient-delete' => 'Menghapus data sahabat thalassaemia',
            'log-patient-export' => 'Meng-export data sahabat thalassaemia.',
            'log-popti-add' => 'Menambahkan cabang POPTI baru.',
            'log-popti-edit' => 'Mengubah cabang POPTI.',
            'log-popti-delete' => 'Menghapus POPTI.',
            'log-popti-locking' => 'Mengaktif / non-aktifkan cabang POPTI.',
            'log-screening-add' => 'Menambahkan data screening.',
            'log-screening-edit' => 'Mengubah data screening.',
            'log-screening-delete' => 'Menghapus data screening.',
            'log-screening-print' => 'Mencetak detil data screening.',
            'log-screening-export' => 'Meng-export data screening.',
            'log-setting-application' => 'Mengubah konfigurasi standar aplikasi.',
        );
    }
}
