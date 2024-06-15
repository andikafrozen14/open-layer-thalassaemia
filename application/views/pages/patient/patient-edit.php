<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="row justify-content-center">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3><i class="ti ti-wheelchair"></i> Form Ubah Data Pasien</h3>
                <div class="divider mb-3"></div>
                <form id="patient-form-edit" class="patient-form" action="" method="post" onsubmit="return false">
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">NIK Pasien <sup>*</sup></label>
                        <div class="col-md-8">
                            <?php
                            $attr = array(
                                'id' => 'patient-nik', 
                                'class' => 'form-control', 
                                'autocomplete' => 'off', 
                                'autofocus' => true,
                            );
                            echo form_input('patient_nik', $nodes->fact_patient->nik, $attr);
                            ?>
                            <div id="error-patient-nik" class="error-message"></div>
                            <small class="form-hint">No. KTP / No. NIK pada Kartu Keluarga / No. Passport.</small>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">No. Kartu Anggota <sup>*</sup></label>
                        <div class="col-md-8">
                            <?php
                            $attr = array('id' => 'patient-cardno', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_cardno', $nodes->fact_patient->mid, $attr);
                            ?>
                            <div id="error-patient-cardno" class="error-message"></div>
                            <small class="form-hint">No. Barcode pada kartu anggota.</small>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">No. Kartu Keluarga</label>
                        <div class="col-md-8">
                            <?php
                            $attr = array('id' => 'patient-family-cardno', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_famcardno', $nodes->fact_patient->famcardno, $attr);
                            ?>
                            <div id="error-patient-cardno" class="error-message"></div>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Nama Lengkap <sup>*</sup></label>
                        <div class="col-md-8">
                            <?php
                            $attr = array('id' => 'patient-name', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_name', $nodes->fact_patient->name, $attr);
                            ?>
                            <div id="error-patient-name" class="error-message"></div>
                            <small class="form-hint">Nama lengkap penyandang thalassaemia.</small>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Jenis Kelamin <sup>*</sup></label>
                        <div class="col-md-4">
                            <?php
                            $opts = array('' => '-- Pilih Jenis Kelamin Pasien');
                            $attr = array('id' => 'patient-gender', 'class' => 'form-select');
                            echo form_dropdown('patient_gender', array_merge($opts, $gender), $nodes->fact_patient->gid, $attr);
                            ?>
                            <div id="error-patient-gender" class="error-message"></div>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Golongan Darah <sup>*</sup></label>
                        <div class="col-md-4">
                            <?php
                            $opts = array('' => '-- Pilih Gol. Darah Pasien');
                            $attr = array('id' => 'patient-blood-type', 'class' => 'form-select');
                            echo form_dropdown('patient_blood_type', array_merge($opts, $blood_type), $nodes->fact_patient->bltid, $attr);
                            ?>
                            <div id="error-patient-blood-type" class="error-message"></div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Tempat / Tanggal Lahir</label>
                        <div class="col-md-4">
                            <?php
                            $attr = array('id' => 'patient-pob', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_pob', $nodes->fact_patient->pob, $attr);
                            ?>
                            <div id="error-patient-pob" class="error-message"></div>
                            <small class="form-hint">Tempat Lahir.</small>
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" id="patient-dob" name="patient_dob" autocomplete="off" value="<?php echo $nodes->fact_patient->dob ?>" />
                            <div id="error-patient-dob" class="error-message"></div>
                            <small class="form-hint">Tanggal Lahir. <sup>*</sup></small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Nama Orang Tua</label>
                        <div class="col-md-4">
                            <?php
                            $attr = array('id' => 'patient-father-name', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_father_name', $nodes->fact_patient->father_name, $attr);
                            ?>
                            <div id="error-patient-dob" class="error-message"></div>
                            <small class="form-hint">Nama Ayah.</small>
                        </div>
                        <div class="col-md-4">
                            <?php
                            $attr = array('id' => 'patient-mother-name', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_mother_name', $nodes->fact_patient->mother_name, $attr);
                            ?>
                            <div id="error-patient-phone" class="error-message"></div>
                            <small class="form-hint">Nama Ibu.</small>
                        </div>
                    </div>
                    <div class="divider mt-3 mb-3"></div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Alamat Pasien</label>
                        <div class="col-md-8">
                            <button class="btn btn-info w-100 mb-3" type="button" data-bs-toggle="modal" data-bs-target="#modal-region">
                                <i class="ti ti-location-pin"></i> Ambil Lokasi Wilayah
                            </button>
                        </div>
                        <label class="form-label col-3 col-form-label">&nbsp;</label>
                        <div class="col-md-4">
                            <?php
                            $attr = array('class' => 'form-control', 'disabled' => true, 'id' => 'address-province', 'placeholder' => 'Provinsi');
                            echo form_input('address_province', $region[0]->province, $attr);
                            ?>
                            <input type="hidden" name="patien_address_provid" id="patient-address-provid" value="<?php echo $region[0]->provid ?>" />
                        </div>
                        <div class="col-md-4">
                            <?php
                            $attr = array('class' => 'form-control', 'disabled' => true, 'id' => 'address-city', 'placeholder' => 'Kota / Kabupaten');
                            echo form_input('address_city', $region[0]->city, $attr);
                            ?>
                            <input type="hidden" name="patien_address_citid" id="patient-address-citid" value="<?php echo $region[0]->citid ?>" />
                        </div>
                        <label class="form-label col-3 mt-3 col-form-label">&nbsp;</label>
                        <div class="col-md-4 mb-3 mt-3">
                            <?php
                            $attr = array('class' => 'form-control', 'disabled' => true, 'id' => 'address-district', 'placeholder' => 'Kecamatan');
                            echo form_input('address_district', $region[0]->district, $attr);
                            ?>
                            <input type="hidden" name="patien_address_distid" id="patient-address-distid" value="<?php echo $region[0]->distid ?>" />
                        </div>
                        <div class="col-md-4 mt-3">
                            <?php
                            $attr = array('class' => 'form-control', 'disabled' => true, 'id' => 'address-village', 'placeholder' => 'Kelurahan');
                            echo form_input('address_village', $region[0]->village, $attr);
                            ?>
                            <input type="hidden" name="patien_address_villid" id="patient-address-villid" value="<?php echo $region[0]->villid ?>" />
                        </div>
                        <label class="form-label col-3 col-form-label">&nbsp;</label>
                        <div class="col-md-8">
                            <?php
                            $attr = array(
                                'class' => 'form-control autosize', 
                                'id' => 'patient-address-details', 
                                'placeholder' => 'Rincian lengkap alamat pasien.',
                            );
                            echo form_textarea('patien_address_details', $nodes->fact_patient_address->addr, $attr);
                            ?>
                            <div id="error-patient-address" class="error-message"></div>
                        </div>
                        <label class="form-label col-3 col-form-label">&nbsp;</label>
                        <div class="col-md-2 mt-3">
                            <input type="number" id="patient-address-rt" class="form-control" name="patient_address_rt" value="<?php echo $nodes->fact_patient_address->rt ?>" />
                            <small class="form-hint">RT.</small>
                        </div>
                        <div class="col-md-2 mt-3">
                            <input type="number" id="patient-address-rw" class="form-control" name="patient_address_rw" value="<?php echo $nodes->fact_patient_address->rw ?>" />
                            <small class="form-hint">RW.</small>
                        </div>
                        <div class="col-md-2 mt-3">
                            <input type="text" id="patient-address-postal" class="form-control" name="patient_address_postal" value="<?php echo $region[0]->postal ?>" />
                            <small class="form-hint">Kode Pos.</small>
                        </div>
                        <div class="col-md-2 mt-3">
                            <input type="text" id="patient-address-phonecode" class="form-control" name="patient_address_phonecode" value="<?php echo $nodes->fact_patient_address->phonecode ?>" />
                            <small class="form-hint">Kode Telepon. <sup>*</sup></small>
                            <div id="error-patient-address-phonecode" class="error-message"></div>
                            <input type="hidden" id="patient-address-phonecode-fix" value="<?php echo $nodes->fact_patient_address->phonecode ?>" />
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
                            
                            echo form_dropdown('patient_popti', $opts, $nodes->fact_patient->poptid, $attr);
                            ?>
                            <div id="error-patient-popti" class="error-message"></div>
                        </div>
                        <div class="col-md-4">
                            <?php
                            $dv = $nodes->fact_patient->hsptid;
                            $opts = array('0' => '-- Pilih Lembaga Kesehatan');
                            if (!empty($units)) {
                                foreach ($units as $unit) {
                                    $opts[$unit->id] = $unit->name;
                                }
                            }
                            
                            $attr = array('id' => 'patient-popti-hospital', 'class' => 'form-select');
                            echo form_dropdown('patient_popti_hospital', $opts, $dv, $attr);
                            ?>
                            <div id="error-patient-popti-hospital" class="error-message"></div>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Usia Diagnosa</label>
                        <div class="col-md-2">
                            <input type="number" id="patient-duration-year" name="patient_duration_year" class="form-control" value="<?php echo $nodes->fact_patient->sick_years ?>" />
                            <div id="error-patient-duration-year" class="error-message"></div>
                            <small class="form-hint">Total Tahun.</small>
                        </div>
                        <div class="col-md-2">
                            <input type="number" id="patient-duration-month" name="patient_duration_month" class="form-control" value="<?php echo $nodes->fact_patient->sick_months ?>" />
                            <div id="error-patient-duration-month" class="error-message"></div>
                            <small class="form-hint">Total Bulan.</small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Jenis Thalassaemia</label>
                        <div class="col-md-4">
                            <?php
                            $opts = array('' => '-- Pilih Jenis Thalassaemia');
                            $attr = array('id' => 'patient-gen-type', 'class' => 'form-select', 'value' => '');
                            echo form_dropdown('patient_gen_type', array_merge($opts, $gentypes), $nodes->fact_patient->gen, $attr);
                            ?>
                            <div id="error-patient-gen-type" class="error-message"></div>
                            <small class="form-hint">Jenis Gen Thalassaemia yang diderita oleh pasien.</small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Pendidikan Terakhir</label>
                        <div class="col-md-4">
                            <?php
                            $opts = array('' => '-- Pilih LB Pendidikan Pasien');
                            $attr = array('id' => 'patient-education', 'class' => 'form-select');
                            echo form_dropdown('patient_education', array_merge($opts, $edu_opts), $nodes->fact_patient->lastedu, $attr);
                            ?>
                            <div id="error-patient-education" class="error-message"></div>
                            <small class="form-hint">Pendidikan terakhir seorang pasien.</small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Status Nikah</label>
                        <div class="col-md-4">
                            <?php
                            $opts = array('' => '-- Pilih Status Pernikahan');
                            $attr = array('id' => 'patient-marital', 'class' => 'form-select');
                            echo form_dropdown('patient_marital', array_merge($opts, $maritals), $nodes->fact_patient->martype, $attr);
                            ?>
                            <div id="error-patient-marital" class="error-message"></div>
                            <small class="form-hint">Status pernikahan pasien.</small>
                        </div>
                        <div id="patient-childs-input" class="col-md-2">
                            <input type="number" class="form-control" name="patient_childs" id="patient-childs" value="<?php echo $nodes->fact_patient->marchilds ?>" />
                            <div id="error-patient-childs" class="error-message"></div>
                            <small class="form-hint">Jumlah Anak.</small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Pekerjaan Pasien</label>
                        <div class="col-md-8">
                            <?php
                            $attr = array('id' => 'patient-job', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_job', $nodes->fact_patient->job, $attr);
                            ?>
                            <div id="error-patient-job" class="error-message"></div>
                            <small class="form-hint">Pekerjaan pasien saat ini.</small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Jaminan Pasien</label>
                        <div class="col-md-4">
                            <?php
                            $opts = array('' => '-- Pilih Jenis Jaminan Pasien');
                            $attr = array('id' => 'patient-warranty-type', 'class' => 'form-select');
                            echo form_dropdown('patient_warranty_type', array_merge($opts, $warranties), $nodes->fact_patient->warrtype, $attr);
                            ?>
                            <div id="error-patient-warranty-type" class="error-message"></div>
                            <small class="form-hint">Jenis jaminan pasien.</small>
                        </div>
                        <div id="patient-childs-input" class="col-md-4">
                            <?php
                            $attr = array('id' => 'patient-warranty-account-number', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_warranty_account_number', $nodes->fact_patient->warrno, $attr);
                            ?>
                            <div id="error-patient-warranty-account-number" class="error-message"></div>
                            <small class="form-hint">No. Akun Jaminan.</small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">No. Telepon</label>
                        <div class="col-md-4">
                            <?php
                            $attr = array('id' => 'patient-phone', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_phone', $nodes->fact_patient->cellno, $attr);
                            ?>
                            <div id="error-patient-phone" class="error-message"></div>
                            <small class="form-hint">No. Telepon Pasien yang dapat dihubungi.</small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Status Pasien</label>
                        <div class="col-md-4 mt-2">
                            <label class="form-check form-check-inline">
                                <?php $tick = $nodes->fact_patient->status == 'Aktif' ? 'checked' : '' ?>
                                <input class="form-check-input" type="radio" <?php echo $tick ?> name="patient_status" value="Aktif" />
                                <span class="form-check-label">Aktif</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <?php $tick = $nodes->fact_patient->status == 'Non-Aktif' ? 'checked' : '' ?>
                                <input class="form-check-input" type="radio" <?php echo $tick ?> name="patient_status" value="Non-Aktif" />
                                <span class="form-check-label">Tidak Aktif</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Catatan Opsional</label>
                        <div class="col-md-8">
                            <?php
                            $attr = array('id' => 'patient-notes', 'class' => 'form-control autosize');
                            echo form_textarea('patien_notes', $nodes->fact->excerpt, $attr);
                            ?>
                            <small class="form-hint">Catatan opsional untuk pasien bila ada.</small>
                        </div>
                    </div>
                    
                    <div class="divider mb-3"></div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label"></label>
                        <div class="col-md-4">
                            <input type="hidden" name="patient_edit" id="patient-edit" value="1" />
                            <input type="hidden" name="fact_id" id="fact-id" value="<?php echo $nodes->fact->fid ?>" />
                            <input type="hidden" name="fact_slug" id="fact-slug" value="<?php echo $slug ?>" />
                            <input type="hidden" name="fact_patient_id" id="patient-id" value="<?php echo $nodes->fact_patient->id ?>" />
                            <button class="btn btn-primary" type="submit"><i class="ti ti-arrow-circle-right"></i> Simpan</button>
                            <button class="btn btn-outline-primary form-reset" type="reset"><i class="ti ti-reload"></i> Batalkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
echo $region_picker;