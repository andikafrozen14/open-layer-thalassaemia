<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="col-md-8">
    <div class="card" style="height: calc(24rem + 10px)">
        <div class="card-header">
            <div class="card-title"><h3><i class="ti ti-info-alt"></i> Daftar Aktifitas Pengguna Terbaru</h3></div>
        </div>
        <div class="card-body card-body-scrollable card-body-scrollable-shadow">
            <div class="divide-y">
                <?php
                if (!empty($user_trails)) {
                    foreach ($user_trails as $trail) {
                        $meta = json_decode($trail->meta_data);
                ?>
                <div>
                    <div class="row">
                        <div class="col-auto">
                            <span class="avatar">
                                <?php
                                $src = site_url('assets/img/no-avatar.jpg');
                                if (!empty($meta->path)) {
                                    $src = $meta->path;
                                } else {
                                    if (!empty($application->app_avatar)) {
                                        $src = $application->app_avatar;
                                    }
                                }
                                ?>
                                <img src="<?php echo site_url($meta->path) ?>" title="<?php echo $trail->screen ?>" alt="<?php echo $trail->screen ?>" />
                            </span>
                        </div>
                        <div class="col">
                            <div class="text-truncate">
                                <strong><?php echo $trail->screen ?></strong> 
                                <?php echo $trail->activity ?>
                            </div>
                            <div class="text-muted"><?php echo id_date_format($trail->created) ?></div>
                        </div>
                    </div>
                </div>
                <?php }} ?>
            </div>
        </div>
    </div>
</div>