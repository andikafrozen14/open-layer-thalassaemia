<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base_model extends MY_Model {
    
    public function user_validate($terms = array()) {
        $this->db->select('id');
        $sources = $this->db->get_where('user', $terms);
        return $this->fetch_row($sources);
    }
    
    private function _user_select() {
        $this->db->select('user.*, r.name role_name, r.screen role_screen, m.meta_data');
        $this->db->join('user_meta m', 'm.user_id = user.id', 'left');
        $this->db->join('role r', 'r.id = user.rid', 'inner');
    }
    
    public function user_by_name($name) {
        $this->_user_select();
        $sources = $this->db->get_where('user', array('user.name' => $name));
        return $this->fetch_row($sources);
    }
        
    public function user_login($name, $password) {
        
        $terms = array(
            'user.name' => $name,
            'user.status' => 1,
            'user.locked' => 0,
            'r.status' => 1,
            'r.locked' => 0,
        );
        
        $this->_user_select();
        $sources = $this->db->get_where('user', $terms);
        $user = $this->fetch_row($sources);
        if (!empty($user)) {
            if (!password_verify($password, $user->password)) {
                $user = null;
            }
        } else {
            $user = null;
        }
        
        return $user;
    }
    
    public function user_avatar_save($id, $path, $act = 'add') {
        //print_r($path);
        $avatar = new stdClass();
        $avatar->id = $id;
        $avatar->path = $path;
        if ($act == 'add') {
            $this->db->insert('user_avatar', $avatar);
        } else {
            $this->db->where('id', $id);
            $this->db->update('user_avatar', $avatar);
        }
    }
    
    public function user_meta_save($uid, $meta, $act = 'add') {
        if ($act == 'add') {
            $this->db->insert('user_meta', $meta);
        } else {
            $this->db->where('user_id', $uid);
            $this->db->update('user_meta', $meta);
        }
    }
    
    public function user_meta($uid) {
        $this->db->select('meta_data');
        $src = $this->db->get_where('user_meta', array('user_id' => $uid));
        $row = $this->fetch_row($src);
        return !empty($row)? $row->meta_data : null;
    }
    
    public function user_list() {
        $terms = array('user.status' => 1, 'user.hidden' => false);
        $this->db->select('user.*, r.name role_name, r.screen role_screen, m.meta_data');
        $this->db->join('role r', 'r.id = user.rid', 'inner');
        $this->db->join('user_meta m', 'm.user_id = user.id', 'left');
        $sources = $this->db->get_where('user', $terms);
        return $this->fetch_rows($sources);
    }
    
    public function roles() {
        $sum = '(SELECT COUNT(*) FROM ' . $this->db->dbprefix . 'user WHERE rid = r.id) sum';
        $this->db->select('r.*, '. $sum);
        $sources = $this->db->get_where('role r', array('status' => 1, 'hidden' => 0));
        return $this->fetch_rows($sources);
    }
    
    public function role_access($rid) {
        $data = array();
        $terms = array('rid' => $rid);
        $this->db->select('code');
        $src = $this->db->get_where('role_access', $terms);
        $arr = $this->fetch_rows($src);
        if (!empty($arr)) {
            foreach ($arr as $obj) {
                array_push($data, $obj->code);
            }
        }
        
        return $data;
    }
    
    public function role_options() {
        $data = array();
        $terms = array('hidden' => false, 'status' => true);
        $this->db->select('id, screen');
        $src = $this->db->get_where('role', $terms);
        $arr = $this->fetch_rows($src);
        if (!empty($arr)) {
            foreach ($arr as $obj) {
                $data[$obj->id] = $obj->screen;
            }
        }
        
        return $data;
    }
    
    public function role_by_name($name) {
        $this->db->select('*');
        $sources = $this->db->get_where('role', array('name' => $name));
        return $this->fetch_row($sources);
    }
    
    public function perm_save($rid, $perms) {
        $this->db->delete('role_access', array('rid' => $rid));
        if (!empty($perms)) {
            if (is_array($perms) && count($perms) > 0) {
                $data = array();
                $access_setting = false;
                foreach ($perms as $perm) {
                    $data[] = array('rid' => $rid, 'code' => $perm);
                    if (strpos($perm, 'settings') != '') {
                        $access_setting = true;
                    }
                }
                
                if ($access_setting) {
                    $data[] = array('rid' => $rid, 'code' => 'access settings');
                }
                
                $this->db->insert_batch('role_access', $data);
            }
        }
    }
}
