<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends MY_Controller {
    
    private $_fid;
    
    public function __construct() {
        parent::__construct();
        $this->_fid = 0;
        $this->load->model('patient_model', 'patient');
    }
    
    private function _patient_form_vars() {
        $genders    = $this->model->variable_load('genders');
        $blood_type = $this->model->variable_load('bloodtype');
        $edu        = $this->model->variable_load('edulist');
        $maritals   = $this->model->variable_load('maritals');
        $gentype    = $this->model->variable_load('gentype');
        $warranties = $this->model->variable_load('warranties');
        $popti      = $this->model->load_data('popti', array('removed' => 0, 'enabled' => 1));
        
        $vars['gender'] = !empty($genders)? (array) json_decode($genders) : array();
        $vars['blood_type'] = !empty($blood_type)? (array) json_decode($blood_type) : array();
        $vars['edu_opts'] = !empty($edu)? (array) json_decode($edu) : array();
        $vars['maritals'] = !empty($maritals)? (array) json_decode($maritals) : array();
        $vars['gentypes'] = !empty($gentype)? (array) json_decode($gentype) : array();
        $vars['popti'] = $popti;
        $vars['warranties'] = !empty($warranties)? (array) json_decode($warranties) : array();
        $vars['region_picker'] = $this->load->view('pages/region/region-picker', $vars, true);
        
        $this->template->add_js('assets/js/thalassaemia/patient.js');
        $this->template->add_js('assets/js/thalassaemia/region.js');
        $this->template->pre_title('<i class="ti-heart-broken"></i> Pasien');
        $this->template->breadcrumbs(anchor('patients', 'Daftar Pasien'));
        
        return $vars;
    }
    
    public function index() {
        $this->access_arg('access patient-list');
        $vars['detail_info'] = $this->load->view('pages/patient/patient-detail', array(), true);
        $this->template->add_js('assets/js/thalassaemia/patient.js');
        $this->template->container_mode('container-fluid');
        $this->template->breadcrumbs('Daftar Pasien');
        $this->template->page_title('Daftar Pasien');
        $this->template->display('patient/patient-list', $vars);
    }
    
    public function collections() {
        
        $this->access_arg('access patient-list');
        $param = (object) $this->input->get();
        #print_r($param);
        
        $limit = 10;
        if (!empty($param->iDisplayLength)) {
            $limit = $param->iDisplayLength;
        }
        
        $offset = 0;
        if (!empty($param->iDisplayStart)) {
            $offset = $param->iDisplayStart;
        }
        
        $find = '';
        if (!empty($param->sSearch)) {
            $find = strtolower($param->sSearch);
        }
        
        $order = new stdClass();
        $order->cell = 'mid';
        $order->type = $param->sSortDir_0;
        
        $sid = $param->iSortCol_0;
        $sort_head = array(
            1 => 'nik', 'name', 'gender', 'blood_type', 'popti', 'unit', 'gen', 'status', 'created',
        );
        
        foreach ($sort_head as $i => $head) {
            if ($sid == $i) $order->cell = $head;
        }
        
        $data = array();
        $list = $this->patient->item_list($find, $limit, $offset, $order);
        if (!empty($list)) {
            foreach ($list as $item) {
                $items = array();
                $items['author'] = $item->author;
                $items['mid'] = $item->mid;
                $items['title'] = $item->title;
                $items['nik'] = $item->nik;
                $items['name'] = $item->name;
                $items['slug'] = $item->slug;
                $items['gen'] = $item->gen;
                $items['gender'] = $item->gender;
                $items['blood_type'] = $item->blood_type;
                $items['status'] = $item->status;
                $items['created'] = $item->created;
                $items['popti'] = $item->popti;
                $items['unit'] = $item->unit;
                $items['fid'] = $item->fid;
                $data[] = $items;
            }
        }
        
        $rows = $this->patient->item_rows($find);
        
        $vars = array(
            'iTotalDisplayRecords' => $rows->totals,
            'iTotalRecords' => $rows->totals,
            'aaData' => $data
        );
        
        echo json_encode($vars);
    }
    
    public function detail() {
        $slug   = $this->uri->segment(2);
        $nodes  = $this->fact->load($slug);
        if (!empty($nodes->fact)) {
            $nodes->fact_patient->dob = id_date_format($nodes->fact_patient->dob);
            if (!empty($nodes->fact_patient_address->villid)) {
                $terms = array('villid' => $nodes->fact_patient_address->villid);
                $region = $this->model->load_data('region_view', $terms);
                if (!empty($region)) {
                    $nodes->fact_patient_address->province = $region[0]->province;
                    $nodes->fact_patient_address->city = $region[0]->city;
                    $nodes->fact_patient_address->district = $region[0]->district;
                    $nodes->fact_patient_address->postal = $region[0]->postal;
                }
            } else {
                $nodes->fact_patient_address->villid = 0;
            }
            
            echo json_encode($nodes);
        } else {
            $this->_404();
        }
        
        exit;
    }
    
    public function add() {
        
        $this->access_arg('access patient-add');
        $this->_add_submit();
        
        $vars = $this->_patient_form_vars();
        $this->template->breadcrumbs('Tambah Data Pasien');
        $this->template->page_title('Tambah Data Pasien');
        $this->template->display('patient/patient-add', $vars);
    }
    
    public function edit() {
        
        $this->access_arg('access patient-edit');
        $this->_edit_submit();
        
        $slug   = $this->uri->segment(2);
        $nodes  = $this->fact->load($slug);
        if (empty($nodes->fact)) {
            $this->_404();
        }
        
        $vars = $this->_patient_form_vars();
        $vars['nodes']  = $nodes;
        $vars['slug']   = $slug;
        
        $rules = array('removed' => 0, 'poptid' => $nodes->fact_patient->poptid);
        $units = $this->model->load_data('popti_unit', $rules);
        $vars['units'] = $units;
        
        $this->load->model('region_model', 'region');
        $vars['region'] = $this->region->village_load($nodes->fact_patient_address->villid);
        
        $this->template->breadcrumbs('Ubah Data Pasien');
        $this->template->page_title('Ubah Data Pasien');
        $this->template->display('patient/patient-edit', $vars);
    }
    
    public function delete() {
        $this->access_arg('access patient-remove');
        $fid = $this->uri->segment(2);
        if (!empty($fid)) {
            $fact = $this->fact->get($fid);
            if (!empty($fact)) {
                $data = (object) array('sid' => 0);
                $this->fact->update($fid, $data);
                $msg = 'Data pasien <b>' . $fact->title . '</b> berhasil dihapus.';
                $this->session->set_userdata('patient_action_result', $msg);
                $this->audit('log-patient-delete', 'patient', 'menghapus data pasien <span class="text-muted">"' . $fact->title . '"</span>');
            }
        }
        
        redirect('patients');
    }
    
    public function export() {
        echo 'test';
        exit;
    }
    
    public function nik_is_duplicate($input) {
        $bool = true;
        $terms = array('nik' => $input, 'fid !=' => $this->_fid);
        $row = $this->model->load_data('fact_patient', $terms);
        if (!empty($row)) {
            $message = 'NIK sudah terdaftar. Silahkan ubah dengan NIK lain.';
            $this->form_validation->set_message('nik_is_duplicate', $message);
            $bool = false;
        }
        
        return $bool;
    }
    
    private function _post_validate($act = 'add') {
        $this->form_validation->set_rules('patient_nik', 'NIK Pasien', 'trim|required|numeric|min_length[10]|callback_nik_is_duplicate');
        $this->form_validation->set_rules('patient_name', 'Nama Lengkap', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('patient_blood_type', 'Golongan Darah', 'trim|required');
        $this->form_validation->set_rules('patient_gender', 'Jenis Kelamin', 'trim|required');
        $this->form_validation->set_rules('patient_dob', 'Tanggal Lahir', 'trim|required');
        $this->form_validation->set_rules('patient_address_phonecode', 'Kode Telepon', 'trim|required|min_length[3]');
        if ($act == 'edit') {
            $this->form_validation->set_rules('patient_cardno', 'No. Kartu Anggota', 'trim|required');
        }
        
        return $this->form_validation->run();
    }
    
    private function _post_error() {
        return array(
            'patient-nik' => $this->form_error_render('patient_nik'),
            'patient-name' => $this->form_error_render('patient_name'),
            'patient-blood-type' => $this->form_error_render('patient_blood_type'),
            'patient-gender' => $this->form_error_render('patient_gender'),
            'patient-dob' => $this->form_error_render('patient_dob'),
            'patient-address-phonecode' => $this->form_error_render('patient_address_phonecode'),
        );
    }
    
    private function _add_submit() {
        
        if (!empty($this->input->post())) {
            $post = (object) $this->input->post();
            if (!empty($post->patient_add)) {
                $code = 401;
                $errs = array();
                if (!$this->_post_validate()) {
                    $errs = $this->_post_error();
                } else {
                    $this->_save($post);
                    $code = 200;
                }
                
                $data['code'] = $code;
                $data['errors'] = $errs;
                echo json_encode($data);
            }
            
            die();
        }
    }
    
    private function _edit_submit() {
        
        if (!empty($this->input->post())) {
            $post = (object) $this->input->post();
            if (!empty($post->patient_edit)) {
                $code = 401;
                $errs = array();
                $this->_fid = $post->fact_id;
                if (!$this->_post_validate('edit')) {
                    $errs = $this->_post_error();
                    $errs['patient-cardno'] = $this->form_error_render('patient_cardno');
                } else {
                    $this->_save($post, 'edit');
                    $code = 200;
                }
                
                $data['code'] = $code;
                $data['errors'] = $errs;
                echo json_encode($data);
            }
            
            die();
        }
    }
    
    private function _member_card_number_builder($pid, $post) {
        $mid = $post->patient_address_phonecode;
        if ($mid != $post->patient_address_phonecode_fix &&
                !empty($post->patient_address_villid)) {
            $vid = $post->patient_address_villid;
            $obj = array('phonecode' => $mid);
            $this->model->record_update('region_village', $vid, $obj);
        }
        
        $mid .= '.' . $post->patient_gender . $post->patient_blood_type . '**';
        $date = explode('-', $post->patient_dob);
        $mid .= $date[2] . $date[1] . $date[0];
        $mid .= '.' . $pid;
        return $mid;
    }
    
    private function _save($post, $act = 'add') {
        
        $fid = uniqid();
        $patient = new stdClass();
        $patient->nik           = $post->patient_nik;
        $patient->name          = $post->patient_name;
        $patient->bltid         = $post->patient_blood_type;
        $patient->gid           = $post->patient_gender;
        $patient->dob           = $post->patient_dob;
        $patient->pob           = $post->patient_pob;
        $patient->father_name   = $post->patient_father_name;
        $patient->mother_name   = $post->patient_mother_name;
        $patient->poptid        = $post->patient_popti;
        $patient->gen           = $post->patient_gen_type;
        $patient->lastedu       = $post->patient_education;
        $patient->martype       = $post->patient_marital;
        $patient->marchilds     = $post->patient_childs;
        $patient->job           = $post->patient_job;
        $patient->sick_years    = $post->patient_duration_year;
        $patient->sick_months   = $post->patient_duration_month;
        $patient->cellno        = $post->patient_phone;
        $patient->warrtype      = $post->patient_warranty_type;
        $patient->warrno        = $post->patient_warranty_account_number;
        $patient->status        = $post->patient_status;
        $patient->famcardno     = $post->patient_famcardno;
        $patient->hsptid        = $post->patient_popti_hospital;
        $patient->fid           = $fid;
        $patient->mid           = $fid;
        
        if ($act == 'add') {
            $pid = $this->model->record_save('fact_patient', $patient);
            $post->patient_id = $pid;
            $this->_save_address($fid, $post);
            $mid = $this->_member_card_number_builder($pid, $post);
            $upd = array('mid' => $mid);
            $this->model->record_update('fact_patient', $pid, $upd);
            $this->_save_patient_fact($fid, $mid, $post, $act);
        } else {
            
            $patient->fid = $post->fact_id;
            $patient->mid = $post->patient_cardno;
            
            $pid = $post->patient_id;
            $this->model->record_update('fact_patient', $pid, $patient);
            $this->_save_address($patient->fid, $post, 'edit');
            $this->_save_patient_fact($patient->fid, $patient->mid, $post, 'edit');
            #print_r($post);
        }
    }
    
    private function _save_address($fid, $post, $act = 'add') {
        
        $addr = new stdClass();
        $addr->addr     = $post->patient_address_details;
        $addr->villid   = $post->patient_address_villid;
        $addr->rt       = $post->patient_address_rt;
        $addr->rw       = $post->patient_address_rw;
        $addr->phonecode= $post->patient_address_phonecode;
        
        $table = 'fact_patient_address';
        if ($act == 'add') {
            $addr->id   = $post->patient_id;
            $addr->fid  = $fid;
            $this->model->record_save($table, $addr);
        } else {
            $this->model->record_update($table, $post->patient_id, $addr);
        }
    }
    
    private function _save_patient_fact($fid, $mid, $post, $act = 'add') {
        
        $fact = new stdClass();
        $fact->title    = $mid . ' - ' . $post->patient_name;
        $fact->excerpt  = $post->patient_notes;
        $fact->token    = random_key();
        
        if ($act == 'add') {
            $fact->fid      = $fid;
            $fact->uid      = $this->authentication()->user->id;
            $fact->type     = 'patient';
            $fact->slug     = slugify($fact->title);
            $this->model->record_save('fact', $fact);
        } else {
            $fact->updated  = date('Y-m-d H:i:s');
            $this->fact->update($fid, $fact);
        }
        
        if ($act == 'add') {
            $this->audit('log-patient-add', 'patient', 'menambah data pasien <span class="text-muted">"' . $fact->title . '"</span>');
        } else {
            $this->audit('log-patient-edit', 'patient', 'mengubah data pasien <span class="text-muted">"' . $fact->title . '"</span>');
        }
    }
}
