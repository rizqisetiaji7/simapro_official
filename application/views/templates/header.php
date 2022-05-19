<!-- Header -->
    <div class="header">
        <!-- Logo -->
        <div class="header-left">
            <a href="<?= site_url() ?>" class="logo">
                <img src="<?= base_url('assets/img/simapro/logo-icon-white.svg') ?>" width="40" height="40" alt="">
            </a>
        </div>
        <!-- /Logo -->
        <a id="toggle_btn" href="javascript:void(0);">
            <span class="bar-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </a>
        
        <!-- Header Title -->
        <div class="page-title-box"><h3><?= $title ?></h3></div>
        <!-- /Header Title -->
        
        <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
        
        <!-- Header Menu -->
        <ul class="nav user-menu">
            <li class="nav-item">
                <div class="d-flex align-items-center h-100">
                    <div class="status-toggle">
                        <input type="checkbox" id="theme_mode" data-userid="<?= user_login()->user_id ?>" class="check">
                        <label for="theme_mode" class="checktoggle">checkbox</label>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown has-arrow main-drop">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                    <?php $user_photo = user_login()->user_profile == 'default-avatar.jpg' ? base_url('assets/img/'.user_login()->user_profile) : base_url('uploads/profile/'.user_login()->user_profile); ?>
                    <span class="user-img"><img src="<?= $user_photo ?>" alt="<?= user_login()->user_fullname ?>">
                    <span class="status online"></span></span>
                    <span><?= user_login()->user_fullname ?></span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0)" onclick="showConfirm()">Logout</a>
                </div>
            </li>
        </ul>
        <!-- /Header Menu -->
        
        <!-- Mobile Menu -->
        <div class="dropdown mobile-user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="javascript:void(0)" onclick="showConfirm()">Logout</a>
            </div>
        </div>
        <!-- /Mobile Menu -->
    </div>
    <!-- /Header -->