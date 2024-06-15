<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="row justify-content-center">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3><i class="ti ti-wheelchair"></i> Form Pencarian Data Pasien</h3>
                <div class="divider mb-3"></div>
                <form id="patient-form-export" class="export-form" action="" method="post" onsubmit="return false" enctype="multipart/form-data">
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Jenis Kelamin </label>
                        <div class="col-md-4">
                            <?php
                            $opts = array('' => '-- Pilih Jenis Kelamin Pasien');
                            $attr = array('id' => 'patient-gender', 'class' => 'form-select');
                            echo form_dropdown('patient_gender', array_merge($opts, $gender), '', $attr);
                            ?>
                            <div id="error-patient-gender" class="error-message"></div>
                        </div>
                    </div>
                    <div class="divider mt-3 mb-3"></div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Golongan Darah </label>
                        <div class="col-md-4">
                            <?php
                            $opts = array('' => '-- Pilih Gol. Darah Pasien');
                            $attr = array('id' => 'patient-blood-type', 'class' => 'form-select');
                            echo form_dropdown('patient_blood_type', array_merge($opts, $blood_type), '', $attr);
                            ?>
                            <div id="error-patient-blood-type" class="error-message"></div>
                        </div>
                    </div>
                    <div class="divider mt-3 mb-3"></div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Cabang POPTI </label>
                        <div class="col-md-4">
                            <?php
                            $opts = array('0' => '-- Pilih Cabang POPTI');
                            $attr = array('id' => 'patient-popti', 'class' => 'form-select');
                            if (!empty($popti)) {
                                foreach ($popti as $pti) {
                                    $opts[$pti->id] = $pti->branch;
                                }
                            }
                            
                            echo form_dropdown('patient_popti', $opts, '', $attr);
                            ?>
                            <div id="error-patient-gender" class="error-message"></div>
                        </div>
                        <div class="col-md-4">
                            <?php
                            $opts = array('0' => '-- Pilih Lembaga Kesehatan');
                            $attr = array('id' => 'patient-popti-hospital', 'class' => 'form-select');
                            echo form_dropdown('patient_popti_hospital', $opts, '', $attr);
                            ?>
                            <div id="error-patient-popti-hospital" class="error-message"></div>
                        </div>
                    </div>
                    <div class="divider mt-3 mb-3"></div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Jenis Thalassaemia</label>
                        <div class="col-md-4">
                            <?php
                            $opts = array('' => '-- Pilih Jenis Thalassaemia');
                            $attr = array('id' => 'patient-gen-type', 'class' => 'form-select', 'value' => '');
                            echo form_dropdown('patient_gen_type', array_merge($opts, $gentypes), '', $attr);
                            ?>
                            <div id="error-patient-gen-type" class="error-message"></div>
                            <small class="form-hint">Jenis Gen Thalassaemia yang diderita pasien.</small>
                        </div>
                    </div>
                    <div class="divider mt-3 mb-3"></div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Pendidikan Terakhir</label>
                        <div class="col-md-4">
                            <?php
                            $opts = array('' => '-- Pilih LB Pendidikan Pasien');
                            $attr = array('id' => 'patient-education', 'class' => 'form-select');
                            echo form_dropdown('patient_education', array_merge($opts, $edu_opts), '', $attr);
                            ?>
                            <div id="error-patient-education" class="error-message"></div>
                            <small class="form-hint">Pendidikan terakhir seorang pasien.</small>
                        </div>
                    </div>
                    <div class="divider mt-3 mb-3"></div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Status Nikah</label>
                        <div class="col-md-4">
                            <?php
                            $opts = array('' => '-- Pilih Status Pernikahan');
                            $attr = array('id' => 'patient-marital', 'class' => 'form-select');
                            echo form_dropdown('patient_marital', array_merge($opts, $maritals), '', $attr);
                            ?>
                            <div id="error-patient-marital" class="error-message"></div>
                            <small class="form-hint">Status pernikahan pasien.</small>
                        </div>
                    </div>
                    <div class="divider mt-3 mb-3"></div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Status Pasien</label>
                        <div class="col-md-4 mt-2">
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" checked name="patient_status" value="" />
                                <span class="form-check-label">Semua</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="patient_status" value="Aktif" />
                                <span class="form-check-label">Aktif</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="patient_status" value="Tidak Aktif" />
                                <span class="form-check-label">Tidak Aktif</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="divider mb-3"></div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label"></label>
                        <div class="col-md-4">
                            <button class="btn btn-primary" type="submit"><i class="ti ti-export"></i> Export</button>
                            <span id="process-result"></span>
                            <input type="hidden" name="export_patients" value="1" />
                            <input type="file" id="temp-uploader" class="hidden" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>