<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="row row-cards">
    <?php
    $size = 12;
    $priv = $authentication->privileges;
    if (in_array('access settings user-add', $priv) || in_array('access settings user-edit', $priv)) {
        echo $user_form;
        $size = 7;
    }
    ?>
    <div class="col-md-<?php echo $size ?> col-sm-12">
        <div class="card balanced-card">
            <div class="card-body data-table">
                <div id="result-process"></div>
                <div id="user-list-view" class="inline-data"></div>
            </div>
        </div>
    </div>
</div>
