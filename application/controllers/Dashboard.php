<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('patient_model', 'patient');
        $this->load->model('screening_model', 'screening');
    }

    public function index() {
        $this->template->page_title('Beranda');
        $this->template->pre_title('<i class="ti ti-dashboard"></i> Dashboard');
        $ud = $this->session->userdata('user_dasboard');
        if (!empty($ud)) {
            $this->template->page_title('Selamat Datang, ' . $this->authentication()->user->screen);
            $this->session->unset_userdata('user_dasboard');
        } else {
            $this->template->page_title('Beranda / Thalassaemia DB');
        }
        
        $this->template->add_js('assets/plugins/apexcharts/dist/apexcharts.min.js');
        $this->template->add_js('assets/plugins/highcharts/code/highcharts.js');
        $this->template->add_js('assets/plugins/highcharts/code/modules/series-label.js');
        $this->template->add_js('assets/plugins/highcharts/code/modules/accessibility.js');
        $this->template->display('home', $this->_dashboard_vars());
    }
    
    public function _dashboard_vars() {
        
        $vars['active_patient_data'] = $this->patient->summary_status_yearly();
        $vars['active_patient_view'] = $this->load->view('pages/dashboard/active-patients', $vars, true);
        $this->template->add_js('assets/js/thalassaemia/dashboard-active-patients.js');
        
        $vars['inactive_patient_data'] = $this->patient->summary_status_yearly(false);
        $vars['inactive_patient_view'] = $this->load->view('pages/dashboard/inactive-patients', $vars, true);
        $this->template->add_js('assets/js/thalassaemia/dashboard-inactive-patients.js');
        
        $vars['total_patient_data'] = $this->patient->summary_yearly();
        $vars['total_patient_view'] = $this->load->view('pages/dashboard/total-patients', $vars, true);
        $this->template->add_js('assets/js/thalassaemia/dashboard-total-patients.js');
        
        $vars['minor_patient_data'] = $this->patient->summary_gentype_yearly();
        $vars['minor_patient_view'] = $this->load->view('pages/dashboard/minor-patients', $vars, true);
        $this->template->add_js('assets/js/thalassaemia/dashboard-minor-patients.js');
        
        $vars['range_blood_type'] = $this->patient->range_blood_type();
        $vars['total_gender_percents'] = $this->model->load_data('percent_by_gender');
        $vars['total_blood_type_percents'] = $this->model->load_data('percent_by_blood_type');
        $vars['range_blood_type_view'] = $this->load->view('pages/dashboard/range-blood-types', $vars, true);
        $this->template->add_js('assets/js/thalassaemia/dashboard-range-blt.js');
        
        $vars['popti_totals'] = $this->patient->count_rows('popti', 'id', array('removed' => 0));
        $vars['unit_totals'] = $this->patient->count_rows('popti_unit', 'id', array('removed' => 0));
        $vars['max_unit_patient'] = $this->patient->max_items('unit_picked', 'patients');
        $vars['max_pop_unit'] = $this->patient->max_items('pop_units', 'units');
        $vars['inactive_popti'] = $this->patient->count_rows('popti', 'id', array('enabled' => 0));
        $vars['popti_view'] = $this->load->view('pages/dashboard/sum-popti', $vars, true);
        
        $vars['screening_summary'] = $this->_screening_summary();
        $vars['screening_view'] = $this->load->view('pages/screening/summary', $vars, true);

        $vars['total_per_gen'] = $this->patient->total_per_gen();
        $vars['total_per_gen_view'] = $this->load->view('pages/dashboard/total-per-gen', $vars, true);
        
        $vars['user_trails'] = $this->model->load_user_trail();
        $vars['user_trail_view'] = $this->load->view('pages/dashboard/user-trails', $vars, true);
        
        return $vars;
    }
    
    private function _screening_summary() {
        $data = array();
        $event = $this->screening->last_event();
        if (!empty($event)) {
            $event = $event->event;
            $data['event'] = $event;
            $data['by_gender'] = $this->screening->load_data('scan_by_gender', array('event' => $event));
            $data['by_blood_type'] = $this->screening->load_data('scan_by_blood_type', array('event' => $event));
            $data['by_indicate'] = $this->screening->load_data('scan_by_indicate', array('event' => $event));
            $data['by_marital'] = $this->screening->load_data('scan_by_marital', array('event' => $event));
            $data['by_fam'] = $this->screening->count_rows('scan_by_fam', 'event', array('event' => $event, 'sick_family' => 1));
            $data['size'] = $this->screening->count_rows('screening_view', 'fid', array('event' => $event));
        }
        
        return $data;
    }
}
