<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="row justify-content-center">
    <div class="col-md-10 col-sm-12">
        <div class="card">
            <div class="card-body fix-layout">
                <h3>
                    <div class="row">
                        <div class="col-md-10 col-sm-12"><i class="ti ti-link"></i> Daftar POPTI</div>
                        <div class="col-md-2 col-sm-12">
                            <?php
                            if (in_array('access popti-add', $authentication->privileges)) {
                                echo anchor('popti/add', '<i class="ti ti-plus"></i> Tambah POPTI', array(
                                    'class' => 'btn btn-outline-info btn-sm pull-right'
                                ));
                            }
                            ?>
                        </div>
                    </div>
                </h3>
                <div class="divider mb-3"></div>
                <div class="inline-data">
                    <table id="popti-table" class="display table-bordered">
                        <thead>
                            <tr>
                                <th>Cabang POPTI</th>
                                <th>Jumlah Lembaga Kesehatan</th>
                                <th>Terdaftar</th>
                                <?php
                                if (in_array('access popti-locking', $authentication->privileges)) {
                                    echo '<th width="15%">Aktif / non-aktif</th>';
                                }

                                if (in_array('access popti-edit', $authentication->privileges) || in_array('access popti-remove', $authentication->privileges)) {
                                    echo '<th width="5%"></th>';
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($records)) {
                                foreach ($records as $record) {
                                    ?>
                            <tr>
                                <td>
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal-popti" onclick="poptiDetails(<?php echo $record->id ?>)">
                                        <?php echo $record->branch ?>
                                    </a>
                                </td>
                                <td><span class="pull-right"><?php echo $record->size ?></span></td>
                                <td><small><?php echo $record->created ?></small></td>
                                <?php
                                if (in_array('access popti-locking', $authentication->privileges)) {
                                ?>
                                <td>
                                    <label class="form-check form-switch">
                                        <?php
                                        $tick = $record->enabled == 1 ? 'checked' : '';
                                        echo form_checkbox('', '', $tick, array(
                                            'class' => 'form-check-input',
                                            'id' => 'popti-status-' . $record->id,
                                            'onclick' => 'poptiActivate(' . $record->id . ', \'' . $record->branch . '\')',
                                        ));
                                        ?>
                                    </label>
                                </td>
                                <?php
                                } if (in_array('access popti-edit', $authentication->privileges) || in_array('access popti-remove', $authentication->privileges)) { ?>
                                <td>
                                    <?php if (in_array('access popti-edit', $authentication->privileges)) { ?>
                                        <a href="<?php echo site_url('popti/' . $record->id . '/edit') ?>" class="btn btn-sm btn-link mb-1"><i class="ti ti-pencil"></i> Ubah</a>
                                    <?php }
                                    if (in_array('access popti-remove', $authentication->privileges)) { ?>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-link red-text" 
                                           id="popti-remove-<?php echo $record->id ?>" 
                                           onclick="poptiRemove(<?php echo $record->id ?>, '<?php echo $record->branch ?>')">
                                            <i class="ti ti-close"></i> Hapus
                                        </a>
                                    <?php } ?>
                                </td>
                                <?php } ?>
                            </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<span class="hidden" id="modal-popti-id"></span>
<?php
echo $details;