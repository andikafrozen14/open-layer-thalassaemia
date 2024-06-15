<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<input type="text" id="item-founder" placeholder="access filter..." />
<div class="mt-4 role-perms">
    <?php
    foreach ($perms as $q => $privs) {
        #if (isset($privs['hidden'])) continue;
        foreach ($privs['list'] as $q2 => $priv) {
            $priv = (object) $priv;
            $c = '';
            if (!empty($role_perms)) {
                if (in_array($priv->key, $role_perms)) {
                    $c = 'checked';
                }
            }
        ?>
    <div class="perm-list mb-3">
        <label class="form-check">
            <input name="role_perms[]" type="checkbox" class="form-check-input" value="<?php echo $priv->key ?>" <?php echo $c ?> />
            <span class="form-check-label"><code><?php echo $priv->key ?></code></span><br />
            <small class="text-muted"><i class="ti ti-arrow-circle-right"></i> <?php echo $priv->desc ?></small>
        </label>
    </div>
        <?php
        }
    }
    ?>
</div>