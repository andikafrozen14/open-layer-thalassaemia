<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="row justify-content-center">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3><i class="ti ti-heart-broken"></i> Form Ubah Hasil Screening</h3>
                <div class="divider mb-3"></div>
                <?php
                $ss = $this->session->userdata('modif_success');
                if (!empty($ss)) {
                    echo alert('screening-form-submit-result', $ss, 'success', true, 'check');
                    $this->session->unset_userdata('modif_success');
                }
                ?>
                <form id="screening-form-edit" class="screen-form" action="" method="post" onsubmit="return false" enctype="multipart/form-data">
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Keluarga Penyandang <sup>*</sup></label>
                        <div class="col-md-4">
                            <?php
                            $opts = array('1' => 'Ya', '0' => 'Tidak');
                            $attr = array('id' => 'patient-inherit', 'class' => 'form-select');
                            echo form_dropdown('patient_inherit', $opts, $nodes->fact_screening->sick_family, $attr);
                            ?>
                            <div id="error-patient-marital" class="error-message"></div>
                            <small class="form-hint">Apakah pasien merupakan salat satu anggota keluarga penyandang?</small>
                        </div>
                        <div id="patient-inherit-input" class="col-md-4">
                            <input type="text" class="form-control" name="patient_inherit_nik" id="patient-inherit-nik" value="<?php echo $nodes->fact_screening->nik_family ?>" />
                            <div id="error-patient-inherit-nik" class="error-message"></div>
                            <small class="form-hint">NIK Penyandang.</small>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Nama Event</label>
                        <div class="col-md-8">
                            <?php
                            $attr = array('id' => 'patient-event', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_event', $nodes->fact_screening->event, $attr);
                            ?>
                            <div id="error-patient-event" class="error-message"></div>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">NIK Pasien <sup>*</sup></label>
                        <div class="col-md-8">
                            <?php
                            $attr = array('id' => 'patient-nik', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_nik', $nodes->fact_screening->nik, $attr);
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
                            echo form_input('patient_famcardno', $nodes->fact_screening->famcardno, $attr);
                            ?>
                            <div id="error-patient-cardno" class="error-message"></div>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Nama Lengkap <sup>*</sup></label>
                        <div class="col-md-8">
                            <?php
                            $attr = array('id' => 'patient-name', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_name', $nodes->fact_screening->name, $attr);
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
                            echo form_dropdown('patient_gender', array_merge($opts, $gender), $nodes->fact_screening->gid, $attr);
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
                            echo form_dropdown('patient_blood_type', array_merge($opts, $blood_type), $nodes->fact_screening->blood_type, $attr);
                            ?>
                            <div id="error-patient-blood-type" class="error-message"></div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Tempat / Tanggal Lahir</label>
                        <div class="col-md-4">
                            <?php
                            $attr = array('id' => 'patient-pob', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_pob', $nodes->fact_screening->pob, $attr);
                            ?>
                            <div id="error-patient-pob" class="error-message"></div>
                            <small class="form-hint">Tempat Lahir.</small>
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" id="patient-dob" name="patient_dob" autocomplete="off" value="<?php echo $nodes->fact_screening->dob ?>" />
                            <div id="error-patient-dob" class="error-message"></div>
                            <small class="form-hint">Tanggal Lahir. <sup>*</sup></small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Nama Orang Tua</label>
                        <div class="col-md-4">
                            <?php
                            $attr = array('id' => 'patient-father-name', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_father_name', $nodes->fact_screening->father_name, $attr);
                            ?>
                            <div id="error-patient-father-name" class="error-message"></div>
                            <small class="form-hint">Nama Ayah.</small>
                        </div>
                        <div class="col-md-4">
                            <?php
                            $attr = array('id' => 'patient-mother-name', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_mother_name', $nodes->fact_screening->mother_name, $attr);
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
                            $dv = !empty($region->province)? $region->province : '';
                            $attr = array('class' => 'form-control', 'disabled' => true, 'id' => 'address-province', 'placeholder' => 'Provinsi');
                            echo form_input('address_province', $dv, $attr);
                            $dv = !empty($region->provid)? $region->provid : '';
                            ?>
                            <input type="hidden" name="patient_address_provid" id="patient-address-provid" value="<?php echo $dv ?>" />
                        </div>
                        <div class="col-md-4">
                            <?php
                            $dv = !empty($region->city)? $region->city : '';
                            $attr = array('class' => 'form-control', 'disabled' => true, 'id' => 'address-city', 'placeholder' => 'Kota / Kabupaten');
                            echo form_input('address_city', $dv, $attr);
                            $dv = !empty($region->citid)? $region->citid : '';
                            ?>
                            <input type="hidden" name="patient_address_citid" id="patient-address-citid" value="<?php echo $dv ?>" />
                        </div>
                        <label class="form-label col-3 mt-3 col-form-label">&nbsp;</label>
                        <div class="col-md-4 mb-3 mt-3">
                            <?php
                            $dv = !empty($region->district)? $region->district : '';
                            $attr = array('class' => 'form-control', 'disabled' => true, 'id' => 'address-district', 'placeholder' => 'Kecamatan');
                            echo form_input('address_district', $dv, $attr);
                            $dv = !empty($region->diistid)? $region->distid : '';
                            ?>
                            <input type="hidden" name="patient_address_distid" id="patient-address-distid" value="<?php echo $dv ?>" />
                        </div>
                        <div class="col-md-4 mt-3">
                            <?php
                            $dv = !empty($region->village)? $region->village : '';
                            $attr = array('class' => 'form-control', 'disabled' => true, 'id' => 'address-village', 'placeholder' => 'Kelurahan');
                            echo form_input('address_village', $dv, $attr);
                            $dv = !empty($region->villid)? $region->villid : '';
                            ?>
                            <input type="hidden" name="patient_address_villid" id="patient-address-villid" value="<?php echo $dv ?>" />
                        </div>
                        <label class="form-label col-3 col-form-label">&nbsp;</label>
                        <div class="col-md-8">
                            <?php
                            $attr = array(
                                'class' => 'form-control autosize', 
                                'id' => 'patient-address-details', 
                                'placeholder' => 'Rincian lengkap alamat pasien.',);
                            echo form_textarea('patient_address_details', $nodes->fact_screening_address->addr, $attr);
                            ?>
                            <div id="error-patient-address-details" class="error-message"></div>
                        </div>
                        <label class="form-label col-3 col-form-label">&nbsp;</label>
                        <div class="col-md-2 mt-3">
                            <input type="number" id="patient-address-rt" class="form-control" name="patient_address_rt" value="<?php echo $nodes->fact_screening_address->rt ?>" />
                            <small class="form-hint">RT.</small>
                        </div>
                        <div class="col-md-2 mt-3">
                            <input type="number" id="patient-address-rw" class="form-control" name="patient_address_rw" value="<?php echo $nodes->fact_screening_address->rw ?>" />
                            <small class="form-hint">RW.</small>
                        </div>
                        <div class="col-md-2 mt-3">
                            <input type="text" id="patient-address-postal" class="form-control" name="patient_address_postal" value="<?php echo $nodes->fact_screening_address->postal ?>" />
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
                            echo form_dropdown('patient_education', array_merge($opts, $edu_opts), $nodes->fact_screening->lastedu, $attr);
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
                            echo form_dropdown('patient_marital', array_merge($opts, $maritals), $nodes->fact_screening->marital, $attr);
                            ?>
                            <div id="error-patient-marital" class="error-message"></div>
                            <small class="form-hint">Status pernikahan pasien.</small>
                        </div>
                        <div id="patient-childs-input" class="col-md-2">
                            <input type="number" class="form-control" name="patient_childs" id="patient-childs" value="<?php echo $nodes->fact_screening->childs ?>" />
                            <div id="error-patient-childs" class="error-message"></div>
                            <small class="form-hint">Jumlah Anak.</small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label">Pekerjaan Pasien</label>
                        <div class="col-md-8">
                            <?php
                            $attr = array('id' => 'patient-job', 'class' => 'form-control', 'autocomplete' => 'off');
                            echo form_input('patient_job', $nodes->fact_screening->job, $attr);
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
                            echo form_input('patient_phone', $nodes->fact_screening->cellno, $attr);
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
                                    echo form_input('patient_lab', $nodes->fact_screening_result->lab1, $attr);
                                    ?>
                                    <div id="error-patient-lab" class="error-message"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">Hb</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr = array('id' => 'patient-hb', 'class' => 'form-control', 'autocomplete' => 'off');
                                    echo form_input('patient_hb', $nodes->fact_screening_result->hb, $attr);
                                    ?>
                                    <div id="error-patient-hb" class="error-message"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">MCV</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr = array('id' => 'patient-mcv', 'class' => 'form-control', 'autocomplete' => 'off');
                                    echo form_input('patient_mcv', $nodes->fact_screening_result->mcv, $attr);
                                    ?>
                                    <div id="error-patient-mcv" class="error-message"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">MCHC</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr = array('id' => 'patient-mchc', 'class' => 'form-control', 'autocomplete' => 'off');
                                    echo form_input('patient_mchc', $nodes->fact_screening_result->mchc, $attr);
                                    ?>
                                    <div id="error-patient-mchc" class="error-message"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">MCH</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr = array('id' => 'patient-mch', 'class' => 'form-control', 'autocomplete' => 'off');
                                    echo form_input('patient_mch', $nodes->fact_screening_result->mch, $attr);
                                    ?>
                                    <div id="error-patient-mch" class="error-message"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label"></label>
                                <div class="col-md-9 mt-2">
                                    <label class="form-check form-check-inline">
                                        <?php
                                        $tick = '';
                                        if ($nodes->fact_screening_result->indi == 1) {
                                            $tick = 'checked';
                                        }
                                        ?>
                                        <input class="form-check-input" type="checkbox" name="patient_indicated" id="patient-indicated" value="1" <?php echo $tick ?> />
                                        <span class="form-check-label">Pasien terindikasi Thalassaemia.</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">Dokumen Hasil Lab.</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr_doc1 = array(
                                        'id' => 'patient-upload-lab1', 
                                        'class' => 'form-control', 
                                        'accept' => 'image/png, image/jpeg, image/jpg, application/pdf');
                                    if (!empty($nodes->fact_screening_result->doc1)) {
                                        $exp = explode('/', $nodes->fact_screening_result->doc1);
                                        $title = '<i class="ti ti-file"></i> ' . end($exp);
                                        echo '<div id="link-doc1">';
                                        echo form_hidden('screening_result_doc1', end($exp));
                                        echo anchor($nodes->fact_screening_result->doc1, $title, array(
                                                'id' => 'screening-doc1',
                                                'target' => '_blank', 
                                                'title' => end($exp),
                                                'class' => 'btn btn-lg btn-link',
                                            )).br().nbs(5);
                                        echo form_button('upload_edit', '<i class="ti ti-pencil"></i> Ubah', array(
                                            'class' => 'btn btn-sm btn-link', 
                                            'title' => 'Ubah',
                                            'onclick' => 'editDoc1()',
                                        )) . ' ';
                                        
                                        echo form_button('upload_remove', '<i class="ti ti-close"></i> Hapus', array(
                                            'class' => 'btn btn-sm btn-link red-text',
                                            'title' => 'Hapus',
                                            'onclick' => 'removeDoc1()'
                                        ));
                                        echo '</div>';
                                        
                                        echo '<div id="uploader1">';
                                        echo form_upload('patient_upload_lab1', '', $attr_doc1);
                                        echo form_button('upload_remove', '<i class="ti ti-close"></i> Batal', array(
                                                'class' => 'btn btn-sm btn-link',
                                                'title' => 'Batal',
                                                'onclick' => 'cancelUploadDoc1()',
                                            ));
                                        echo '<small class="form-hint mt-1">(*) <i>pdf, png, jpg & jpeg. Max. Size: 5MB</i></small>';
                                        echo '</div>';
                                    } else {
                                        echo form_upload('patient_upload_lab1', '', $attr_doc1);
                                        echo '<small class="form-hint mt-1">(*) <i>pdf, png, jpg & jpeg. Max. Size: 5MB</i></small>';
                                    }
                                    ?>
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
                                    echo form_input('patient_lab_alt', $nodes->fact_screening_result->lab2, $attr);
                                    ?>
                                    <div id="error-patient-lab-alt" class="error-message"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">HbA2</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr = array('id' => 'patient-hba2', 'class' => 'form-control', 'autocomplete' => 'off');
                                    echo form_input('patient_hba2', $nodes->fact_screening_result->hba2, $attr);
                                    ?>
                                    <div id="error-patient-hba2" class="error-message"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">HbF</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr = array('id' => 'patient-hbf', 'class' => 'form-control', 'autocomplete' => 'off');
                                    echo form_input('patient_hbf', $nodes->fact_screening_result->hbf, $attr);
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
                                    echo form_dropdown('patient_gen_type', array_merge($opts, $gentypes), $nodes->fact_screening_result->gen, $attr);
                                    ?>
                                    <div id="error-patient-gen-type" class="error-message"></div>
                                    <small class="form-hint">Jenis Gen Thalassaemia yang diderita oleh pasien.</small>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="form-label col-3 col-form-label">Dokumen Hasil Lab.</label>
                                <div class="col-md-9">
                                    <?php
                                    $attr_doc2 = array(
                                        'id' => 'patient-upload-lab2', 
                                        'class' => 'form-control', 
                                        'accept' => 'image/png, image/jpeg, image/jpg, application/pdf');
                                    if (!empty($nodes->fact_screening_result->doc2)) {
                                        $exp = explode('/', $nodes->fact_screening_result->doc2);
                                        $title = '<i class="ti ti-file"></i> ' . end($exp);
                                        echo '<div id="link-doc2">';
                                        echo form_hidden('screening_result_doc2', end($exp));
                                        echo anchor($nodes->fact_screening_result->doc2, $title, array(
                                                'id' => 'screening-doc2',
                                                'target' => '_blank', 
                                                'title' => end($exp),
                                                'class' => 'btn btn-lg btn-link',
                                            )).br().nbs(5);
                                        echo form_button('upload_edit', '<i class="ti ti-pencil"></i> Ubah', array(
                                            'class' => 'btn btn-sm btn-link', 
                                            'title' => 'Ubah',
                                            'onclick' => 'editDoc2()',
                                        )) . ' ';
                                        
                                        echo form_button('upload_remove', '<i class="ti ti-close"></i> Hapus', array(
                                            'class' => 'btn btn-sm btn-link red-text',
                                            'title' => 'Hapus',
                                            'onclick' => 'removeDoc2()'
                                        ));
                                        echo '</div>';
                                        
                                        echo '<div id="uploader2">';
                                        echo form_upload('patient_upload_lab2', '', $attr_doc2);
                                        echo form_button('upload_remove', '<i class="ti ti-close"></i> Batal', array(
                                                'class' => 'btn btn-sm btn-link',
                                                'title' => 'Batal',
                                                'onclick' => 'cancelUploadDoc2()',
                                            ));
                                        echo '<small class="form-hint mt-1">(*) <i>pdf, png, jpg & jpeg. Max. Size: 5MB</i></small>';
                                        echo '</div>';
                                    } else {
                                        echo form_upload('patient_upload_lab2', '', $attr_doc2);
                                        echo '<small class="form-hint mt-1">(*) <i>pdf, png, jpg & jpeg. Max. Size: 5MB</i></small>';
                                    }
                                    ?>
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
                            echo form_textarea('patient_notes', $nodes->fact->excerpt, $attr);
                            ?>
                            <small class="form-hint">Catatan opsional untuk pasien bila ada.</small>
                        </div>
                    </div>
                    
                    <div class="divider mb-3"></div>
                    <div class="form-group row mb-3">
                        <label class="form-label col-3 col-form-label"></label>
                        <div class="col-md-4">
                            <input type="hidden" name="sid" value="<?php echo $nodes->fact_screening->id ?>" />
                            <input type="hidden" name="fid" value="<?php echo $nodes->fact->fid ?>" />
                            <input type="hidden" name="screening_edit" id="screening-edit" value="1" />
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