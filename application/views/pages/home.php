<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="row">
    <?php 
    echo $active_patient_view;
    echo $inactive_patient_view;
    echo $total_patient_view;
    echo $minor_patient_view;
    ?>
</div>
<div class="row mt-3">
    <?php echo $range_blood_type_view ?>
</div>
<div class="row mt-3">
    <?php
    echo $total_per_gen_view;
    echo $screening_view;
    ?>
</div>
<div class="row mt-3">
    <?php 
    echo $user_trail_view; 
    echo $popti_view;
    ?>
</div>

<div id="active-patient-data" class="hidden"><?php echo json_encode($active_patient_data) ?></div>
<div id="inactive-patient-data" class="hidden"><?php echo json_encode($inactive_patient_data) ?></div>
<div id="total-patient-data" class="hidden"><?php echo json_encode($total_patient_data) ?></div>
<div id="minor-patient-data" class="hidden"><?php echo json_encode($minor_patient_data) ?></div>
<div id="range-blt-data" class="hidden"><?php echo json_encode($range_blood_type) ?></div>
<div id="gender-percents" class="hidden"><?php echo json_encode($total_gender_percents) ?></div>
<div id="blood-type-percents" class="hidden"><?php echo json_encode($total_blood_type_percents) ?></div>