<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="col-8">
    <div class="card balanced-card">
        <div class="card-header">
            <h3 class="card-title"><i class="ti ti-heart-broken"></i> Rekapitulasi Screening</h3>
        </div>
        <?php
        $data = (object) $screening_summary;
        if (!empty($data->size->totals)) {
            
            $gender = array();
            if (!empty($data->by_gender)) {
                foreach ($data->by_gender as $item) {
                    $gender[$item->gender] = $item->percents;
                }
            }
            
            $blt = array();
            if (!empty($data->by_blood_type)) {
                foreach ($data->by_blood_type as $item) {
                    $blt[$item->bloodtype] = $item->percents;
                }
            }
            
            $indi = array();
            if (!empty($data->by_indicate)) {
                foreach ($data->by_indicate as $item) {
                    $indi[$item->indicated] = $item->totals;
                }
            }
            
            $marital = array();
            if (!empty($data->by_marital)) {
                foreach ($data->by_marital as $item) {
                    $marital[$item->marital] = $item->totals;
                }
            }
            
            $gender = (object) $gender;
            $blt = (object) $blt;
            $indi = (object) $indi;
        ?>
        
        <table class="table card-table table-responsive">
            <tbody>
                <tr>
                    <td>Event Terakhir</td>
                    <td>
                        <span class="text-success"><b><?php echo $data->event ?></b></span>
                    </td>
                </tr>
                <tr>
                    <td>Jumlah Data Screening</td>
                    <td>
                        <?php echo str_replace(',', '.', number_format($data->size->totals)) ?> Peserta
                    </td>
                </tr>
                <tr>
                    <td>Persentase Jenis Kelamin</td>
                    <td>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">Perempuan</small> : 
                                <?php echo !empty($gender->female)? str_replace('.00', '', $gender->female) : 0 ?>%
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Laki-Laki</small> : 
                                <?php echo !empty($gender->male)? str_replace('.00', '', $gender->male) : 0 ?>%
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Persentase Golongan Darah</td>
                    <td>
                        <div class="row">
                            <div class="col-md-3"><small class="text-muted">A</small> : <?php echo !empty($blt->A)? str_replace('.00', '', $blt->A) : 0 ?>%</div>
                            <div class="col-md-3"><small class="text-muted">B</small> : <?php echo !empty($blt->B)? str_replace('.00', '', $blt->B) : 0 ?>%</div>
                            <div class="col-md-3"><small class="text-muted">AB</small> : <?php echo !empty($blt->AB)? str_replace('.00', '', $blt->AB) : 0 ?>%</div>
                            <div class="col-md-3"><small class="text-muted">O</small> : <?php echo !empty($blt->O)? str_replace('.00', '', $blt->O) : 0 ?>%</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Jumlah Pasien Terindikasi</td>
                    <td>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">Terindikasi</small> : 
                                <?php echo !empty($indi->yes)? str_replace(',', '.', number_format($indi->yes)) : 0 ?>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Tidak Terindikasi</small> : 
                                <?php echo !empty($indi->no)? str_replace(',', '.', number_format($indi->no)) : 0 ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Jumlah Pasien dengan Status Pernikahan</td>
                    <td>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">Menikah</small> : 
                                <?php echo !empty($marital['Menikah'])? str_replace(',', '.', number_format($marital['Menikah'])) : 0 ?>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Belum Menikah</small> : 
                                <?php echo !empty($marital['Belum Menikah'])? str_replace(',', '.', number_format($marital['Belum Menikah'])) : 0 ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Jumlah Pasien Tergolong Keluarga Penyandang</td>
                    <td><?php echo str_replace(',', '.', number_format($data->by_fam->totals)) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <?php 
                                $attr = array('class' => 'btn w-100 btn-primary mt-2');
                                echo anchor('screening', 'Lihat Selengkapnya ->', $attr) 
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php } ?>
    </div>
</div>