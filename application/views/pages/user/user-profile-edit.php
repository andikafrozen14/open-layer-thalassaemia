<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="modal modal-blur fade" id="modal-profile" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="ti ti-pencil-alt"></i> Ubah Data Akun - <?php echo $authentication->user->name ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="profile-form" action="" method="post" onsubmit="return false">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap <sup>*</sup></label>
                                <?php
                                $attr = array(
                                    'id' => 'user-screen',
                                    'class' => 'form-control',
                                );
                                
                                echo form_input('user_screen', $authentication->user->screen, $attr);
                                ?>
                                <div id="error-user-screen" class="error-message"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <label class="form-label">Email <sup>*</sup></label>
                                <?php
                                $attr = array(
                                    'id' => 'user-email',
                                    'class' => 'form-control',
                                );
                                
                                echo form_input('user_email', $authentication->user->email, $attr);
                                ?>
                                <div id="error-user-email" class="error-message"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <label class="form-label">No. Telepon</label>
                                <?php
                                $attr = array(
                                    'id' => 'user-phone',
                                    'class' => 'form-control',
                                );
                                
                                $phone = '';
                                $meta = (object) array();
                                if (!empty($account->meta_data)) {
                                    $meta = (object) json_decode($account->meta_data);
                                    if (!empty($meta->phone)) $phone = $meta->phone;
                                    if (!empty($meta->path)) $avatar = site_url($meta->path);
                                }
                                
                                echo form_input('user_phone', $phone, $attr);
                                ?>
                                <div id="error-user-phone" class="error-message"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="modal-footer mt-3">
                    <button type="reset" class="btn btn-link link-secondary form-reset" data-bs-dismiss="modal">
                        Batalkan
                    </button>
                    <button type="submit" class="btn btn-primary ms-auto btn-submit">
                        <i class="ti ti-arrow-circle-right"></i> Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>