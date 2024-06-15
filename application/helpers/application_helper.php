<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('write_log')) {
	
    function write_log($message, $level = 'info', $file_prefix = 'log') {
        
        $now = DateTime::createFromFormat('U.u', microtime(true));
        $path = APPPATH . '/logs/' . $file_prefix . '-' . date('Y-m-d') .'.log';
        $print = $now->format('m-d-Y H:i:s.u')
                . ' >> ' . strtoupper($level) . ' >> ' . $message . PHP_EOL;
        file_put_contents($path, $print, FILE_APPEND);
    }
}

if ( !function_exists('load_prop')) {
    
    function load_prop($key) {
        $prop = parse_ini_file('properties.ini');
        return $prop[$key];
    }
}

if ( !function_exists('alert')) {
    
    function alert($id, $message, $type = 'success', $dismissible = false, $msg_icon = '') {
        if (!empty($message)) {
            
            $dismiss = '';
            if ($dismissible) {
                $dismiss = '<a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close"><i class="ti-close" title="Close"></i></a>';
            }
            
            $icon = '';
            if (!empty($msg_icon)) {
                $icon = '<i class="ti ti-' . $msg_icon . '"></i> ';
            }
            
            return '<div id="' . $id . '" class="alert alert-' . $type . ' alert-dismissible">
                        ' . $icon . $message . $dismiss . '
                    </div>';
        }
    }
}

if ( !function_exists('slugify')) {
    
    function slugify($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        return !empty($text)? $text : 'na';
    }
}

if ( !function_exists('bold_text')) {
    function bold_text($text) {
        return '<b>' . $text . '</b>';
    }
}

if ( !function_exists('random_key')) {
    /** UUID */
    function random_key() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}

if ( !function_exists('id_date_format')) {
    
    function id_date_format($str) {
        
        $result = '';
        if (!empty($str)) {
            $month = array(
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember',
            );

            $exp    = explode(' ', $str);
            $date   = explode('-', $exp[0]);
            $result = $date[2] . ' / '. $month[$date[1]] . ' / ' . $date[0];
            if (!empty($exp[1])) {
                $time = explode(':', $exp[1]);
                $result .= ' <small>' . $time[0] . ':' . $time[1] . '</small>';
            }
        }
        
        return $result;
    }
}