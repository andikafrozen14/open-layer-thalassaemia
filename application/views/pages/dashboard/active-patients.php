<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="col-3">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="subheader">Jumlah Pasien Aktif</div>
                <div class="ms-auto lh-1">
                    <div class="dropdown">
                        <span class="text-muted"><?php echo date('Y') ?></span>
                        <!--
                        <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Last 7 days</a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item active" href="javascript:void(0)">Last 7 days</a>
                            <a class="dropdown-item" href="javascript:void(0)">Last 30 days</a>
                            <a class="dropdown-item" href="javascript:void(0)">Last 3 months</a>
                        </div>
                        -->
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-baseline">
                <div id="sum-active-patients" class="h1 mb-0 me-2"></div>
                <div class="me-auto">
                    <span class="text-danger d-inline-flex align-items-center lh-1">
                        jiwa &nbsp;<i class="ti-pulse"></i>
                    </span>
                </div>
            </div>
        </div>
        <div id="chart-active-patients" class="chart-sm"></div>
    </div>
</div>