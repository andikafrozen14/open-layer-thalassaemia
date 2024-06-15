<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="<?php echo $container_mode ?>">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <!-- Page title -->
            <div class="col-auto d-print-none">
                <div class="page-pretitle"><?php echo $pre_title ?></div>
                <h2 class="page-title"><?php echo $page_title ?></h2>
            </div>
            
            <!-- Breadcrumb -->
            <div class="col-auto ms-auto d-print-none">
                <div class="breadcrumb">
                    <?php
                    if (!empty($application->app_breadcrumbs)) {
                        if (!empty($breadcrumbs) && $application->app_breadcrumbs == 1) {
                            echo '<a href="' . site_url() . '" title="Beranda"><i class="ti-home"></i></a>';
                            echo '<span class="step-to">&raquo;</span>';
                            if (is_array($breadcrumbs)) {
                                $i = 0;
                                foreach ($breadcrumbs as $breadcrumb) {
                                    echo $breadcrumb;
                                    if ($i < (count($breadcrumbs) - 1))
                                        echo '<span class="step-to">&raquo;</span>';

                                    $i++;
                                }
                            } else {
                                echo $breadcrumbs;
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>