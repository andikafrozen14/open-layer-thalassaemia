<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_model extends MY_Model {
    
    private $_basic_terms;
    
    public function __construct() {
        parent::__construct();
        $this->_basic_terms = array();
    }
    
    private function _list_terms($find) {
        if (!empty($find)) {
            $this->db->like('mid', $find);
            $this->db->or_like('name', $find);
            $this->db->or_like('gen', $find);
            $this->db->or_like('gender', $find);
            $this->db->or_like('blood_type', $find);
            $this->db->or_like('status', $find);
            $this->db->or_like('created', $find);
            $this->db->or_like('popti', $find);
            $this->db->or_like('unit', $find);
        }
    }
    
    public function item_list($find = '', $limit = 10, $offset = 0, $order = null) {
        
        $this->db->select('*');
        $this->db->where($this->_basic_terms);
        $this->_list_terms($find);
        if (!empty($order)) {
            $this->db->order_by($order->cell, $order->type);
        }
        
        $src = $this->db->get('patient_view', $limit, $offset);
        return $this->fetch_rows($src);
    }
    
    public function item_rows($find = '') {
        $this->db->select('count(fid) totals');
        $this->db->where($this->_basic_terms);
        $this->_list_terms($find);
        $src = $src = $this->db->get('patient_view');
        return $this->fetch_row($src);
    }
    
    public function summary_yearly() {
        $this->db->select("DATE_FORMAT(f.created, '%Y') years, COUNT(f.fid) totals");
        $this->db->join('fact f', 'f.fid = fact_patient.fid', 'inner');
        $this->db->group_by("DATE_FORMAT(f.created, '%Y')");
        $this->db->order_by('f.created');
        $terms = array('f.type' => 'patient', 'f.sid' => 1);
        $this->db->limit(20);
        $src = $this->db->get_where('fact_patient', $terms);
        return $this->fetch_rows($src);
    }
    
    public function summary_status_yearly($is_active = true) {
        $this->db->select("DATE_FORMAT(f.created, '%Y') years, COUNT(f.fid) totals");
        $this->db->join('fact f', 'f.fid = fact_patient.fid', 'inner');
        $this->db->group_by("DATE_FORMAT(f.created, '%Y')");
        $this->db->order_by('f.created');
        $stats = $is_active ? 'Aktif' : 'Tidak Aktif';
        $terms = array(
            'f.sid' => 1,
            'f.type' => 'patient', 
            'fact_patient.status' => $stats
        );
        
        $this->db->limit(20);
        $src = $this->db->get_where('fact_patient', $terms);
        return $this->fetch_rows($src);
    }
    
    public function summary_gentype_yearly($type = 'Thalassaemia Minor/Carrier') {
        $this->db->select("DATE_FORMAT(f.created, '%Y') years, COUNT(f.fid) totals");
        $this->db->join('fact f', 'f.fid = fact_patient.fid', 'inner');
        $this->db->group_by("DATE_FORMAT(f.created, '%Y')");
        $this->db->order_by('f.created');
        $terms = array(
            'f.sid' => 1,
            'f.type' => 'patient', 
            'fact_patient.gen' => $type,
        );
        
        $this->db->limit(20);
        $src = $this->db->get_where('fact_patient', $terms);
        return $this->fetch_rows($src);
    }
    
    public function range_blood_type($limit = 48) {
        $this->db->select('*');
        $this->db->limit($limit);
        $src = $this->db->get('range_blood_type');
        return $this->fetch_rows($src);
    }
    
    public function export($filter = array()) {
        
        $fields  = 'fact.excerpt, fact.created, fact_patient.*, addr.addr';
        $fields .= ', pv.gender str_gender, pv.gen str_gen, pv.blood_type, pv.popti str_popti, pv.unit';
        $fields .= ', addr.rt, addr.rw, rv.postal, rv.province, rv.city, rv.district, rv.village';
        
        $this->db->select($fields);
        $this->db->join('fact', 'fact.fid = fact_patient.fid', 'inner');
        $this->db->join('patient_view pv', 'fact.fid = pv.fid', 'inner');
        $this->db->join('fact_patient_address addr', 'addr.fid = fact.fid', 'inner');
        $this->db->join('region_view rv', 'rv.villid = addr.villid', 'inner');
        $this->db->order_by('fact_patient.mid', 'asc');
        $src = $this->db->get_where('fact_patient', $filter);
        return $this->fetch_rows($src);
    }
    
    public function total_per_gen() {
        $this->db->select('fact_patient.gen, count(f.fid) totals');
        $this->db->join('fact f', 'fact_patient.fid = f.fid', 'inner');
        $this->db->group_by('fact_patient.gen');
        $src = $this->db->get_where('fact_patient', array('f.sid' => 1));
        return $this->fetch_rows($src);
    }
}
