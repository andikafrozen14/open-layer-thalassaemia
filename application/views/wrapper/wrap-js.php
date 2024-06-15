<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>

<!-- JQuery -->
<script src="<?php echo site_url('assets/plugins/jquery-ui/external/jquery/jquery-3.6.0.min.js') ?>"></script>
<script src="<?php echo site_url('assets/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>

<!-- Bootstrap -->
<script src="<?php echo site_url('assets/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>

<!-- Tabler Core -->
<script src="<?php echo site_url('assets/js/tabler.min.js') ?>"></script>
<script src="<?php echo site_url('assets/js/demo.js?v=' . uniqid()) ?>"></script>

<!-- Data Table -->
<script src="<?php echo site_url('assets/plugins/datatables/js/jquery.dataTables.min.js') ?>"></script>

<!-- Application -->
<?php
if (!empty($js_list)) {
    foreach ($js_list as $path) {
        echo '<script src="' . site_url($path) . '?v=' . uniqid() . '"></script>';
    }
}