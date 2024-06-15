<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="modal modal-blur fade" id="modal-region" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="ti ti-location-pin"></i> Ambil Lokasi Wilayah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="region-picker" class="table table-bordered display">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Provinsi</th>
                            <th>Kota / Kabupaten</th>
                            <th>Kecamatan</th>
                            <th>Kelurahan</th>
                            <th>Kode Pos</th>
                            <th>Kode Telepon</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>