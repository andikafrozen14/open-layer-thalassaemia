<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="row justify-content-center">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body fix-layout">
                <h3>
                    <div class="col-md-10 col-sm-12"><i class="ti ti-link"></i> Form Ubah Cabang POPTI</div>
                </h3>
                <div class="divider mb-3"></div>
                <form id="popti-form-edit" action="" method="post" onsubmit="return false" class="popti-form">
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
                            echo form_input('popti_branch', $popti->branch, $attr);
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
                            echo form_textarea('popti_notes', $popti->notes, $attr);
                            ?>
                            <div id="error-popti-branch" class="error-message"></div>
                            <small class="form-hint">Keterangan terkait POPTI.</small>
                        </div>
                    </div>
                    <?php if (in_array('access popti-locking', $authentication->privileges)) { ?>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-2 col-form-label">Status</label>
                        <div class="col-md-9">
                            <?php
                            $checked = $popti->enabled == 1 ? true : false;
                            $attr = array('id' => 'popti-status', 'class' => 'form-check-input mt-2', );
                            $tick = form_checkbox('popti_status', 1, $checked, $attr);
                            echo form_label($tick . ' <span class="form-check-label mt-1">Aktif</span>', '', 'class="form-check form-check-inline"');
                            ?>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <div class="divider mb-3"></div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-2 col-form-label">Lembaga Kesehatan</label>
                        <div class="col-md-9">
                            <table class="table display table-responsive">
                                <tbody id="popti-items">
                                    <?php
                                    if (!empty ($units)) {
                                        foreach ($units as $i => $unit) { 
                                    ?>
                                    <tr>
                                        <td width="27%">
                                            <input type="text" required="required" class="form-control form-input" value="<?php echo $unit->name ?>" placeholder="Nama lembaga kesehatan (*)" />
                                            <input type="hidden" value="<?php echo $unit->id ?>" class="unit-id" />
                                        </td>
                                        <td width="68%">
                                            <textarea class="form-control autosize form-text" placeholder="Catatan khusus (Alamat / Kontak personal / No. Telepon / Email dsb)."><?php echo $unit->notes ?></textarea>
                                        </td>
                                        <td>
                                            <?php
                                            if ($i > 0) {
                                                ?>
                                            <button type="button" class="btn btn-link red-text btn-sm" title="Hapus" onclick="removeNode(this)">
                                                <i class="ti-close"></i>
                                            </button>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php }} ?>
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
                            <div class="hidden" id="popti-meta-data"><?php echo json_encode($units) ?></div>
                            <input type="hidden" id="popti-id" value="<?php echo $popti->id ?>" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>