<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<table id="user-table" class="table table-bordered display data-table">
    <thead>
        <tr>
            <th>ID Pengguna</th>
            <th>Nama Lengkap</th>
            <th>Terdaftar</th>
            <th>Tipe Pengguna</th>
            <th>Locked</th>
            <?php
            if (in_array('access settings user-edit', $authentication->privileges) ||
                in_array('access settings user-remove', $authentication->privileges)) {
                echo '<th></th>';
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($users)) {
            foreach ($users as $user) {
                
                $meta = '';
                if (!empty($user->meta_data)) {
                    $meta = (object) json_decode($user->meta_data);
                }
                
                echo '<tr>';
                echo '<td>' . anchor('user-profile/' . $user->name, $user->name) . '</td>';
                echo '<td>' . $user->screen . '</td>';
                echo '<td>' . date('d/M/Y H:i', strtotime($user->created)) . '</td>';
                echo '<td>' . $user->role_screen . '</td>';

                $disabled = '';
                if (!in_array('access settings user-locking', $authentication->privileges)) {
                    $disabled = 'disabled';
                }

                $tick = $user->locked != 0 ? 'checked' : '';
                echo '<td><label class="form-check form-switch">'
                    . '<input onclick="locking(' . $user->id . ', \'' . $user->name . '\')" '
                    . 'id="check-lock-' . $user->id . '" class="form-check-input" '
                    . 'type="checkbox" ' . $tick . '  ' . $disabled . ' />'
                    . '</label></td>';

                if (in_array('access settings user-edit', $authentication->privileges) ||
                    in_array('access settings user-remove', $authentication->privileges)) {

                    $edit = '';
                    if (in_array('access settings user-edit', $authentication->privileges)) {
                        $edit = '<a href="javascript:userEdit(' . $user->id . ')" class="btn btn-sm btn-outline-primary" title="Ubah"><i class="ti-pencil"></i></a> ';
                        $account = array(
                            'id' => $user->id,
                            'name' => $user->name,
                            'screen' => $user->screen,
                            'email' => $user->email,
                            'avatar' => !empty($meta->path)? $meta->path : '',
                            'rid' => $user->rid,
                            'phone' => !empty($meta->phone)? $meta->phone : '',
                        );

                        $edit .= '<input type="hidden" id="user-edit-' . $user->id . '" value=\'' . json_encode($account) . '\' />';
                    }

                    $rmv = '';
                    if (in_array('access settings user-remove', $authentication->privileges)) {
                        $rmv = '<a href="javascript:userRemove(' . $user->id . ', \'' . $user->screen . '\')" '
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
