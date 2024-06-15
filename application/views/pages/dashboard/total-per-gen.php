<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="col-md-4">
    <div class="card balanced-card">
        <div class="card-header">
            <h3 class="card-title"><i class="ti ti-list"></i> Total Pasien per Jenis Thalassaemia</h3>
        </div>
        <table class="table card-table table-vcenter">
            <thead>
                <tr>
                    <th>Jenis Thalassaemia</th>
                    <th>Total Pasien</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($total_per_gen)) {
                    foreach ($total_per_gen as $node) {
                        ?>
                <tr>
                    <td><?php echo $node->gen ?></td>
                    <td><div class="pull-right"><?php echo str_replace(',', '.', number_format($node->totals)) ?></div></td>
                </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>