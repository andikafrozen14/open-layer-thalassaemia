<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="col-md-5 col-sm-12">
    <div class="card">
        <div class="card-body">
            <h3><i class="ti ti-user"></i> Form Pengguna</h3>
            <div class="divider mb-3"></div>
            <?php
            $result_data = $this->session->userdata('user_form_result_data');
            if (!empty($result_data)) {
                echo alert('user-form-submit-result', $result_data, 'success', true, 'check');
                $this->session->unset_userdata('user_form_result_data');
            }
            ?>
            <form id="user-form" action="" method="post" enctype="multipart/form-data" onsubmit="return false">
                <div class="row mb-3">
                    <div class="form-group">
                        <label class="form-label">ID Pengguna <sup>*</sup></label>
                        <?php
                        $attr = array(
                            'id' => 'user-id',
                            'class' => 'form-control',
                            'placeholder' => 'Username',
                        );

                        echo form_input('user_id', '', $attr);
                        ?>
                        <div id="error-user-id" class="error-message"></div>
                        <small class="form-hint">Spesial Karakter yang diperbolehkan: .-_@.</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <sup>*</sup></label>
                        <?php
                        $attr = array(
                            'id' => 'user-screen',
                            'class' => 'form-control'
                        );

                        echo form_input('user_screen', '', $attr);
                        ?>
                        <div id="error-user-screen" class="error-message"></div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="form-group">
                        <label class="form-label">E-mail <sup>*</sup></label>
                        <?php
                        $attr = array(
                            'id' => 'user-email',
                            'class' => 'form-control'
                        );

                        echo form_input('user_email', '', $attr);
                        ?>
                        <div id="error-user-email" class="error-message"></div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="form-group">
                        <label class="form-label">Kata Sandi <sup>*</sup></label>
                        <?php
                        $attr = array(
                            'id' => 'user-password',
                            'class' => 'form-control'
                        );

                        echo form_password('user_password', '', $attr);
                        ?>
                        <div id="error-user-password" class="error-message"></div>
                        <small class="form-hint">
                            Panjang Kata Sandi minimal 8 karakter. Spesial karakter yang diperbolehkan: !@#$%^&*-_
                        </small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="form-group">
                        <label class="form-label">Ulangi Kata Sandi <sup>*</sup></label>
                        <?php
                        $attr = array(
                            'id' => 'user-repassword',
                            'class' => 'form-control'
                        );

                        echo form_password('user_repassword', '', $attr);
                        ?>
                        <div id="error-user-repassword" class="error-message"></div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="form-group">
                        <label class="form-label">Avatar</label>
                        <?php
                        $src = 'assets/img/no-avatar.jpg';
                        if (!empty($application->app_avatar)) {
                            $src = $application->app_avatar;
                        }
                        ?>
                        <img src="<?php echo site_url($src) ?>" class="user-avatar-preview" id="avatar-preview" title="Click to upload" onclick="takeUpload()" />
                        <small class="form-hint mb-2">
                            Eksensi Diterima: jpg, jpeg, png. <br /> Ukuran Maksimum: 2MB.
                            <p id="avatar-path"></p>
                        </small>
                        <div id="error-user-avatar" class="error-message"></div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="form-group">
                        <label class="form-label">No. Telepon</label>
                        <?php
                        $attr = array(
                            'id' => 'user-phone',
                            'class' => 'form-control',
                        );

                        echo form_input('user_phone', '', $attr);
                        ?>
                        <div id="error-user-phone" class="error-message"></div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="form-group">
                        <label class="form-label">Tipe Pegguna <sup>*</sup></label>
                        <?php
                        $attr = array(
                            'id' => 'user-role',
                            'class' => 'form-select',
                        );
                        
                        $rdf = '';
                        $opts = array();
                        if (!empty($roles)) {
                            $rdf = load_prop('id_role_default');
                            foreach ($roles as $id => $screen) {
                                $opts[$id] = $screen;
                            }
                        }

                        echo form_dropdown('user_role', $opts, $rdf, $attr);
                        ?>
                        <div id="error-user-role" class="error-message"></div>
                        <small class="form-hint">
                            Tipe Pengguna menentukan akses pengguna tersebut.
                        </small>
                    </div>
                </div>

                <div class="divider mb-3"></div>
                <button class="btn btn-primary" type="submit"><i class="ti ti-arrow-circle-right"></i> Simpan</button>
                <button class="btn btn-outline-primary form-reset" type="reset"><i class="ti ti-reload"></i> Batalkan</button>
                <input type="hidden" id="user-form-action" name="user_form_action" value="add" />
                <input type="file" name="user_avatar" id="user-avatar" accept="image/png, image/jpeg, image/jpg, image/gif" class="form-control hidden" />
            </form>
        </div>
    </div>
</div>