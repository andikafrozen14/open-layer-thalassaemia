<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-body fix-layout">
                <h3>
                    <div class="row">
                        <div class="col-md-10 col-sm-12"><i class="ti ti-heart-broken"></i> Daftar Hasil Screening</div>
                        <div class="col-md-2 col-sm-12">
                            <?php
                            if (in_array('access screening-add', $authentication->privileges)) {
                                echo anchor('screening/add', '<i class="ti ti-plus"></i> Tambah Hasil Screening', array(
                                    'class' => 'btn btn-outline-info btn-sm pull-right'
                                ));
                            }
                            ?>
                        </div>
                    </div>
                </h3>
                <div class="divider mb-3"></div>
                <div class="inline-data">
                    <?php
                    $res = $this->session->userdata('screening_action_result');
                    if (!empty($res)) {
                        echo alert('screening-action-result', $res, 'success', true, 'check');
                        $this->session->unset_userdata('screening_action_result');
                    }
                    ?>
                    <table id="screening-table" class="table table-bordered display">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>P / L</th>
                                <th>Gol. Darah</th>
                                <th>Keluarga Penyandang</th>
                                <th>Indikasi</th>
                                <th>No. Telepon</th>
                                <th>Event Screening</th>
                                <th>Terdaftar</th>
                                <?php
                                if (in_array('access screening-edit', $authentication->privileges)
                                    || in_array('access screening-remove', $authentication->privileges)) {
                                    echo '<th width="1%"></th>';
                                }
                                ?>
                            </tr>
                        </thead>
                    </table>
                </div>
                <input type="hidden" id="screening-detail-slug" />
                <input type="hidden" id="user-access-edit" value="<?php echo in_array('access screening-edit', $authentication->privileges)? 1 : 0 ?>" />
                <input type="hidden" id="user-access-remove" value="<?php echo in_array('access screening-remove', $authentication->privileges)? 1 : 0 ?>" />
            </div>
        </div>
    </div>
</div>

<?php
echo $detail_info;