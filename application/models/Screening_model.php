<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Screening_model extends MY_Model {
    
    private $_basic_terms;
    
    public function __construct() {
        parent::__construct();
        $this->_basic_terms = array();
    }
    
    private function _list_terms($find) {
        if (!empty($find)) {
            $this->db->like('sick_family', $find);
            $this->db->or_like('name', $find);
            $this->db->or_like('nik', $find);
            $this->db->or_like('gender', $find);
            $this->db->or_like('event', $find);
            $this->db->or_like('cellno', $find);
            $this->db->or_like('indi', $find);
            $this->db->or_like('created', $find);
            $this->db->or_like('blood_type', $find);
        }
    }
    
    public function item_list($find = '', $limit = 10, $offset = 0, $order = null) {
        
        $this->db->select('*');
        $this->db->where($this->_basic_terms);
        $this->_list_terms($find);
        if (!empty($order)) {
            $this->db->order_by($order->cell, $order->type);
        }
        
        $src = $this->db->get('screening_view', $limit, $offset);
        return $this->fetch_rows($src);
    }
    
    public function item_rows($find = '') {
        $this->db->select('count(fid) totals');
        $this->db->where($this->_basic_terms);
        $this->_list_terms($find);
        $src = $src = $this->db->get('screening_view');
        return $this->fetch_row($src);
    }
    
    public function last_event() {
        $this->db->select('fact_screening.event');
        $this->db->join('fact f', 'f.fid = fact_screening.fid', 'inner');
        $this->db->where(array('f.sid' => 1, 'f.type' => 'screening'));
        $this->db->order_by('f.created', 'desc');
        $this->db->limit(1);
        $src = $this->db->get('fact_screening');
        return $this->fetch_row($src);
    }
}
