<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="row justify-content-center">
    <div class="col-10">
        <div class="card">
            <div class="card-body">
                <h3><i class="ti ti-user"></i> <?php echo $account->screen . ' / ' . $account->role_screen ?></h3>
                <div class="divider mb-3"></div>
                <?php
                $phone = '-';
                $avatar = site_url(load_prop('no_avatar_default'));
                $meta = (object) array();
                if (!empty($account->meta_data)) {
                    $meta = (object) json_decode($account->meta_data);
                    if (!empty($meta->phone)) $phone = $meta->phone;
                    if (!empty($meta->path)) $avatar = site_url($meta->path);
                }
                ?>
                <div id="profile-alert">
                    <?php
                    $form_status = $this->session->userdata('profile_edit_success');
                    if (!empty($form_status)) {
                        $msg = 'Akun Anda berhasil diperbarui.';
                        echo alert('profile-form-submit-result', $msg, 'success', true, 'check');
                        $this->session->unset_userdata('profile_edit_success');
                    }
                    ?>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4 col-sm-12">
                        <div class="text-center">
                            <img src="<?php echo $avatar ?>" id="avatar-preview" class="avatar-preview user-avatar img-uploader" title="Klik untuk ubah avatar" />
                            <input type="hidden" id="img-url-hide" value="<?php echo $avatar ?>" />
                        </div>
                        <?php
                        if ($authentication->user->name == $account->name) {
                            echo form_open_multipart('update-profile/avatar', array('id' => 'avatar-form', 'class' => 'mt-4'));
                            $result = $this->session->userdata('upload_success');
                            if (!empty($result)) {
                                echo '<div class="success-message"><i class="ti ti-check"></i> Avatar berhasil diubah.</div>';
                                $this->session->unset_userdata('upload_success');
                            }
                            
                            echo form_hidden('user_id', $account->name);
                            echo form_label('Ubah Avatar', '', array('class' => 'mb-1 form-label'));
                            echo form_upload('user_avatar', '', array('id' => 'user-avatar', 'accept' => 'image/png, image/jpeg, image/jpg, image/gif'));
                            echo ul(array(
                                'Eksensi Diterima: jpg, jpeg, png.', 'Ukuran Maksimum: 2MB.'
                            ), array('class' => 'mt-3'));
                            echo '<button id="btn-uploader" disabled class="btn btn-primary"><i class="ti ti-upload"></i> Unggah Avatar</button>';
                            echo form_close();
                        }
                        ?>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">ID Pengguna</label></div>
                            <div class="col-md-9" id="item-user-name"><?php echo $account->name ?></div>
                        </div>
                        <div class="divider mt-2 mb-3"></div>
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Nama Lengkap</label></div>
                            <div class="col-md-9" id="item-user-screen"><?php echo $account->screen ?></div>
                        </div>
                        <div class="divider mt-2 mb-3"></div>
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Email</label></div>
                            <div class="col-md-9" id="item-user-name"><?php echo '<a href="mailto:'.$account->email.'">'.$account->email.'</a>' ?></div>
                        </div>
                        <div class="divider mt-2 mb-3"></div>
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Terdaftar</label></div>
                            <div class="col-md-9" id="item-user-created"><?php echo id_date_format($account->created) ?></div>
                        </div>
                        <div class="divider mt-2 mb-3"></div>
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Tipe Pengguna</label></div>
                            <div class="col-md-9" id="item-user-role-screen"><?php echo $account->role_screen ?></div>
                        </div>
                        <div class="divider mt-2 mb-3"></div>
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">No. Telepon</label></div>
                            <div class="col-md-9" id="item-user-phone"><?php echo $phone ?></div>
                        </div>
                        <div class="divider mt-2 mb-3"></div>
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Status Akun</label></div>
                            <div class="col-md-9">
                                <?php
                                echo $account->locked == 1 ? '<span class="error-message">Terkunci</span>' : '<code>Aktif</code>';
                                ?>
                            </div>
                        </div>
                        <div class="divider mt-2 mb-3"></div>
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Login Terakhir</label></div>
                            <div class="col-md-9"><?php echo !empty($last_login)? id_date_format($last_login->created) : '-'; ?></div>
                        </div>
                        <div class="divider mt-2 mb-3"></div>
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Modifikasi Terakhir</label></div>
                            <div class="col-md-9"><?php echo !empty($account->updated)? id_date_format($account->updated) : '-'; ?></div>
                        </div>
                    </div>
                </div>
                <?php if ($authentication->user->name == $this->uri->segment(2)) { ?>
                <div class="divider mt-2 mb-3"></div>
                <div class="text-center mb-3">
                    <a href="<?php echo site_url() ?>" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-profile">Ubah Data</a>
                    <a href="<?php echo site_url('update-password') ?>" class="btn btn-outline-warning">Ganti Sandi</a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php
if (!empty($profile_form)) {
    echo $profile_form;
}