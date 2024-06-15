<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Region extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('region_model', 'region');
    }
    
    public function pick_list() {
        
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
        $order->cell = 'province';
        $order->type = $param->sSortDir_0;
        
        $sid = $param->iSortCol_0;
        switch ($sid) {
            case 2:
                $order->cell = 'city';
                break;
            case 3:
                $order->cell = 'district';
                break;
            case 4:
                $order->cell = 'village';
                break;
            case 5:
                $order->cell = 'postal';
                break;
        }
        
        $data = array();
        $list = $this->region->picker_list($find, $limit, $offset, $order);
        if (!empty($list)) {
            foreach ($list as $item) {
                $items = array();
                $items['province'] = $item->province;
                $items['city'] = $item->city;
                $items['district'] = $item->district;
                $items['village'] = $item->village;
                $items['postal'] = $item->postal;
                $items['postal'] = $item->postal;
                $items['province_id'] = $item->provid;
                $items['city_id'] = $item->citid;
                $items['district_id'] = $item->distid;
                $items['village_id'] = $item->villid;
                $items['phone_code'] = $item->phonecode;
                $data[] = $items;
            }
        }
        
        $rows = $this->region->picker_rows($find);
        
        $vars = array(
            'iTotalDisplayRecords' => $rows->totals,
            'iTotalRecords' => $rows->totals,
            'aaData' => $data
        );
        
        echo json_encode($vars);
    }
}