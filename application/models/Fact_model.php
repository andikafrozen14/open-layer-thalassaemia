<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fact_model extends MY_Model {
    
    private function _inherit($type) {
        
        $childs = array();
        $db = $this->db->database;
        $sql = "SELECT TABLE_NAME entity FROM INFORMATION_SCHEMA.TABLES
                WHERE TABLE_NAME LIKE '%$type%' AND TABLE_SCHEMA = '$db'";
        
        $nodes = $this->fetch_rows($this->db->query($sql));
        if (!empty($nodes)) {
            $pr = $this->db->dbprefix;
            foreach ($nodes as $node) {
                $table = str_replace($pr, '', $node->entity);
                $childs[] = $table;
            }
        }
        
        return $childs;
    }
    
    public function load($slug) {
        
        $node = array();
        $args = array('slug' => $slug, 'sid > ' => 0);
        $data = $this->load_data('fact', $args);
        if (!empty($data)) {
            
            $fact = $data[0];
            $node['fact'] = $fact;
            $childs = $this->_inherit($fact->type);
            if (count($childs) > 0) {
                foreach ($childs as $table) {
                    $terms = array('fid' => $fact->fid);
                    $temps = $this->load_data($table, $terms);
                    if (!empty($temps[0])) {
                        $node[$table] = $temps[0];
                    }
                }
            }
        }
        
        return (object) $node;
    }
    
    public function update($fid, $fact) {
        $fact->updated = date('Y-m-d H:i:s');
        $this->db->where('fid', $fid);
        $this->db->update('fact', $fact);
    }
    
    public function get($fid) {
        $this->db->select('*');
        $src = $this->db->get_where('fact', array('fid' => $fid));
        return $this->fetch_row($src);
    }
}