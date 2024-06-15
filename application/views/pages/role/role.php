<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="row row-cards">
    <?php
    $size = 12;
    $bool = false;
    $priv = $authentication->privileges;
    if (in_array('access settings role-add', $priv) || in_array('access settings role-edit', $priv)) {
        $size = 7;
        $bool = true;
    }
    ?>
    <div class="col-md-<?php echo $size ?> col-sm-12">
        <div class="card balanced-card">
            <div class="card-body data-table">
                <div id="result-process"></div>
                <div id="role-list-view" class="inline-data"></div>
            </div>
        </div>
    </div>
    <?php
    if ($bool) {
        echo $role_form;
    }
    ?>
</div>
