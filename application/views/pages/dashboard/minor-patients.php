<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="col-3">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="subheader">Jumlah Sahabat Thalassaemia Karir</div>
                <div class="ms-auto lh-1">
                    <div class="dropdown">
                        <span class="text-muted"><?php echo date('Y') ?></span>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-baseline">
                <div id="sum-minor-patients" class="h1 mb-0 me-2"></div>
                <div class="me-auto">
                    <span class="text-warning d-inline-flex align-items-center lh-1">
                        jiwa &nbsp;<i class="ti-pulse"></i>
                    </span>
                </div>
            </div>
        </div>
        <div id="chart-minor-patients" class="chart-sm"></div>
    </div>
</div>