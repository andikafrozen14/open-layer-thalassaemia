<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="modal modal-blur fade" id="modal-screening-detail" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popti-title"><i class="ti ti-heart-broken"></i> Info Lengkap Hasil Screening <span id="title-info"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4"><b>Klg. Penyandang</b></div>
                            <div class="col-md-8" id="detail-mid">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>Nik Penyandang</b></div>
                            <div class="col-md-8" id="detail-fam-nik">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>NIK</b></div>
                            <div class="col-md-8" id="detail-nik">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>No. Kartu Keluarga</b></div>
                            <div class="col-md-8" id="detail-famcardno">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>Nama Lengkap</b></div>
                            <div class="col-md-8" id="detail-name">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>Jenis Kelamin</b></div>
                            <div class="col-md-8" id="detail-gender">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>Gol. Darah</b></div>
                            <div class="col-md-8" id="detail-blood-type">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>Tempat, Tgl Lahir</b></div>
                            <div class="col-md-8" id="detail-ttl">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4"><b>Event</b></div>
                            <div class="col-md-8" id="detail-event">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>Pendidikan Terakhir</b></div>
                            <div class="col-md-8" id="detail-education">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>Pekerjaan</b></div>
                            <div class="col-md-8" id="detail-job">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>Nama Ayah</b></div>
                            <div class="col-md-8" id="detail-father-name">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>Nama Ibu</b></div>
                            <div class="col-md-8" id="detail-mother-name">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>Status Nikah</b></div>
                            <div class="col-md-8" id="detail-marital">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>Jumlah Anak</b></div>
                            <div class="col-md-8" id="detail-childs">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>No. Telepon</b></div>
                            <div class="col-md-8" id="detail-cellno">-</div>
                        </div>
                    </div>
                </div>
                <div class="divider mt-1 mb-2"></div>
                <div class="row mt-3">
                    <h3><i class="ti ti-direction-alt"></i> Alamat Lengkap</h3>
                    <p id="detail-address"></p>
                </div>
                <div class="divider mt-1 mb-2"></div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h3><i class="ti ti-angle-double-right"></i> Hasil Screening Awal</h3>
                        <div class="row">
                            <div class="col-md-4"><b>Unit Lab.</b></div>
                            <div class="col-md-8" id="detail-lab1">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>Hb</b></div>
                            <div class="col-md-8" id="detail-hb">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>MCV</b></div>
                            <div class="col-md-8" id="detail-mcv">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>MCHC</b></div>
                            <div class="col-md-8" id="detail-mchc">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>MCH</b></div>
                            <div class="col-md-8" id="detail-mch">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>Status</b></div>
                            <div class="col-md-8" id="detail-indicate">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>Lampiran Hasil Lab.</b></div>
                            <div class="col-md-8" id="detail-doc1">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3><i class="ti ti-angle-double-right"></i> Hasil Screening Lanjutan</h3>
                        <div class="row">
                            <div class="col-md-4"><b>Unit Lab.</b></div>
                            <div class="col-md-8" id="detail-lab2">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>HbA2</b></div>
                            <div class="col-md-8" id="detail-hba2">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>HbF</b></div>
                            <div class="col-md-8" id="detail-hbf">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>Jenis Thalassaemia</b></div>
                            <div class="col-md-8" id="detail-gen">-</div>
                        </div>
                        <div class="divider mt-1 mb-2"></div>
                        <div class="row">
                            <div class="col-md-4"><b>Lampiran Hasil Lab.</b></div>
                            <div class="col-md-8" id="detail-doc2">-</div>
                        </div>
                    </div>
                </div>
                <div class="divider mt-1 mb-2"></div>
                <div class="row mt-3">
                    <h3><i class="ti ti-info-alt"></i> Catatan Opsional</h3>
                    <p id="detail-notes"></p>
                </div>
            </div>
            
            <div class="modal-footer">
                <a href="#" class="btn btn-primary ms-auto" id="detail-edit-btn">
                    <i class="ti ti-pencil"></i> Ubah Data Hasil Screening
                </a>
            </div>
        </div>
    </div>
</div>