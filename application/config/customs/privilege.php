<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$config['privileges'] = array(
    'setting_apps' => array(
        'label' => 'Pengaturan Aplikasi',
        'icon' => 'ti-settings',
        'list' => array(
            array('key' => 'access settings application', 'desc' => 'Otoritas halaman konfigurasi aplikasi.'),
        ),
    ),
    'setting_user' => array(
        'label' => 'Manajemen Pengguna',
        'icon' => 'ti-user',
        'list' => array(
            array('key' => 'access settings user-list', 'desc' => 'Otoritas halaman <i>list</i> akun pengguna.'),
            array('key' => 'access settings user-add', 'desc' => 'Otoritas menambah akun pengguna baru.'),
            array('key' => 'access settings user-edit', 'desc' => 'Otoritas mengubah akun pengguna.'),
            array('key' => 'access settings user-locking', 'desc' => 'Otoritas untuk mengaktifkan atau non-aktifkan akun pengguna.'),
            array('key' => 'access settings user-remove', 'desc' => 'Otoritas Hapus akun pengguna.'),
        ),
    ),
    'setting_role' => array(
        'label' => 'Manajemen Role',
        'icon' => 'ti-layers-alt',
        'hidden' => true,
        'list' => array(
            array('key' => 'access settings role-list', 'desc' => 'Otoritas halaman <i>list</i> tipe pengguna.'),
            array('key' => 'access settings role-add', 'desc' => 'Otoritas tambah tipe pengguna baru.'),
            array('key' => 'access settings role-edit', 'desc' => 'Otoritas ubah tipe pengguna.'),
            array('key' => 'access settings role-locking', 'desc' => 'Otoritas untuk mengaktifkan / Non-aktifkan tipe pengguna.'),
            array('key' => 'access settings role-remove', 'desc' => 'Otoritas hapus tipe pengguna.'),
            array('key' => 'access settings role-privilege', 'desc' => 'Otoritas pengaturan akses tipe pengguna.'),
        ),
    ),
    'patient' => array(
        'label' => 'Manajemen Data Pasien',
        'icon' => 'ti-wheelchair',
        'list' => array(
            array('key' => 'access patient-list', 'desc' => 'Otoritas halaman <i>list</i> pasien thalassaemia.'),
            array('key' => 'access patient-add', 'desc' => 'Otoritas tambah data pasien thalassaemia baru.'),
            array('key' => 'access patient-edit', 'desc' => 'Otoritas ubah data pasien thalassaemia.'),
            array('key' => 'access patient-remove', 'desc' => 'Otoritas hapus data pasien thalassaemia.'),
            array('key' => 'access patient-list-export', 'desc' => 'Otoritas export <i>list</i> pasien thalassaemia.'),
            array('key' => 'access patient-list-import', 'desc' => 'Otoritas import data pasien thalassaemia.'),
        ),
    ),
    'screening' => array(
        'label' => 'Manajemen Data Hasil Screening',
        'icon' => 'ti-heart-broken',
        'list' => array(
            array('key' => 'access screening-list', 'desc' => 'Otoritas halaman <i>list</i> hasil screening.'),
            array('key' => 'access screening-add', 'desc' => 'Otoritas tambah data screening.'),
            array('key' => 'access screening-edit', 'desc' => 'Otoritas ubah data screenig.'),
            array('key' => 'access screening-remove', 'desc' => 'Otoritas hapus data screenig.'),
            array('key' => 'access screening-list-export', 'desc' => 'Otoritas export <i>list</i> screenig.'),
            array('key' => 'access screening-list-import', 'desc' => 'Otoritas import data screenig.'),
        ),
    ),
    'popti' => array(
        'label' => 'Manajemen Data POPTI',
        'icon' => 'ti-link',
        'list' => array(
            array('key' => 'access popti-list', 'desc' => 'Otoritas halaman <i>list</i> POPTI.'),
            array('key' => 'access popti-add', 'desc' => 'Otoritas tambah data POPTI.'),
            array('key' => 'access popti-edit', 'desc' => 'Otoritas ubah data POPTI.'),
            array('key' => 'access popti-remove', 'desc' => 'Otoritas hapus data POPTI.'),
            array('key' => 'access popti-locking', 'desc' => 'Otoritas aktif / non-aktifkan data POPTI.'),
        ),
    ),
);