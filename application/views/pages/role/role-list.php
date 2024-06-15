<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>

<table id="role-table" class="table table-bordered display data-table">
    <thead>
        <tr>
            <td>Kode</td>
            <td>Nama</td>
            <td>Terdaftar</td>
            <td>Total</td>
            <?php
            if (in_array('access settings role-locking', $authentication->privileges)) {
                echo '<td>Locked</td>';
            }
            
            if (in_array('access settings role-edit', $authentication->privileges) ||
                in_array('access settings role-remove', $authentication->privileges)) {
                echo '<th></th>';
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($roles)) {
            foreach ($roles as $role) {
                echo '<tr>';
                echo '<td>' . $role->name . '</td>';
                echo '<td>' . $role->screen . '</td>';
                echo '<td>' . date('d/M/Y H:i', strtotime($role->created)) . '</td>';
                echo '<td>' . $role->sum . '</td>';

                $disabled = '';
                if (!in_array('access settings role-locking', $authentication->privileges)) {
                    $disabled = 'disabled';
                }

                $tick = $role->locked != 0 ? 'checked' : '';
                echo '<td><label class="form-check form-switch">'
                    . '<input onclick="locking(' . $role->id . ', \'' . $role->screen . '\')" id="check-lock-' . $role->id . '" class="form-check-input" type="checkbox" ' . $tick . '  ' . $disabled . ' />'
                    . '</label></td>';

                if (in_array('access settings role-edit', $authentication->privileges) ||
                    in_array('access settings role-remove', $authentication->privileges)) {

                    $edit = '';
                    if (in_array('access settings role-edit', $authentication->privileges)) {
                        $edit = '<a href="javascript:roleEdit(' . $role->id . ')" class="btn btn-sm btn-outline-primary" title="Ubah"><i class="ti-pencil"></i></a> ';
                        $data = array(
                            'id' => $role->id,
                            'name' => $role->name,
                            'screen' => $role->screen,
                        );

                        $edit .= '<input type="hidden" id="role-edit-' . $role->id . '" value=\'' . json_encode($data) . '\' />';
                    }

                    $rmv = '';
                    if (in_array('access settings role-remove', $authentication->privileges)) {
                        $rmv = '<a href="javascript:roleRemove(' . $role->id . ', \'' . $role->screen . '\')" '
                                . 'class="btn btn-sm btn-outline-warning" title="Hapus"><i class="ti-close"></i></a> ';
                    }

                    echo '<td><div class="text-center">' . $edit . $rmv . '</div></td>';
                }
                echo '</tr>';
            }
        }
        ?>
    </tbody>
</table>