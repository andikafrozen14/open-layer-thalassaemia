<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Screening extends MY_Controller {
    
    private $upload_error;
    private $upload_data;
    private $upload_dir;
    private $form_error;
    private $fid;
    
    public function __construct() {
        parent::__construct();
        $this->fid = uniqid();
        $this->form_error = array();
    }
    
    private function _screening_form_vars() {
        $genders    = $this->model->variable_load('genders');
        $blood_type = $this->model->variable_load('bloodtype');
        $edu        = $this->model->variable_load('edulist');
        $maritals   = $this->model->variable_load('maritals');
        $gentype    = $this->model->variable_load('gentype');
        
        $vars['gender'] = !empty($genders)? (array) json_decode($genders) : array();
        $vars['blood_type'] = !empty($blood_type)? (array) json_decode($blood_type) : array();
        $vars['edu_opts'] = !empty($edu)? (array) json_decode($edu) : array();
        $vars['maritals'] = !empty($maritals)? (array) json_decode($maritals) : array();
        $vars['gentypes'] = !empty($gentype)? (array) json_decode($gentype) : array();
        $vars['region_picker'] = $this->load->view('pages/region/region-picker', $vars, true);
        
        $this->template->add_js('assets/js/thalassaemia/screening.js');
        $this->template->add_js('assets/js/thalassaemia/region.js');
        $this->template->pre_title('<i class="ti-heart-broken"></i> Screening');
        $this->template->breadcrumbs(anchor('screening', 'Hasil Screening Pasien'));
        return $vars;
    }
    
    public function index() {
        $this->access_arg('access screening-list');
        $vars = array();
        $vars['detail_info'] = $this->load->view('pages/screening/detail', array(), true);
        $this->template->add_js('assets/js/thalassaemia/screening.js');
        $this->template->container_mode('container-fluid');
        $this->template->breadcrumbs('Daftar Hasil Screening');
        $this->template->page_title('Daftar Hasil Screening');
        $this->template->display('screening/list', $vars);
    }
    
    public function collections() {
        
        $this->access_arg('access screening-list');
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
        $order->cell = 'nik';
        $order->type = $param->sSortDir_0;
        
        $sid = $param->iSortCol_0;
        $sort_head = array(
            1 => 'name', 'sick_family', 'gender', 'blood_type', 'event', 'cellno', 'indi', 'created',
        );
        
        foreach ($sort_head as $i => $head) {
            if ($sid == $i) $order->cell = $head;
        }
        
        $data = array();
        $this->load->model('screening_model', 'screening');
        $list = $this->screening->item_list($find, $limit, $offset, $order);
        if (!empty($list)) {
            foreach ($list as $item) {
                $items = array(
                    'fid' => $item->fid,
                    'slug' => $item->slug,
                    'created' => $item->created,
                    'has_family' => $item->sick_family,
                    'nik' => $item->nik,
                    'event' => $item->event,
                    'name' => $item->name,
                    'blood_type' => $item->blood_type,
                    'gender' => $item->gender,
                    'cellno' => $item->cellno,
                    'indicate' => $item->indi,
                    'title' => $item->title,
                );
                
                $data[] = $items;
            }
        }
        
        $rows = $this->screening->item_rows($find);
        
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
            $nodes->fact_screening->dob = id_date_format($nodes->fact_screening->dob);
            
            if (!empty($nodes->fact_screening_result->doc1)) {
                $arr = explode('/', $nodes->fact_screening_result->doc1);
                $nodes->fact_screening_result->file1 = end($arr);
            } else {
                $nodes->fact_screening_result->doc1 = '';
            }
            
            if (!empty($nodes->fact_screening_result->doc2)) {
                $arr = explode('/', $nodes->fact_screening_result->doc2);
                $nodes->fact_screening_result->file2 = end($arr);
            } else {
                $nodes->fact_screening_result->doc2 = '';
            }
            
            if (!empty($nodes->fact_screening_address->villid)) {
                $terms = array('villid' => $nodes->fact_screening_address->villid);
                $region = $this->model->load_data('region_view', $terms);
                if (!empty($region)) {
                    $nodes->fact_screening_address->province = $region[0]->province;
                    $nodes->fact_screening_address->city = $region[0]->city;
                    $nodes->fact_screening_address->district = $region[0]->district;
                    $nodes->fact_screening_address->postal = $region[0]->postal;
                }
            } else {
                $nodes->fact_screening_address->villid = 0;
            }
            
            echo json_encode($nodes);
        } else {
            $this->_404();
        }
        
        exit;
    }
    
    public function add() {
        $this->access_arg('access screening-add');
        $this->_add_submit();
        $vars = $this->_screening_form_vars();
        $this->template->breadcrumbs('Tambah Hasil Screening');
        $this->template->page_title('Tambah Hasil Screening');
        $this->template->display('screening/add', $vars);
    }
    
    public function edit() {
        
        $this->access_arg('access screening-edit');
        $this->_edit_submit();
        
        $slug   = $this->uri->segment(2);
        $nodes  = $this->fact->load($slug);
        if (empty($nodes->fact)) {
            $this->_404();
        }
        
        $vars = $this->_screening_form_vars();
        $vars['nodes']  = $nodes;
        $vars['slug']   = $slug;
        
        $this->load->model('region_model', 'region');
        $region = $this->region->village_load($nodes->fact_screening_address->villid);
        if (!empty($region[0])) {
            $vars['region'] = $region[0];
        } else {
            $vars['region'] = new stdClass();
        }
        
        $this->template->breadcrumbs('Ubah Data Screening');
        $this->template->page_title('Ubah Data Screening');
        $this->template->display('screening/edit', $vars);
    }
    
    public function delete() {
        $this->access_arg('access screening-remove');
        $fid = $this->uri->segment(2);
        if (!empty($fid)) {
            $fact = $this->fact->get($fid);
            if (!empty($fact)) {
                $data = (object) array('sid' => 0);
                $this->fact->update($fid, $data);
                $msg = 'Data hasil screening <b>' . $fact->title . '</b> berhasil dihapus.';
                $this->session->set_userdata('screening_action_result', $msg);
                
                $user = $this->authentication()->user;
                $log = 'menghapus data hasil screening <span class="text-muted">"' . $fact->title . '"</span>.';
                $this->audit('log-screening-delete', 'screening', $log);
            }
        }
        
        redirect('screening');
    }
    
    public function nik_is_duplicate($input) {
        $bool = true;
        $terms = array('nik' => $input, 'fid !=' => $this->fid);
        $row = $this->model->load_data('fact_screening', $terms);
        if (!empty($row)) {
            $message = 'NIK sudah terdaftar. Silahkan ubah dengan NIK lain.';
            $this->form_validation->set_message('nik_is_duplicate', $message);
            $bool = false;
        }
        
        return $bool;
    }
    
    private function _document_uploaded($key) {
        
        $bool = true;
        if (!empty($_FILES[$key]['name'])) {
            $path = 'assets/documents/screening/' . strtoupper($this->fid) . '/';
            $this->upload_dir[$key] = $path;
            $this->upload_error[$key] = '';
            if (!file_exists($path)) {
                mkdir($path);
            }

            $config = array();
            $config['upload_path']      = $path;
            $config['allowed_types']    = 'pdf|jpg|png|jpeg';
            $config['max_size']         = 1024 * 5;
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
    
    private function _post_validate() {
        $this->form_validation->set_rules('patient_nik', 'NIK Pasien', 'trim|required|numeric|min_length[10]|callback_nik_is_duplicate');
        $this->form_validation->set_rules('patient_name', 'Nama Lengkap', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('patient_blood_type', 'Golongan Darah', 'trim|required');
        $this->form_validation->set_rules('patient_gender', 'Jenis Kelamin', 'trim|required');
        $this->form_validation->set_rules('patient_dob', 'Tanggal Lahir', 'trim|required');
        $this->form_validation->set_rules('patient_phone', 'No. Telepon', 'trim|required');
        $this->form_validation->set_rules('patient_address_details', 'Alamat Lengkap', 'trim|required');
        return $this->form_validation->run();
    }
    
    private function _basic_form_errors() {
        $this->form_error = array(
            'patient-nik' => $this->form_error_render('patient_nik'),
            'patient-name' => $this->form_error_render('patient_name'),
            'patient-blood-type' => $this->form_error_render('patient_blood_type'),
            'patient-gender' => $this->form_error_render('patient_gender'),
            'patient-dob' => $this->form_error_render('patient_dob'),
            'patient-phone' => $this->form_error_render('patient_phone'),
            'patient-address-details' => $this->form_error_render('patient_address_details'),
        );
    }
    
    private function _upload_handler() {
        if (!empty($_FILES['patient_upload_lab1']['name'])) {
            $this->_document_uploaded('patient_upload_lab1');
        }

        if (!empty($_FILES['patient_upload_lab2']['name'])) {
            $this->_document_uploaded('patient_upload_lab2');
        }

        //print_r($this->upload_error);
        if (!empty($this->upload_error['patient_upload_lab1']) || !empty($this->upload_error['patient_upload_lab2'])) {

            if (!empty($this->upload_error['patient_upload_lab1'])) {
                $this->form_error['patient-upload-lab1'] = $this->upload_error['patient_upload_lab1'];
            }

            if (!empty($this->upload_error['patient_upload_lab2'])) {
                $this->form_error['patient-upload-lab2'] = $this->upload_error['patient_upload_lab2'];
            }
        }
    }
    
    private function _add_submit() {
        
        $code = 400;
        $post = (object) $this->input->post();
        if (!empty($post->screening_add)) {
            
            $this->upload_error = $this->upload_data = $this->upload_dir = array();
            $validate = $this->_post_validate();
            $nik = trim($post->patient_nik);
            
            if (!$validate) {
                $this->_basic_form_errors();
            } else {
                $this->_upload_handler();
                if (count($this->form_error) == 0) {
                    $this->_save($post);
                    $this->session->set_userdata('last_event', $post->patient_event);
                    $code = 200;
                }
            }
            
            echo json_encode(array('code' => $code, 'errors' => $this->form_error));
            exit;
        }
    }
    
    private function _edit_submit() {
        $code = 400;
        $errs = array();
        $post = (object) $this->input->post();
        if (!empty($post->screening_edit)) {
            $this->fid = $post->fid;
            $this->upload_error = $this->upload_data = $this->upload_dir = array();
            $validate = $this->_post_validate();
            
            if (!$validate) {
                $errs = $this->_basic_form_errors();
            } else {
                
                $this->_upload_handler();
                if (count($this->form_error) == 0) {
                    $this->_save($post, 'edit');
                    $msg = 'Perubahan Data Hasil Screening berhasil diproses.';
                    $this->session->set_userdata('modif_success', $msg);
                    $code = 200;
                }
            }
            
            echo json_encode(array('code' => $code, 'errors' => $this->form_error));
            exit;
        }
    }
    
    private function _save($post, $act = 'add') {
        
        $obj = new stdClass();
        $obj->fid           = uniqid();
        $obj->sick_family   = $post->patient_inherit;
        $obj->nik_family    = $post->patient_inherit_nik;
        $obj->event         = $post->patient_event;
        $obj->famcardno     = $post->patient_famcardno;
        $obj->nik           = $post->patient_nik;
        $obj->name          = $post->patient_name;
        $obj->gid           = $post->patient_gender;
        $obj->blood_type    = $post->patient_blood_type;
        $obj->pob           = $post->patient_pob;
        $obj->dob           = $post->patient_dob;
        $obj->father_name   = $post->patient_father_name;
        $obj->mother_name   = $post->patient_mother_name;
        $obj->lastedu       = $post->patient_education;
        $obj->marital       = $post->patient_marital;
        $obj->childs        = $post->patient_childs;
        $obj->job           = $post->patient_job;
        $obj->cellno        = $post->patient_phone;
        
        if ($act == 'add') {
            $sid = $this->model->record_save('fact_screening', $obj);
            $post->screening_id = $sid;
            $this->_save_address($obj->fid, $post);
            $this->_save_screening_result($obj->fid, $post);
            $this->_save_fact($obj->fid, $obj->nik, $post);
        } else {
            $sid = $post->sid;
            $obj->fid = $post->fid;
            $this->model->record_update('fact_screening', $sid, $obj);
            $this->_save_address($obj->fid, $post, $act);
            $this->_save_screening_result($obj->fid, $post, $act);
            $this->_save_fact($obj->fid, $obj->nik, $post, $act);
        }
    }
    
    private function _save_address($fid, $post, $act = 'add') {
        
        $addr = new stdClass();
        $addr->addr     = $post->patient_address_details;
        $addr->villid   = $post->patient_address_villid;
        $addr->rt       = $post->patient_address_rt;
        $addr->rw       = $post->patient_address_rw;
        $addr->postal   = $post->patient_address_postal;
        
        $table = 'fact_screening_address';
        if ($act == 'add') {
            $addr->id   = $post->screening_id;
            $addr->fid  = $fid;
            $this->model->record_save($table, $addr);
        } else {
            $this->model->record_update($table, $post->sid, $addr);
        }
    }
    
    private function _save_screening_result($fid, $post, $act = 'add') {
        
        $item = new stdClass();
        $item->lab1 = $post->patient_lab;
        $item->hb   = $post->patient_hb;
        $item->mcv  = $post->patient_mcv;
        $item->mchc = $post->patient_mchc;
        $item->mch  = $post->patient_mch;
        $item->lab2 = $post->patient_lab_alt;
        $item->hba2 = $post->patient_hba2;
        $item->hbf  = $post->patient_hbf;
        $item->gen  = $post->patient_gen_type;
        $item->mch  = $post->patient_mch;
        if (!empty($post->patient_indicated)) {
            $item->indi = $post->patient_indicated;
        }
        
        $data = null;
        $table = 'fact_screening_result';
        if (!empty($this->upload_data['patient_upload_lab1'])) {
            $name = $this->upload_data['patient_upload_lab1']->file_name;
            $path = $this->upload_dir['patient_upload_lab1'];
            $item->doc1 = $path . $name;
            if ($act == 'edit') {
                $data = $this->model->load_by_id($table, $post->sid);
                if (!empty($data->doc1)) {
                    $doc1 = explode('/', $data->doc1);
                    if (end($doc1) != $name) {
                        if (file_exists($data->doc1)) unlink($data->doc1);
                    }
                }
            }
        }
        
        if (!empty($this->upload_data['patient_upload_lab2'])) {
            $name = $this->upload_data['patient_upload_lab2']->file_name;
            $path = $this->upload_dir['patient_upload_lab2'];
            $item->doc2 = $path . $name;
            if ($act == 'edit') {
                if (empty($data)) {
                    $data = $this->model->load_by_id($table, $post->sid);
                }
                
                if (!empty($data->doc2)) {
                    $doc2 = explode('/', $data->doc2);
                    if (end($doc2) != $name) {
                        if (file_exists($data->doc2)) unlink($data->doc2);
                    }
                }
            }
        }
        
        if ($act == 'add') {
            $item->id   = $post->screening_id;
            $item->fid  = $fid;
            $this->model->record_save($table, $item);
        } else {
            
            if (!empty($post->remove_doc1) || !empty($post->remove_doc2)) {
                $data = $this->model->load_by_id($table, $post->sid);
                if (!empty($post->remove_doc1)) {
                    $item->doc1 = null;
                    if (file_exists($data->doc1)) unlink($data->doc1);
                }

                if (!empty($post->remove_doc2)) {
                    $item->doc2 = null;
                    if (file_exists($data->doc2)) unlink($data->doc2);
                }
            }
            
            $this->model->record_update($table, $post->sid, $item);
        }
    }
    
    private function _save_fact($fid, $nik, $post, $act = 'add') {
        
        $fact = new stdClass();
        $fact->title    = $nik . ' - ' . $post->patient_name;
        $fact->excerpt  = $post->patient_notes;
        $fact->token    = random_key();
        
        if ($act == 'add') {
            $fact->fid      = $fid;
            $fact->uid      = $this->authentication()->user->id;
            $fact->type     = 'screening';
            $fact->slug     = slugify($fact->title);
            $this->model->record_save('fact', $fact);
        } else {
            $fact->updated  = date('Y-m-d H:i:s');
            $this->fact->update($fid, $fact);
        }
        
        $trail = $act == 'add' ? 'menambah' : 'memodifikasi';
        $trail = $trail . ' data screening <span class="text-muted">"' . $fact->title . '"</span>';
        if ($act == 'add') {
            $this->audit('log-screening-add', 'screening', $trail);
        } else {
            $this->audit('log-screening-edit', 'screening', $trail);
        }
    }
    
    private function _remove_dir($dir) {
        
        if (empty($_FILES['patient_upload_lab1']['name']) 
            && empty($_FILES['patient_upload_lab1']['name'])) {
            
            if (!file_exists($dir)) {
                return true;
            }

            if (!is_dir($dir)) {
                return unlink($dir);
            }

            foreach (scandir($dir) as $item) {
                if ($item == '.' || $item == '..') {
                    continue;
                }

                if (!$this->_remove_dir($dir . DIRECTORY_SEPARATOR . $item)) {
                    return false;
                }
            }

            return rmdir($dir);
        }
    }
}
