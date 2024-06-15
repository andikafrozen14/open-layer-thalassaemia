<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="row justify-content-center">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3><i class="ti ti-heart-broken"></i> Form Tambah Hasil Screening</h3>
                <div class="divider mb-3"></div>
                
                <form id="screening-form-add" class="screen-form" action="" method="post" onsubmit="return false" enctype="multipart/form-data">
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Keluarga Penyandang <sup>*</sup></label>
                        <div class="col-md-4">
                            <?php
                            $opts = array('1' => 'Ya', '0' => 'Tidak');
                            $attr = array('id' => 'patient-inherit', 'class' => 'form-select');
                            echo form_dropdown('patient_inherit', $opts, '', $attr);
                            ?>
                            <div id="error-patient-marital" class="error-message"></div>
                            <small class="form-hint">Apakah pasien merupakan salat satu anggota keluarga penyandang?</small>
                        </div>
                        <div id="patient-inherit-input" class="col-md-4">
                            <input type="text" class="form-control" name="patient_inherit_nik" id="patient-inherit-nik" />
                            <div id="error-patient-inherit-nik" class="error-message"></div>
                            <small class="form-hint">NIK Penyandang.</small>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Nama Event</label>
                        <div class="col-md-8">
                            <?php
                            $dv = '';
                            $le = $this->session->userdata('last_event');
                            if (!empty($le)) $dv = $le;
                            $attr = array('id' => 'patient-event', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_event', $dv, $attr);
                            ?>
                            <div id="error-patient-event" class="error-message"></div>
                            <div class="hidden" id="last-event"><?php echo $dv ?></div>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">NIK Pasien <sup>*</sup></label>
                        <div class="col-md-8">
                            <?php
                            $attr = array('id' => 'patient-nik', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_nik', '', $attr);
                            ?>
                            <div id="error-patient-nik" class="error-message"></div>
                            <small class="form-hint">No. KTP / No. NIK pada Kartu Keluarga / No. Passport.</small>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">No. Kartu Keluarga</label>
                        <div class="col-md-8">
                            <?php
                            $attr = array('id' => 'patient-family-cardno', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_famcardno', '', $attr);
                            ?>
                            <div id="error-patient-cardno" class="error-message"></div>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Nama Lengkap <sup>*</sup></label>
                        <div class="col-md-8">
                            <?php
                            $attr = array('id' => 'patient-name', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_name', '', $attr);
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
                            echo form_dropdown('patient_gender', array_merge($opts, $gender), '', $attr);
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
                            echo form_dropdown('patient_blood_type', array_merge($opts, $blood_type), '', $attr);
                            ?>
                            <div id="error-patient-blood-type" class="error-message"></div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Tempat / Tanggal Lahir</label>
                        <div class="col-md-4">
                            <?php
                            $attr = array('id' => 'patient-pob', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_pob', '', $attr);
                            ?>
                            <div id="error-patient-pob" class="error-message"></div>
                            <small class="form-hint">Tempat Lahir.</small>
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" id="patient-dob" name="patient_dob" autocomplete="off" />
                            <div id="error-patient-dob" class="error-message"></div>
                            <small class="form-hint">Tanggal Lahir. <sup>*</sup></small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Nama Orang Tua</label>
                        <div class="col-md-4">
                            <?php
                            $attr = array('id' => 'patient-father-name', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_father_name', '', $attr);
                            ?>
                            <div id="error-patient-father-name" class="error-message"></div>
                            <small class="form-hint">Nama Ayah.</small>
                        </div>
                        <div class="col-md-4">
                            <?php
                            $attr = array('id' => 'patient-mother-name', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_mother_name', '', $attr);
                            ?>
                            <div id="error-patient-mother-name" class="error-message"></div>
                            <small class="form-hint">Nama Ibu.</small>
                        </div>
                    </div>
                    <div class="divider mt-3 mb-3"></div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Alamat Pasien <sup>*</sup></label>
                        <div class="col-md-8">
                            <button class="btn btn-info w-100 mb-3" type="button" data-bs-toggle="modal" data-bs-target="#modal-region">
                                <i class="ti ti-location-pin"></i> Ambil Lokasi Wilayah
                            </button>
                        </div>
                        <label class="form-label col-3 col-form-label">&nbsp;</label>
                        <div class="col-md-4">
                            <?php
                            $attr = array('class' => 'form-control', 'disabled' => true, 'id' => 'address-province', 'placeholder' => 'Provinsi');
                            echo form_input('address_province', '', $attr);
                            ?>
                            <input type="hidden" name="patient_address_provid" id="patient-address-provid" />
                        </div>
                        <div class="col-md-4">
                            <?php
                            $attr = array('class' => 'form-control', 'disabled' => true, 'id' => 'address-city', 'placeholder' => 'Kota / Kabupaten');
                            echo form_input('address_city', '', $attr);
                            ?>
                            <input type="hidden" name="patient_address_citid" id="patient-address-citid" />
                        </div>
                        <label class="form-label col-3 mt-3 col-form-label">&nbsp;</label>
                        <div class="col-md-4 mb-3 mt-3">
                            <?php
                            $attr = array('class' => 'form-control', 'disabled' => true, 'id' => 'address-district', 'placeholder' => 'Kecamatan');
                            echo form_input('address_district', '', $attr);
                            ?>
                            <input type="hidden" name="patient_address_distid" id="patient-address-distid" />
                        </div>
                        <div class="col-md-4 mt-3">
                            <?php
                            $attr = array('class' => 'form-control', 'disabled' => true, 'id' => 'address-village', 'placeholder' => 'Kelurahan');
                            echo form_input('address_village', '', $attr);
                            ?>
                            <input type="hidden" name="patient_address_villid" id="patient-address-villid" />
                        </div>
                        <label class="form-label col-3 col-form-label">&nbsp;</label>
                        <div class="col-md-8">
                            <?php
                            $attr = array(
                                'class' => 'form-control autosize', 
                                'id' => 'patient-address-details', 
                                'placeholder' => 'Rincian lengkap alamat pasien.',);
                            echo form_textarea('patient_address_details', '', $attr);
                            ?>
                            <div id="error-patient-address-details" class="error-message"></div>
                        </div>
                        <label class="form-label col-3 col-form-label">&nbsp;</label>
                        <div class="col-md-2 mt-3">
                            <input type="number" id="patient-address-rt" class="form-control" name="patient_address_rt" />
                            <small class="form-hint">RT.</small>
                        </div>
                        <div class="col-md-2 mt-3">
                            <input type="number" id="patient-address-rw" class="form-control" name="patient_address_rw" />
                            <small class="form-hint">RW.</small>
                        </div>
                        <div class="col-md-2 mt-3">
                            <input type="text" id="patient-address-postal" class="form-control" name="patient_address_postal" />
                            <small class="form-hint">Kode Pos.</small>
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
                        <div id="patient-childs-input" class="col-md-2">
                            <input type="number" class="form-control" name="patient_childs" id="patient-childs" value="0" />
                            <div id="error-patient-childs" class="error-message"></div>
                            <small class="form-hint">Jumlah Anak.</small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Pekerjaan Pasien</label>
                        <div class="col-md-8">
                            <?php
                            $attr = array('id' => 'patient-job', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_job', '', $attr);
                            ?>
                            <div id="error-patient-job" class="error-message"></div>
                            <small class="form-hint">Pekerjaan pasien saat ini.</small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">No. Telepon <sup>*</sup></label>
                        <div class="col-md-4">
                            <?php
                            $attr = array('id' => 'patient-phone', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_phone', '', $attr);
                            ?>
                            <div id="error-patient-phone" class="error-message"></div>
                            <small class="form-hint">No. Telepon Pasien yang dapat dihubungi.</small>
                        </div>
                    </div>
                    <div class="divider mb-3"></div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">Nama Lab.</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr = array('id' => 'patient-lab', 'class' => 'form-control', 'autocomplete' => 'off');
                                    echo form_input('patient_lab', '', $attr);
                                    ?>
                                    <div id="error-patient-lab" class="error-message"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">Hb</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr = array('id' => 'patient-hb', 'class' => 'form-control', 'autocomplete' => 'off');
                                    echo form_input('patient_hb', '', $attr);
                                    ?>
                                    <div id="error-patient-hb" class="error-message"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">MCV</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr = array('id' => 'patient-mcv', 'class' => 'form-control', 'autocomplete' => 'off');
                                    echo form_input('patient_mcv', '', $attr);
                                    ?>
                                    <div id="error-patient-mcv" class="error-message"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">MCHC</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr = array('id' => 'patient-mchc', 'class' => 'form-control', 'autocomplete' => 'off');
                                    echo form_input('patient_mchc', '', $attr);
                                    ?>
                                    <div id="error-patient-mchc" class="error-message"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">MCH</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr = array('id' => 'patient-mch', 'class' => 'form-control', 'autocomplete' => 'off');
                                    echo form_input('patient_mch', '', $attr);
                                    ?>
                                    <div id="error-patient-mch" class="error-message"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label"></label>
                                <div class="col-md-9 mt-2">
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="patient_indicated" id="patient-indicated" value="1" />
                                        <span class="form-check-label">Pasien terindikasi Thalassaemia.</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">Dokumen Hasil Lab.</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr = array('id' => 'patient-upload-lab1', 'class' => 'form-control', 'accept' => 'image/png, image/jpeg, image/jpg, application/pdf');
                                    echo form_upload('patient_upload_lab1', '', $attr);
                                    ?>
                                    <small class="form-hint mt-1">(*) <i>pdf, png, jpg & jpeg. Max. Size: 5MB</i></small>
                                    <div id="error-patient-upload-lab1" class="error-message"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">Nama Lab. Lanjutan</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr = array('id' => 'patient-lab-alt', 'class' => 'form-control', 'autocomplete' => 'off');
                                    echo form_input('patient_lab_alt', '', $attr);
                                    ?>
                                    <div id="error-patient-lab-alt" class="error-message"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">HbA2</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr = array('id' => 'patient-hba2', 'class' => 'form-control', 'autocomplete' => 'off');
                                    echo form_input('patient_hba2', '', $attr);
                                    ?>
                                    <div id="error-patient-hba2" class="error-message"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">HbF</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr = array('id' => 'patient-hbf', 'class' => 'form-control', 'autocomplete' => 'off');
                                    echo form_input('patient_hbf', '', $attr);
                                    ?>
                                    <div id="error-patient-hbf" class="error-message"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">Jenis Gen</label>
                                <div class="col-md-9">
                                    <?php
                                    $opts = array('' => '-- Pilih Jenis Thalassaemia');
                                    $attr = array('id' => 'patient-gen-type', 'class' => 'form-select', 'value' => '');
                                    echo form_dropdown('patient_gen_type', array_merge($opts, $gentypes), '', $attr);
                                    ?>
                                    <div id="error-patient-gen-type" class="error-message"></div>
                                    <small class="form-hint">Jenis Gen Thalassaemia yang diderita oleh pasien.</small>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">Dokumen Hasil Lab.</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr = array('id' => 'patient-upload-lab2', 'class' => 'form-control', 'accept' => 'image/png, image/jpeg, image/jpg, application/pdf');
                                    echo form_upload('patient_upload_lab2', '', $attr);
                                    ?>
                                    <small class="form-hint mt-1">(*) <i>pdf, png, jpg & jpeg. Max. Size: 5MB</i></small>
                                    <div id="error-patient-upload-lab2" class="error-message"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="divider mb-3"></div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Catatan Opsional</label>
                        <div class="col-md-8">
                            <?php
                            $attr = array('id' => 'patient-notes', 'class' => 'form-control autosize');
                            echo form_textarea('patient_notes', '', $attr);
                            ?>
                            <small class="form-hint">Catatan opsional untuk pasien bila ada.</small>
                        </div>
                    </div>
                    
                    <div class="divider mb-3"></div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label"></label>
                        <div class="col-md-4">
                            <input type="hidden" name="screening_add" id="screening-add" value="1" />
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