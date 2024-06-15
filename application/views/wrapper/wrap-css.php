<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>

<link href="<?php echo site_url('assets/css/tabler.min.css') ?>" rel="stylesheet" />
<link href="<?php echo site_url('assets/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet" />
<link href="<?php echo site_url('assets/plugins/themify/themify-icons.css') ?>" rel="stylesheet" />
<link href="<?php echo site_url('assets/plugins/themify/ie7/ie7.css') ?>" rel="stylesheet" />
<link href="<?php echo site_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet" />
<link href="<?php echo site_url('assets/css/theme.css?v=' . uniqid()) ?>" rel="stylesheet" />

<!-- Application -->
<?php
if (!empty($css_list)) {
    foreach ($css_list as $path) {
        echo '<link href="' . site_url($path) . '?v=' . uniqid() . '" rel="stylesheet" />';
    }
}