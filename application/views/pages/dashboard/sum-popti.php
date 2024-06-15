<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="col-4">
    <div class="row row-cards">
        
        <?php
        $icon = site_url('assets/img/thalassaemia/popti-sm.png');
        $items = array(
            (object) array(
                'label' => 'Jumlah Cabang POPTI',
                'value' => $popti_totals->totals . ' Cabang POPTI',
            ),
            (object) array(
                'label' => 'Jumlah Cabang Unit Kesehatan',
                'value' => $unit_totals->totals . ' Unit Kesehatan',
            ),
            (object) array(
                'label' => 'Cabang POPTI - Unit Kesehatan Terbanyak',
                'value' => $max_pop_unit->branch . ', (' . $max_pop_unit->units . ' Unit Kesehatan)',
            ),
            (object) array(
                'label' => 'Cabang POPTI - Penyandang Terpadat',
                'value' => '<small>'. $max_unit_patient->branch . 
                    ' / ' . $max_unit_patient->name . 
                    '</small> (' . str_replace(',', '.', number_format($max_unit_patient->patients)) . ')',
            ),
            (object) array(
                'label' => 'Jumlah Cabang POPTI Non-Aktif',
                'value' => $inactive_popti->totals . ' Cabang POPTI',
            ),
        );
        
        foreach ($items as $item) {
        ?>
        
        <div class="col-12">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-primary text-white avatar">
                                <img src="<?php echo $icon ?>" />
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium"><?php echo $item->label ?></div>
                            <div class="text-muted"><?php echo $item->value ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>