<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Region_model extends MY_Model {
    
    private $picker_basic_terms;
    
    public function __construct() {
        parent::__construct();
        $this->_picker_basic_terms();
    }
    
    private function _picker_basic_terms() {
        $this->picker_basic_terms = array(
            'province_enabled' => 1,
            'city_enabled' => 1,
            'district_enabled' => 1,
            'village_enabled' => 1,
        );
    }
    
    private function _list_terms($find) {
        if (!empty($find)) {
            $this->db->like('province', $find);
            $this->db->or_like('city', $find);
            $this->db->or_like('district', $find);
            $this->db->or_like('village', $find);
            $this->db->or_like('phonecode', $find);
        }
    }
    
    public function picker_list($find = '', $limit = 10, $offset = 0, $order = null) {
        
        $this->db->select('*');
        $this->db->where($this->picker_basic_terms);
        $this->_list_terms($find);
        if (!empty($order)) {
            $this->db->order_by($order->cell, $order->type);
        }
        
        $src = $this->db->get('region_view', $limit, $offset);
        return $this->fetch_rows($src);
    }
    
    public function picker_rows($find = '') {
        $this->db->select('count(village) totals');
        $this->db->where($this->picker_basic_terms);
        $this->_list_terms($find);
        $src = $src = $this->db->get('region_view');
        return $this->fetch_row($src);
    }
    
    public function village_load($vid) {
        $this->picker_basic_terms['villid'] = $vid;
        return $this->load_data('region_view', $this->picker_basic_terms);
    }
}
