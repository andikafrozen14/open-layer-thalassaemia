<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['admin_menu'] = array(
    'home' => array(
        'uri' => '/',
        'label' => 'Beranda',
        'icon' => 'ti-home',
    ),
    'patient' => array(
        'label' => 'Pasien',
        'icon' => 'ti-wheelchair',
        'args' => 'access patient-list',
        'type' => 'dropdown',
        'childs' => array(
            'list' => array(
                'uri' => 'patients',
                'label' => 'Sahabat Thalassaemia',
                'args' => 'access patient-list',
            ),
            'add' => array(
                'uri' => 'patient/add',
                'label' => 'Tambah Pasien',
                'args' => 'access patient-add',
            ),
            'export' => array(
                'uri' => 'report/patient/export',
                'label' => 'Export Data',
                'args' => 'access patient-list-export',
            ),
            'import' => array(
                'uri' => 'patient/import',
                'label' => 'Import Data',
                'args' => 'access patient-list-import',
            ),
        ),
    ),
    'screening' => array(
        'label' => 'Screening',
        'icon' => 'ti-heart-broken',
        'args' => 'access screening-list',
        'type' => 'dropdown',
        'childs' => array(
            'list' => array(
                'uri' => 'screening',
                'label' => 'Hasil Screening Pasien',
                'args' => 'access screening-list',
            ),
            'add' => array(
                'uri' => 'screening/add',
                'label' => 'Tambah Hasil screening',
                'args' => 'access screening-add',
            ),
            'export' => array(
                'uri' => 'report/screening/export',
                'label' => 'Export Data',
                'args' => 'access screening-list-export',
            ),
        ),
    ),
    'popti' => array(
        'uri' => 'popti',
        'label' => 'POPTI',
        'icon' => 'ti-link',
        'args' => 'access popti-list',
    ),
    'settings' => array(
        'label' => 'Konfigurasi',
        'icon' => 'ti-settings',
        'args' => 'access settings',
        'type' => 'dropdown',
        'childs' => array(
            'setting_apps' => array(
                'uri' => 'setting/application',
                'label' => 'Pengaturan Aplikasi',
                'args' => 'access settings application',
            ),
            'setting_user' => array(
                'uri' => 'setting/users',
                'label' => 'Pengguna',
                'args' => 'access settings user-list',
            ),
            'setting_role' => array(
                'uri' => 'setting/roles',
                'label' => 'Tipe Pengguna',
                'args' => 'access settings role-list',
            ),
            /*
            'setting_region' => array(
                'label' => 'Konfigurasi Wilayah',
                'args' => null,
                'childs' => array(
                    'setting_region_province' => array(
                        'uri' => '#',
                        'args' => null,
                        'label' => 'Master Provinsi',
                    ),
                    'setting_region_city' => array(
                        'uri' => '#',
                        'args' => null,
                        'label' => 'Master Kota / Kabupaten',
                    ),
                    'setting_region_district' => array(
                        'uri' => '#',
                        'args' => null,
                        'label' => 'Master Kecamatan',
                    ),
                    'setting_region_village' => array(
                        'uri' => '#',
                        'args' => null,
                        'label' => 'Master Kelurahan',
                    ),
                ),
            ),*/
        ),
    ),
);