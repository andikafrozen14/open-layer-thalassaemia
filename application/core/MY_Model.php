<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    protected function fetch_row($src) {
        return $src->num_rows() > 0 ? $src->result()[0] : null;
    }
    
    protected function fetch_rows($src) {
        return $src->num_rows() > 0 ? $src->result() : null;
    }
    
    public function load_by_id($table, $id, $terms = array()) {
        $this->db->select('*');
        $this->db->from($table);
        
        $terms['id'] = $id;
        $this->db->where($terms);
        
        $sources = $this->db->get();
        return $this->fetch_row($sources);
    }
    
    public function load_data($table, $terms = array()) {
        $this->db->select('*');
        $sources = $this->db->get_where($table, $terms);
        return $this->fetch_rows($sources);
    }
    
    public function get_last_user_trail($type, $uid) {
        $terms = array('uid' => $uid, 'type' => $type);
        $this->db->select('id, activity, created');
        $this->db->order_by('created', 'desc');
        $this->db->limit(1);
        $src = $this->db->get_where('user_trail', $terms);
        return $this->fetch_row($src);
    }
    
    public function save_user_trail($uid, $type, $activity) {
        $act = new stdClass();
        $act->id = uniqid();
        $act->uid = $uid;
        $act->type = $type;
        $act->activity = $activity;
        $this->db->insert('user_trail', $act);
    }
    
    public function load_user_trail($limit = 20) {
        $this->db->select('screen, activity, created, meta_data');
        $this->db->limit($limit);
        $this->db->order_by('created', 'desc');
        $src = $this->db->get('user_trail_view');
        return $this->fetch_rows($src);
    }
    
    public function record_save($table, $object) {
        $this->db->insert($table, $object);
        return $this->db->insert_id();
    }
    
    public function record_update($table, $id, $object) {
        $this->db->where('id', $id);
        $this->db->update($table, $object);
    }
    
    public function record_save_batch($table, $collections) {
        $this->db->insert_batch($table, $collections);
    }
    
    public function variable_load($key) {
        $this->db->select('value');
        $src = $this->db->get_where('vars', array('var' => $key));
        $obj = $this->fetch_row($src);
        return !empty($obj)? $obj->value : null;
    }
    
    public function variable_save($key, $data = null) {
        $item = array('var' => $key);
        $this->db->select('var');
        $src = $this->db->get_where('vars', $item);
        if (!empty($this->fetch_row($src))) {
            $item['value'] = $data;
            $this->db->where('var', $key);
            $this->db->update('vars', $item);
        } else {
            $item['value'] = $data;
            $this->db->insert('vars', $item);
        }
    }
    
    public function count_rows($table, $field = '*', $terms = array()) {
        $this->db->select('COUNT(' . $field . ') totals');
        if (count($terms) > 0) {
            $this->db->where($terms);
        }
        
        $src = $this->db->get($table);
        return $this->fetch_row($src);
    }
    
    public function max_items($table, $ordered) {
        $this->db->select('*');
        $this->db->order_by($ordered, 'desc');
        $this->db->limit(1);
        $src = $this->db->get($table);
        return $this->fetch_row($src);
    }
}
