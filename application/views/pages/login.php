<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>
            <?php
            $site_name = 'Open Layers';
            if (!empty($application->app_name)) {
                $site_name = $application->app_name;
            }
            
            $site_name .= ' - Login Pengguna';
            echo $site_name;
            ?>
        </title>
        <link href="<?php echo site_url('assets/img/favicon.png') ?>" rel="shortcut icon" />
        <link href="<?php echo site_url('assets/css/tabler.min.css') ?>" rel="stylesheet" />
        <link href="<?php echo site_url('assets/plugins/themify/themify-icons.css') ?>" rel="stylesheet" />
        <link href="<?php echo site_url('assets/plugins/themify/ie7/ie7.css') ?>" rel="stylesheet" />
        <link href="<?php echo site_url('assets/css/theme.css?v=' . uniqid()) ?>" rel="stylesheet" />
    </head>
    <body  class=" border-top-wide border-primary d-flex flex-column">
        <div class="page page-center">
            <div class="container-tight">
                <div class="text-center mb-3">
                    <?php
                    $logo = $application->app_name;
                    if (!empty($application->app_logo)) {
                        $src = site_url($application->app_logo);
                        $logo = img($src, true, array('alt' => $application->app_name));
                    }
                    
                    echo $logo;
                    ?>
                </div>
                <?php
                #print_r($application);
                $invalid = $this->session->userdata('invalid_login');
                if (!empty($invalid)) {
                    $message = 'Akses ditolak.';
                    echo alert('login-result', $message, 'danger', true, 'alert');
                    $this->session->unset_userdata('invalid_login');
                }
                ?>
                <form class="card card-md" action="" method="post">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Login Pengguna</h2>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="ti ti-user"></i> ID Pengguna <sup>*</sup>
                            </label>
                            <input type="text" name="name" class="form-control" placeholder="User ID" autofocus="true" autocomplete="off" />
                        </div>
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="ti ti-lock"></i> Kata Sandi <sup>*</sup>
                                <span class="form-label-description">
                                    <a href="./forgot-password.html">Lupa Sandi?</a>
                                </span>
                            </label>
                            <div class="input-group input-group-flat">
                                <input type="password" class="form-control" placeholder="Password" name="password" />
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="form-footer">
                            <input type="hidden" value="1" name="login_act" />
                            <button type="submit" class="btn btn-primary w-100">Sign in</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <script src="<?php echo site_url('assets/plugins/jquery-ui/external/jquery/jquery-3.6.0.min.js') ?>"></script>
        <script src="<?php echo site_url('assets/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>
    </body>
</html>