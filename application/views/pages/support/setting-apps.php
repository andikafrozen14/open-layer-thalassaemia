<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="row justify-content-center">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3><i class="ti ti-panel"></i> Form Pengaturan Aplikasi</h3>
                <div class="divider mb-3"></div>
                <?php #print_r($application) ?>
                <?php $setup = json_decode($setup) ?>
                <form id="setting-form" action="" method="post" enctype="multipart/form-data" onsubmit="return false">
                    <div class="form-group mb-3 row">
                        <label class="form-label col-2 col-form-label">Nama Aplikasi <sup>*</sup></label>
                        <div class="col-md-6">
                            <?php
                            $dv = 'Open Layers';
                            $attr = array('id' => 'app-name', 'class' => 'form-control', 'autocomplete' => 'off', 'autofocus' => true);
                            echo form_input('app_name', $dv, $attr);
                            ?>
                            <div id="error-app-name" class="error-message"></div>
                            <small class="form-hint">Nama Aplikasi akan ditampilkan pada sisi kiri atas (apabila tidak terdapat image logo).</small>
                        </div>
                    </div>
                    <div class="divider mb-3"></div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-2 col-form-label">Logo Aplikasi </label>
                        <div class="col-md-6">
                            <?php
                            $attr = array('id' => 'app-logo', 'class' => 'form-control form-upload', 'accept' => 'image/png, image/jpeg, image/jpg');
                            echo form_upload('app_logo', '', $attr);
                            ?>
                            <div id="error-app-logo" class="error-message"></div>
                            <small class="form-hint">
                                Logo Aplikasi akan ditampilkan pada sisi kiri atas sebagai <b>Prioritas utama</b>.
                                <br />Ekstensi: *.png, *.jpg, *jpeg.
                                <br />Max. Size: 1MB
                            </small>
                        </div>
                        <div class="col-md-4" id="form-logo-display">
                            <?php if (!empty($setup->app_logo)) { ?>
                            <img src="<?php echo site_url($setup->app_logo) ?>" />
                            &nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-sm btn-link red-text" onclick="removeSiteLogo()" title="Hapus"><i class="ti-close"></i></button>
                            <?php 
                                echo form_hidden('app_logo_path', $setup->app_logo);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="divider mb-3"></div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-2 col-form-label">Ikon Bar </label>
                        <div class="col-md-6">
                            <?php
                            $attr = array('id' => 'app-icon', 'class' => 'form-control form-upload', 'accept' => 'image/png, image/jpeg, image/jpg, image/ico');
                            echo form_upload('app_icon', '', $attr);
                            ?>
                            <div id="error-app-icon" class="error-message"></div>
                            <small class="form-hint">
                                Ikon Bar pada jendela browser.
                                <br />Ekstensi: *.png, *.jpg, *jpeg, *.ico.
                                <br />Max. Size: 1MB
                            </small>
                        </div>
                        <div class="col-md-4" id="form-icon-display">
                            <?php if (!empty($setup->app_icon)) { ?>
                            <img src="<?php echo site_url($setup->app_icon) ?>" />
                            &nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-sm btn-link red-text" title="Hapus" onclick="removeSiteIcon()"><i class="ti-close"></i></button>
                            <?php 
                                echo form_hidden('app_icon_path', $setup->app_icon);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="divider mb-3"></div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-2 col-form-label">Standar Avatar </label>
                        <div class="col-md-6">
                            <?php
                            $attr = array('id' => 'app-avatar', 'class' => 'form-control form-upload', 'accept' => 'image/png, image/jpeg, image/jpg');
                            echo form_upload('app_avatar', '', $attr);
                            ?>
                            <div id="error-app-avatar" class="error-message"></div>
                            <small class="form-hint">
                                Tentukan standar avatar pengguna.
                                <br />Ekstensi: *.png, *.jpg, *jpeg, *.ico.
                                <br />Max. Size: 1MB
                            </small>
                        </div>
                        <div class="col-md-4" id="form-avatar-display">
                            <?php if (!empty($setup->app_avatar)) { ?>
                            <img src="<?php echo site_url($setup->app_avatar) ?>" class="avatar" />
                            &nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-sm btn-link red-text" title="Hapus" onclick="removeBasicAvatar()"><i class="ti-close"></i></button>
                            <?php 
                                echo form_hidden('app_avatar_path', $setup->app_avatar);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="divider mb-3"></div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-2 col-form-label">Pengaturan Judul Halaman <sup>*</sup></label>
                        <div class="col-md-6">
                            <?php
                            $dv = 1;
                            $attr = array('id' => 'app-page-title', 'class' => 'form-select');
                            $opts = array(
                                1 => 'Judul Halaman akan diawali dengan Nama Aplikasi',
                                2 => 'Judul Halaman tanpa diawali dengan Nama Aplikasi',
                            );
                            echo form_dropdown('app_page_title', $opts, $dv, $attr);
                            ?>
                            <div id="error-app-name" class="error-message"></div>
                        </div>
                    </div>
                    <div class="divider mb-3"></div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-2 col-form-label">Breadcrumbs</label>
                        <div class="col-md-6">
                            <?php
                            $tick = true;
                            $attr = array('id' => 'app-breadcrumbs', 'class' => 'form-check-input');
                            echo '<label for="app-breadcrumbs" class="form-check form-check-inline">';
                            echo form_checkbox('app_breadcrumbs', 1, $tick, $attr);
                            echo ' <span class="form-check-label">Tampilkan breadcrumbs / navigasi sekunder pada aplikasi.</span>';
                            echo '</label>';
                            ?>
                            <div id="error-app-name" class="error-message"></div>
                        </div>
                    </div>
                    <div class="divider mb-3"></div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-2 col-form-label">Audit Pengguna</label>
                        <div class="col-md-9">
                            <div class="row tick-log-collection">
                                <?php
                                $tick = true;
                                $attr = array('class' => 'form-check-input');
                                foreach ($logging_collection as $key => $label) {
                                    $attr['id'] = 'tick-' . $key;
                                    echo '<div class="col-md-3">';
                                    echo '<label for="' . $attr['id'] . '" class="form-check form-check-inline">';
                                    echo form_checkbox('app_tick_logging[]', $key, $tick, $attr);
                                    echo ' <span class="form-check-label">' . $label . '</span>';
                                    echo '</label>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                            <small class="form-hint mt-3">Tentukan pencatatan / audit pada setiap aktifitas pengguna.</small>
                        </div>
                    </div>
                    
                    <div class="divider mb-3"></div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-2 col-form-label"></label>
                        <div class="col-md-4">
                            <input type="hidden" name="setting_apps" value="1" />
                            <button class="btn btn-primary" type="submit"><i class="ti ti-arrow-circle-right"></i> Simpan</button>
                            <button class="btn btn-outline-primary form-reset" onclick="location.href=window.location.href" type="reset"><i class="ti ti-reload"></i> Batalkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>