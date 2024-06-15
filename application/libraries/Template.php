<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template {
    
    private $OP;
    private $pre_title;
    private $page_title;
    private $breadcrumbs;
    private $auth;
    private $additional_css;
    private $additional_js;
    private $access_key;
    private $page;
    private $container_mode;
    
    public function __construct() {
        $this->OP = &get_instance();
        $this->auth = $this->OP->session->userdata('user_auth');
        $this->additional_css = array();
        $this->additional_js = array();
        $this->breadcrumbs = array();
        $this->container_mode = 'container-xl';
    }
    
    public function display($page, $vars = array()) {
        
        $this->page = $page;
        
        $vars['application']    = $this->OP->session->userdata('app_setup');
        $vars['page_title']     = $this->page_title;
        $vars['pre_title']      = $this->pre_title;
        $vars['breadcrumbs']    = $this->breadcrumbs;
        $vars['authentication'] = $this->auth;
        $vars['container_mode'] = $this->container_mode;
        
        $prebody = null;
        if (!empty($this->page_title) || !empty($this->breadcrumbs)) {
            $prebody = $this->OP->load->view('wrapper/wrap-prebody', $vars, true);
        }
        
        $vars['js_list'] = $this->additional_js;
        $vars['css_list'] = $this->additional_css;
        
        $this->OP->config->load('customs/admin_menu');
        $vars['admin_menu'] = $this->OP->config->item('admin_menu');
        
        $vars['wrap_css']       = $this->OP->load->view('wrapper/wrap-css', $vars, true);
        $vars['wrap_header']    = $this->OP->load->view('wrapper/wrap-header', $vars, true);
        $vars['wrap_prebody']   = $prebody;
        $vars['wrap_content']   = $this->OP->load->view('pages/' . $this->page, $vars, true);
        $vars['wrap_footer']    = $this->OP->load->view('wrapper/wrap-footer', $vars, true);
        $vars['wrap_js']        = $this->OP->load->view('wrapper/wrap-js', $vars, true);
        
        $this->OP->load->view('wrapper/wrapper', $vars);
    }
    
    public function add_css($path) {
        $this->additional_css[] = $path;
    }
    
    public function add_js($path) {
        $this->additional_js[] = $path;
    }
    
    public function pre_title($pre_title = '') {
        $this->pre_title = $pre_title;
    }
    
    public function page_title($page_title = '') {
        $this->page_title = $page_title;
    }
    
    public function breadcrumbs($breadcrumbs = '') {
        $this->breadcrumbs[] = $breadcrumbs;
    }
    
    public function container_mode($mode = 'container-xl') {
        $this->container_mode = $mode;
    }
}
