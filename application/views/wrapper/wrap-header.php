<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="sticky-top">
    <header class="navbar navbar-expand-md navbar-light sticky-top d-print-none">
        <div class="<?php echo $container_mode ?>">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3"> -->
            <h1 class="navbar-logo">
                <a href="<?php echo site_url() ?>" title="<?php echo $application->app_name ?>">
                    <?php
                    $logo = $application->app_name;
                    if (!empty($application->app_logo)) {
                        $src = site_url($application->app_logo);
                        $logo = img($src, true, array('alt' => $application->app_name));
                    }
                    
                    echo $logo;
                    ?>
                </a>
            </h1>
            <div class="navbar-nav flex-row order-md-last">
                <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                    <span class="ti ti-light-bulb"></span>
                </a>
                <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                    <span class="ti ti-shine"></span>
                </a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                        <?php
                        $avatar = 'assets/img/no-avatar.jpg';
                        if (!empty($authentication->user->meta_data)) {
                            $meta = json_decode($authentication->user->meta_data);
                            if (!empty($meta->path)) {
                                $avatar = $meta->path;
                            }
                        }
                        
                        $avatar = site_url($avatar);
                        ?>
                        <span class="avatar avatar-sm" style="background-image: url(<?php echo $avatar ?>)"></span>
                        <div class="d-none d-xl-block ps-2">
                            <div><?php echo $authentication->user->screen ?></div>
                            <div class="mt-1 small text-muted"><?php echo $authentication->user->role_screen ?></div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="<?php echo site_url('user-profile/' . $authentication->user->name) ?>" class="dropdown-item">Profil Akun</a>
                        <a href="<?php echo site_url('update-password') ?>" class="dropdown-item">Ubah Sandi</a>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo site_url('logout') ?>" class="dropdown-item">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="navbar navbar-light">
                <div class="<?php echo $container_mode ?>">
                    <ul class="navbar-nav">
                        <?php
                        $privs = $authentication->privileges;
                        $ruri = implode('/', $this->uri->segment_array());
                        foreach ($admin_menu as $key => $item) {
                            
                            $item = (object) $item;
                            if (!empty($item->args)) {
                                if (!in_array($item->args, $privs)) continue;
                            }
                            
                            $type = 'nav-item';
                            if (!empty($item->type)) {
                                $type .= ' ' . $item->type;
                            }
                            
                            $toggle = 'title="' . $item->label . '"';
                            $link = 'nav-link';
                            $href = '';
                            if ($type == 'nav-item dropdown') {
                                $link .= ' dropdown-toggle';
                                $href = '#' . $key;
                                $toggle .= ' data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false"';
                            }
                            
                            if (!empty($item->uri)) {
                                $href = site_url($item->uri);
                            }
                            
                            echo '<li class="' . $type . '">';
                            echo '<a class="' . $link . '" href="' . $href . '" ' . $toggle . '>';
                            if (!empty($item->icon)) {
                                echo '<i class="ti ' . $item->icon . '"></i>';
                            }
                            
                            echo $item->label . '</a>';
                            if (!empty($item->childs)) {
                                echo '<div class="dropdown-menu">';
                                foreach ($item->childs as $c_key => $c_item) {
                                    $c_item = (object) $c_item;
                                    if (!empty($c_item->args)) {
                                        if (!in_array($c_item->args, $privs)) continue;
                                    }
                                    
                                    if (!empty($c_item->childs)) {
                                        echo '<div class="dropend">';
                                        echo '<a class="dropdown-item dropdown-toggle" href="#' . $c_item->label . '" data-bs-toggle="dropdown" '
                                                . 'title="' . $c_item->label . '" data-bs-auto-close="outside" role="button" aria-expanded="false">';
                                        echo $c_item->label . '</a>';
                                        echo '<div class="dropdown-menu">';
                                        foreach ($c_item->childs as $gc_key => $gc_item) {
                                            $gc_item = (object) $gc_item;
                                            if (!empty($gc_item->args)) {
                                                if (!in_array($gc_item->args, $privs)) continue;
                                            }
                                            
                                            echo anchor($gc_item->uri, $gc_item->label, array('class' => 'dropdown-item', 'title' => $gc_item->label));
                                        }
                                        echo '</div></div>';
                                    } else {
                                        $uri = !empty($c_item->uri)? $c_item->uri : '#' . $c_key;
                                        echo anchor($uri, $c_item->label, array('class' => 'dropdown-item', 'title' => $c_item->label));
                                    }
                                }
                                
                                echo '</div>';
                            }
                            
                            echo '</li>';
                        }
                        ?>
                    </ul>
                    <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                        <form action="." method="get">
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i class="ti-search"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Search…" aria-label="Search in website">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>