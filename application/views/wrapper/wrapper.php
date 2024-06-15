<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        
        <?php
        $favicon = site_url('assets/img/favicon.png');
        if (!empty($application->app_icon)) {
            $favicon = site_url($application->app_icon);
        }
        ?>
        <link href="<?php echo $favicon ?>" rel="shortcut icon" />
        <title>
            <?php
            $title = 'Open Layers';
            if (!empty($application->app_page_title)) {
                $title = $application->app_name;
                if (!empty($page_title)) {
                    if ($application->app_page_title == 1) {
                        $title .= ' - ' . $page_title;
                    } else {
                        $title = $page_title;
                    }
                }
            }
            
            echo $title;
            ?>
        </title>
        
        <!-- CSS file collections -->
        <?php echo $wrap_css ?>
        <script>
            var baseUrl = '<?php echo site_url() ?>';
            var basicLoader = '<?php echo site_url('assets/img/gif/ajax_clock_small.gif') ?>';
            <?php
            if (!empty($application->app_avatar_path)) {
                ?>
            var noAvatarPath = '<?php echo site_url($application->app_avatar_path) ?>';
                <?php
            } else {
                ?>
            var noAvatarPath = '<?php echo site_url(load_prop('no_avatar_default')) ?>';
                <?php
            }
            ?>
        </script>
    </head>
  
    <body>
        <div class="wrapper">
            <!-- Header Part -->
            <?php echo $wrap_header ?>
            
            <div class="page-wrapper">
                <!-- Pre-body Part -->
                <?php echo $wrap_prebody ?>
                
                <div class="page-body">
                    <div class="<?php echo $container_mode ?>">
                        <!-- Page content part -->
                        <?php echo $wrap_content ?>
                    </div>
                </div>
            </div>
            
            <!-- Footer Part -->
            <?php echo $wrap_footer ?>
        </div>
        
        <!-- JavaScript file conllections -->
        <?php echo $wrap_js ?>
    </body>
</html>