<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="row justify-content-center">
    <div class="col-md-6 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3><i class="ti ti-pin"></i> Form Ubah Sandi</h3>
                <div class="divider mb-3"></div>
                <form id="cp-form" action="" method="post" onsubmit="return false">
                    <?php #print_r($authentication) ?>
                    <div class="row">
                        <div class="form-group">
                            <code><?php echo $authentication->user->name ?></code>
                            / <small class="text-muted"><?php echo $authentication->user->screen ?></small>
                            <div class="divider mt-3 mb-3"></div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="form-group">
                                <label class="form-label">Kata sandi saat ini <sup>*</sup></label>
                                <?php
                                $attr = array(
                                    'id' => 'user-old-password',
                                    'class' => 'form-control',
                                );
                                
                                echo form_password('user_old_password', '', $attr);
                                ?>
                                <div id="error-user-old-password" class="error-message"></div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="form-group">
                                <label class="form-label">Kata sandi baru <sup>*</sup></label>
                                <?php
                                $attr = array(
                                    'id' => 'user-new-password',
                                    'class' => 'form-control',
                                );
                                
                                echo form_password('user_new_password', '', $attr);
                                ?>
                                <div id="error-user-new-password" class="error-message"></div>
                                <small class="form-hint">
                                    Panjang Kata Sandi minimal 8 karakter. Spesial karakter yang diperbolehkan: !@#$%^&*-_
                                </small>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="form-group">
                                <label class="form-label">Ulangi sandi baru <sup>*</sup></label>
                                <?php
                                $attr = array(
                                    'id' => 'user-new-repassword',
                                    'class' => 'form-control',
                                );
                                
                                echo form_password('user_new_repassword', '', $attr);
                                ?>
                                <div id="error-user-new-repassword" class="error-message"></div>
                                <small class="form-hint">
                                    Ulangi penulisan Kata Sandi Baru.
                                </small>
                                <div class="divider mt-3"></div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit"><i class="ti ti-arrow-circle-right"></i> Simpan</button>
                    <button class="btn btn-outline-primary form-reset" type="reset"><i class="ti ti-reload"></i> Batalkan</button>
                    <div class="mb-3"></div>
                </form>
            </div>
        </div>
    </div>
</div>
