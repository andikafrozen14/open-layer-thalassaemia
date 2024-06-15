<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="col-md-5 col-sm-12">
    <div class="card">
        <div class="card-body">
            <h3><i class="ti ti-tag"></i> Form Tipe Pengguna</h3>
            <div class="divider mb-3"></div>
            <?php
            $result_data = $this->session->userdata('role_form_result_data');
            if (!empty($result_data)) {
                echo alert('role-form-submit-result', $result_data, 'success', true, 'check');
                $this->session->unset_userdata('role_form_result_data');
            }
            ?>
            <form id="role-form" action="" method="post" onsubmit="return false">
                <div class="row mb-3">
                    <div class="form-group">
                        <label class="form-label">Nama Tipe Pengguna <sup>*</sup></label>
                        <?php
                        $attr = array(
                            'id' => 'role-screen',
                            'class' => 'form-control',
                            'placeholder' => 'Contoh: Data Consumer',
                        );

                        echo form_input('role_screen', '', $attr);
                        ?>
                        <div class="error-message"></div>
                        <small class="form-hint">Spesial Karakter tidak diperbolehkan. Isilah dengan alfa-numerik.</small>
                    </div>
                </div>
                
                <?php if (in_array('access settings role-privilege', $authentication->privileges)) { ?>
                <div class="row mt-4">
                    <h3><i class="ti ti-check-box"></i> Pengaturan Akses Tipe Pengguna</h3>
                    <div class="divider mb-3"></div>
                    <div id="role-access-form" class="role-access-form"></div>
                </div>
                <?php } ?>
                
                <div class="mt-3 mb-3"></div>
                <button class="btn btn-primary" type="submit"><i class="ti ti-arrow-circle-right"></i> Simpan</button>
                <button class="btn btn-outline-primary form-reset" type="reset"><i class="ti ti-reload"></i> Batalkan</button>
                <input type="hidden" id="role-form-action" name="role_form_action" value="add" />
            </form>
        </div>
    </div>
</div>