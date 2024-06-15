<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application extends MY_Controller {
    
    private $upload_error;
    private $upload_data;
    private $upload_dir;
    private $form_error;
    private $post_data;
    
    public function index() {
        $this->access_arg('access settings application');
        $this->_setting_apps_submit();
        $vars['logging_collection'] = $this->logging_collection();
        $vars['setup'] = $this->model->variable_load('app_setup');
        $this->template->add_js('assets/js/application.js');
        $this->template->breadcrumbs('Konfigurasi Aplikasi');
        $this->template->pre_title('<i class="ti-settings"></i> Konfigurasi');
        $this->template->page_title('Pengaturan Aplikasi');
        $this->template->display('support/setting-apps', $vars);
    }
    
    private function _post_validate() {
        $this->form_validation->set_rules('app_name', 'Nama Aplikasi', 'trim|required');
        return $this->form_validation->run();
    }
    
    private function _setting_apps_submit() {
        $code = 500;
        $errs = array();
        if (!empty($this->input->post('setting_apps'))) {
            
            $this->upload_error = $this->upload_data = $this->form_error = $this->upload_dir = array();
            if (!$this->_post_validate()) {
                $this->_basic_form_errors();
            } else {
                $this->_upload_handler();
                if (count($this->form_error) == 0) {
                    $this->_save();
                    $code = 200;
                }
            }
            
            echo json_encode(array(
                'code' => $code, 
                'errors' => $this->form_error,
                'setup' => $this->post_data,
            ));
            
            exit;
        }
    }
    
    private function _save() {
        
        $post = (object) $this->input->post();
        if (!empty($this->upload_data['app_logo'])) {
            $post->app_logo = $this->upload_dir['app_logo'] . $this->upload_data['app_logo']->file_name;
        } else {
            if (!empty($post->app_logo_path))
                $post->app_logo = $post->app_logo_path;
        }

        if (!empty($this->upload_data['app_icon'])) {
            $post->app_icon = $this->upload_dir['app_icon'] . $this->upload_data['app_icon']->file_name;
        } else {
            if (!empty($post->app_icon_path))
                $post->app_icon = $post->app_icon_path;
        }
        
        if (!empty($this->upload_data['app_avatar'])) {
            $post->app_avatar = $this->upload_dir['app_avatar'] . $this->upload_data['app_avatar']->file_name;
        } else {
            if (!empty($post->app_avatar_path))
                $post->app_avatar = $post->app_avatar_path;
        }

        $this->post_data = $post;
        $this->model->variable_save('app_setup', json_encode($post));
        $this->session->set_userdata('app_setup', $post);
        
        $this->audit('log-setting-application', 'setting-application', 'Mengubah pengaturan aplikasi.');
    }
    
    private function _basic_form_errors() {
        $this->form_error = array(
            'app-name' => $this->form_error_render('app_name'),
        );
    }
    
    private function _image_uploaded($key) {
        
        $bool = true;
        if (!empty($_FILES[$key]['name'])) {
            $path = 'assets/img/uploads/application/';
            $this->upload_dir[$key] = $path;
            $this->upload_error[$key] = '';
            if (!file_exists($path)) {
                mkdir($path);
            }

            $config = array();
            $config['upload_path']      = $path;
            $config['allowed_types']    = 'jpg|png|jpeg|ico';
            $config['max_size']         = 1024;
            $config['overwrite']        = true;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload($key)) {
                $this->upload_error[$key] = $this->upload->display_errors('<span>', '</span>');
                $bool = false;
            } else {
                $this->upload_data[$key] = (object) $this->upload->data();
            }
        }
        
        return $bool;
    }
    
    private function _upload_handler() {
        if (!empty($_FILES['app_logo']['name'])) {
            $this->_image_uploaded('app_logo');
        }

        if (!empty($_FILES['app_icon']['name'])) {
            $this->_image_uploaded('app_icon');
        }
        
        if (!empty($_FILES['app_avatar']['name'])) {
            $this->_image_uploaded('app_avatar');
        }
        
        if (!empty($this->upload_error['app_logo'])) {
            $this->form_error['app-logo'] = $this->upload_error['app_logo'];
        }
        
        if (!empty($this->upload_error['app_icon'])) {
            $this->form_error['app-icon'] = $this->upload_error['app_icon'];
        }
        
        if (!empty($this->upload_error['app_avatar'])) {
            $this->form_error['app-avatar'] = $this->upload_error['app_avatar'];
        }
    }
}
