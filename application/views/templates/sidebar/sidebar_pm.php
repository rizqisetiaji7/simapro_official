<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu d-flex flex-column ">
            <ul>
                <li class="menu-title mt-3"><span>Main</span></li>
                <li>
                    <a href="<?= site_url('pm') ?>">
                        <i class="la la-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="submenu">
                    <a href="#">
                        <i class="la la-rocket"></i> <span> Proyek</span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="display: none;">
                        <li><a href="<?= site_url('pm/proyek') ?>">Daftar proyek</a></li>
                        <li><a href="<?= site_url('pm/proyek/riwayat') ?>">Riwayat</a></li>
                        <li><a href="<?= site_url('pm/arsip') ?>">Arsip</a></li>
                    </ul>
                </li>

                <li class="menu-title mt-3"><span>Pengaturan</span></li>
                <li>
                    <a href="<?= site_url('pm/profile') ?>"><i class="las la-user-cog"></i><span>Profile</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>