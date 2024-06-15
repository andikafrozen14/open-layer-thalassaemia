<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="row justify-content-center">
    <div class="col-md-12 col-sm-12">
        <div class="card fix-layout">
            <div class="card-body">
                <h3>
                    <div class="col-md-10 col-sm-12"><i class="ti ti-link"></i> Form Tambah Cabang POPTI</div>
                </h3>
                <div class="divider mb-3"></div>
                <form id="popti-form-add" action="" method="post" onsubmit="return false" class="popti-form">
                    <div class="form-group mb-3 row">
                        <label class="form-label col-2 col-form-label">Nama Cabang <sup>*</sup></label>
                        <div class="col-md-6">
                            <?php
                            $attr = array(
                                'id' => 'popti-branch', 
                                'class' => 'form-control', 
                                'autocomplete' => 'off', 
                                'autofocus' => true
                            );
                            echo form_input('popti_branch', '', $attr);
                            ?>
                            <div id="error-popti-branch" class="error-message"></div>
                            <small class="form-hint">Nama cabang POPTI.</small>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-2 col-form-label">Keterangan</label>
                        <div class="col-md-9">
                            <?php
                            $attr = array('id' => 'popti-notes', 'class' => 'form-control autosize', );
                            echo form_textarea('popti_notes', '', $attr);
                            ?>
                            <div id="error-popti-branch" class="error-message"></div>
                            <small class="form-hint">Keterangan terkait POPTI.</small>
                        </div>
                    </div>
                    
                    <div class="divider mb-3"></div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-2 col-form-label">Lembaga Kesehatan</label>
                        <div class="col-md-9">
                            <table class="table display table-responsive">
                                <tbody id="popti-items">
                                    <tr>
                                        <td width="27%">
                                            <input type="text" required="required" class="form-control form-input" placeholder="Nama lembaga kesehatan (*)" />
                                            <input type="hidden" value="" class="unit-id" />
                                        </td>
                                        <td width="68%">
                                            <textarea class="form-control autosize form-text" placeholder="Catatan khusus (Alamat / Kontak personal / No. Telepon / Email dsb)."></textarea>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                            <button type="button" class="btn btn-yellow btn-pill mb-3" id="popti-item-adder">
                                                <i class="ti ti-plus"></i> Tambah Lembaga Kesehatan
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <div class="divider mt-3 mb-3"></div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-2 col-form-label"></label>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary"><i class="ti ti-arrow-circle-right"></i> Simpan</button>
                            <button class="btn btn-outline-primary form-reset" type="reset"><i class="ti ti-reload"></i> Batalkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>