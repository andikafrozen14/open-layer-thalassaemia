<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('xlsxwriter');
        $this->load->model('patient_model', 'patient');
    }
    
    private function _patient_form_vars() {
        $genders    = $this->model->variable_load('genders');
        $blood_type = $this->model->variable_load('bloodtype');
        $edu        = $this->model->variable_load('edulist');
        $maritals   = $this->model->variable_load('maritals');
        $gentype    = $this->model->variable_load('gentype');
        $popti      = $this->model->load_data('popti', array('removed' => 0, 'enabled' => 1));
        
        $vars['gender'] = !empty($genders)? (array) json_decode($genders) : array();
        $vars['blood_type'] = !empty($blood_type)? (array) json_decode($blood_type) : array();
        $vars['edu_opts'] = !empty($edu)? (array) json_decode($edu) : array();
        $vars['maritals'] = !empty($maritals)? (array) json_decode($maritals) : array();
        $vars['gentypes'] = !empty($gentype)? (array) json_decode($gentype) : array();
        $vars['popti'] = $popti;
        
        $this->template->add_js('assets/js/thalassaemia/patient.js');
        $this->template->add_js('assets/js/thalassaemia/exporter.js');
        $this->template->pre_title('<i class="ti-layout-list-thumb"></i> Laporan');
        $this->template->breadcrumbs(anchor('patients', 'Daftar Pasien'));
        
        return $vars;
    }
    
    public function export_patient() {
        $this->access_arg('access patient-list-export');
        $this->_export_patient_process();
        $vars = $this->_patient_form_vars();
        $this->template->breadcrumbs('Export Data Pasien');
        $this->template->page_title('Export Data Pasien');
        $this->template->display('report/export-patient', $vars);
    }
    
    private function _export_patient_filter($post) {
        
        $terms = array('fact.sid' => 1, 'fact.type' => 'patient');
        
        if ($post->patient_gender != '') {
            $terms['fact_patient.gid'] = $post->patient_gender;
        }

        if (!empty($post->patient_blood_type)) {
            $terms['fact_patient.bltid'] = $post->patient_blood_type;
        }

        if (!empty($post->patient_popti)) {
            $terms['fact_patient.poptid'] = $post->patient_popti;
        }
        
        if (!empty($post->patient_popti_hospital)) {
            $terms['fact_patient.hsptid'] = $post->patient_popti_hospital;
        }
        
        if (!empty($post->patient_gen_type)) {
            $terms['fact_patient.gen'] = $post->patient_gen_type;
        }
        
        if (!empty($post->patient_education)) {
            $terms['fact_patient.lastedu'] = $post->patient_education;
        }
        
        if (!empty($post->patient_marital)) {
            $terms['fact_patient.martype'] = $post->patient_marital;
        }
        
        if (!empty($post->patient_status)) {
            $terms['fact_patient.status'] = $post->patient_status;
        }
        
        return $terms;
    }
    
    private function _export_patient_process() {
        if (!empty($this->input->post('export_patients'))) {
            $post = (object) $this->input->post();
            $terms = $this->_export_patient_filter($post);
            $items = $this->patient->export($terms);
            $code = 404;
            $fname = '';
            if (!empty($items)) {
                
                $sheet_biodata = array(
                    'No. Kartu Anggota' => 'string',
                    'NIK' => 'string',
                    'Nama Lengkap' => 'string',
                    'Jenis Kelamin' => 'string',
                    'Tempat, Tanggal Lahir' => 'string',
                    'Gol. Darah' => 'string',
                    'No. Kartu Keluarga' => 'string',
                    'Nama Ayah' => 'string',
                    'Nama Ibu' => 'string',
                    'No. Telepon' => 'string',
                    'Pendidikan' => 'string',
                    'Pekerjaan' => 'string',
                    'Usia Diagnosa' => 'string',
                    'Status Pernikahan' => 'string',
                    'Jumlah Tanggungan' => 'string',
                    'Jaminan' => 'string',
                    'No. Jaminan' => 'string',
                    'Cabang POPTI' => 'string',
                    'Unit Kesehatan' => 'string',
                    'Status' => 'string',
                    'Terdaftar' => 'DD-MMM-YYYY HH:MM AM/PM',
                    'Catatan' => 'string',
                );
                
                $sheet_address = array(
                    'No. Kartu Anggota' => 'string',
                    'NIK' => 'string',
                    'Nama Lengkap' => 'string',
                    'Alamat Lengkap' => 'string',
                    'RT' => 'string',
                    'RW' => 'string',
                    'Kode Pos' => 'string',
                    'Provinsi' => 'string',
                    'Kota / Kabupaten' => 'string',
                    'Kecamatan' => 'string',
                    'Kelurahan' => 'string',
                );
                
                $writer = $this->xlsxwriter;
                $writer->setAuthor($this->authentication()->user->name);
                $writer->writeSheetHeader('Identitas Pasien', $sheet_biodata, ['freeze_rows' => 1, 'freeze_columns' => 1]);
                $writer->writeSheetHeader('Alamat Pasien', $sheet_address, ['freeze_rows' => 1, 'freeze_columns' => 3]);
                foreach ($items as $item) {
                    
                    $ttl = id_date_format($item->dob);
                    if (!empty($item->pob)) {
                        $ttl = $item->pob .', '. $ttl;
                    }
                    
                    $diagnose = '';
                    if (!empty($item->sick_years)) {
                        $diagnose = $item->sick_years . ' Tahun ';
                    }
                    
                    if (!empty($item->sick_months)) {
                        $diagnose .= $item->sick_months . ' Bulan.';
                    }
                    
                    $childs = $item->marchilds . ' Anak';
                    if (empty($item->marchilds)) {
                        $childs = '';
                    }
                    
                    $data = array(
                        $item->mid, $item->nik, $item->name, $item->str_gender,
                        $ttl, $item->blood_type, $item->famcardno, $item->father_name,
                        $item->mother_name, $item->cellno, $item->lastedu, $item->job,
                        $diagnose, $item->martype, $childs, $item->warrtype, $item->warrno,
                        $item->str_popti, $item->unit, $item->status, $item->created, $item->excerpt,
                    );
                    
                    $rt = '';
                    if (!empty($item->rt)) {
                        $rt = str_pad($item->rt, 3, '0', STR_PAD_LEFT);
                    }
                    
                    $rw = '';
                    if (!empty($item->rw)) {
                        $rw = str_pad($item->rw, 3, '0', STR_PAD_LEFT);
                    }
                    
                    $addr = array(
                        $item->mid, $item->nik, $item->name, $item->addr, $rt, $rw,
                        $item->postal, $item->province, $item->city, $item->district, $item->village
                    );
                    
                    $writer->writeSheetRow('Identitas Pasien', $data);
                    $writer->writeSheetRow('Alamat Pasien', $addr);
                }
                
                $code = 200;
                $fname = 'laporan-data-pasien-thalassaemia-' . date('Ymd') . '.xlsx';
                $writer->writeToFile('export/' . $fname);
                $this->audit('log-patient-export', 'export-patient', 'Meng-export data pasien thalassaemia.');
            }
            
            echo json_encode(array('code' => $code, 'fname' => $fname));
            exit;
        }
    }
}
