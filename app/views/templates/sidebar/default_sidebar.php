<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu d-flex flex-column ">
            <ul>
                <li class="menu-title mt-3"><span>Main</span></li>
                <li>
                    <a href="<?= site_url() ?>">
                        <i class="la la-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="submenu">
                    <a href="#"><i class="la la-rocket"></i> <span> Proyek</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="<?= site_url() ?>">Daftar proyek</a></li>
                        <li><a href="<?= site_url() ?>">Riwayat</a></li>
                        <li><a href="<?= site_url() ?>">Arsip</a></li>
                    </ul>
                </li>

                <li class="menu-title mt-3"><span>Akun</span></li>
                <li>
                    <a href="<?= site_url('profile') ?>"><i class="la la-user"></i> <span>Profile</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>