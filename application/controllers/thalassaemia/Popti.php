<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Popti extends MY_Controller {
    
    public function index() {
        $this->access_arg('access popti-list');
        $popti = $this->model->load_data('popti_view');
        $vars['records'] = $popti;
        $vars['details'] = $this->load->view('pages/popti/detail', $vars, true);
        $this->template->add_js('assets/js/thalassaemia/popti.js');
        $this->template->breadcrumbs('POPTI');
        $this->template->page_title('POPTI');
        $this->template->display('popti/list', $vars);
    }
    
    public function details() {
        $this->access_arg('access popti-list');
        $id = $this->uri->segment(2);
        if (!empty($id)) {
            $popti = $this->model->load_by_id('popti', $id);
            $rules = array('removed' => 0, 'poptid' => $id);
            $units = $this->model->load_data('popti_unit', $rules);
            echo json_encode(array('popti' => $popti, 'units' => $units));
        }
        
        exit;
    }
    
    public function units() {
        echo '<option value="0">-- Pilih Lembaga Kesehatan</option>';
        if (!empty($this->uri->segment(3))) {
            $id = $this->uri->segment(3);
            $rules = array('removed' => 0, 'poptid' => $id);
            $units = $this->model->load_data('popti_unit', $rules);
            if (!empty($units)) {
                foreach ($units as $unit) {
                    echo '<option value="' . $unit->id . '">' . $unit->name . '</option>';
                }
            }
        }
        
        exit;
    }
    
    public function add() {
        $this->access_arg('access popti-add');
        $vars = array();
        $this->template->add_js('assets/js/thalassaemia/popti.js');
        $this->template->breadcrumbs(anchor('popti', 'POPTI'));
        $this->template->breadcrumbs('Tambah POPTI');
        $this->template->page_title('Tambah POPTI');
        $this->template->display('popti/add', $vars);
    }
    
    public function edit() {
        
        $this->access_arg('access popti-edit');
        
        $id = $this->uri->segment(2);
        $terms = array('removed' => 0);
        $popti = $this->model->load_by_id('popti', $id, $terms);
        if (empty($popti)) {
            $this->_404();
        }
        
        $rules = array('removed' => 0, 'poptid' => $id);
        $units = $this->model->load_data('popti_unit', $rules);
        
        $vars['popti'] = $popti;
        $vars['units'] = $units;
        $this->template->add_js('assets/js/thalassaemia/popti.js');
        $this->template->breadcrumbs(anchor('popti', 'POPTI'));
        $this->template->breadcrumbs('Ubah POPTI');
        $this->template->page_title('Ubah POPTI - ' . $popti->branch);
        $this->template->display('popti/edit', $vars);
    }
    
    public function submit() {
        $post = (object) $this->input->post();
        if (!empty($post->form_action)) {
            
            $popti_id = '';
            $code = 400;
            $errs = array();
            
            $this->form_validation->set_rules('popti_branch', 'Nama Cabang POPTI', 'trim|required|min_length[3]');
            if (!$this->form_validation->run()) {
                $errs = array(
                    'popti-branch' => $this->form_error_render('popti_branch'),
                );
            } else {
                
                $auth = $this->authentication();
                $popti = new stdClass();
                $popti->branch  = $post->popti_branch;
                $popti->notes   = $post->popti_notes;
                
                if ($post->form_action == 'add') {
                    $this->access_arg('access popti-add');
                    $popti->uid = $auth->user->id;
                    $popti_id = $this->model->record_save('popti', $popti);
                    $this->_save_popti_unit($popti_id, $post);
                    $this->audit('log-popti-add', 'popti', 'menambah data Cabang POPTI <span class="text-muted">"' . $popti->branch . '"</span>');
                } else {
                    $this->access_arg('access popti-edit');
                    if (isset($post->popti_status)) {
                        $popti->enabled = $post->popti_status;
                    }
                    
                    $popti_id = $post->popti_id;
                    $this->model->record_update('popti', $popti_id, $popti);
                    $this->_save_popti_unit($post->popti_id, $post, 'edit');
                    $this->audit('log-popti-edit', 'popti', 'memodifikasi data Cabang POPTI <span class="text-muted">"' . $popti->branch . '"</span>');
                }
                
                $code = 200;
            }
            
            $resp = array('code' => $code, 'errors' => $errs);
            if (!empty($popti_id) && ($post->form_action == 'edit')) {
                $rules = array('removed' => 0, 'poptid' => $popti_id);
                $units = $this->model->load_data('popti_unit', $rules);
                $resp['data'] = !empty($units)? json_encode($units) : '';
            }
            
            echo json_encode($resp);
        }
        
        die();
    }
    
    public function activate() {
        $this->access_arg('access popti-locking');
        $post = (object) $this->input->post();
        $popti = array('enabled' => $post->popti_status);
        $this->model->record_update('popti', $post->popti_id, $popti);
        
        $auth = $this->authentication();
        $act = $post->popti_status == 1 ? 'mengaktifkan' : 'menon-acktifkan';
        $act = $act . ' data Cabang POPTI <span class="text-muted">"' . $post->popti_branch . '"</span>.';
        $this->audit('log-popti-locking', 'popti', $act);
    }
    
    public function delete() {
        $this->access_arg('access popti-remove');
        $post = (object) $this->input->post();
        $popti = array('removed' => 1);
        $this->model->record_update('popti', $post->popti_id, $popti);
        
        $auth = $this->authentication();
        $act = 'menghapus data POPTI "' . $post->popti_branch . '".';
        $this->audit('log-popti-delete', 'popti', $act);
    }
    
    private function _save_popti_unit($popti_id, $post, $act = 'add') {
        
        $units = $ids = $items = $notes = array();
        if (!empty($post->popti_unit_ids)) {
            $ids = $post->popti_unit_ids;
        }
        
        if (!empty($post->popti_items)) {
            $items = $post->popti_items;
        }
        
        if (!empty($post->popti_items)) {
            $notes = $post->popti_item_notes;
        }
        
        if ($act == 'edit') {
            $rules = array('removed' => 0, 'poptid' => $popti_id);
            $unit_cores = $this->model->load_data('popti_unit', $rules);
            if (!empty($unit_cores)) {
                foreach ($unit_cores as $unit) {
                    if (!in_array($unit->id, $ids)) {
                        $data['removed'] = 1;
                        $this->model->record_update('popti_unit', $unit->id, $data);
                    }
                }
            }
        }

        foreach ($items as $i => $item) {

            $data = array(
                'poptid' => $popti_id,
                'name' => $item,
                'notes' => $notes[$i],
            );

            if ($act != 'add') {
                if (!empty($ids[$i])) {
                    $this->model->record_update('popti_unit', $ids[$i], $data);
                    $units = array();
                } else {
                    array_push($units, $data);
                }
            } else {
                array_push($units, $data);
            }
        }
        
        #print_r($units);
        if (count($units) > 0) {
            $this->model->record_save_batch('popti_unit', $units);
        }
    }
}
