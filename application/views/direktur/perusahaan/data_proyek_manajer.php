<!-- =========================================  -->
<!-- ============== Data Projek Manajer ============== -->
<!-- =========================================  -->
<div class="row">
    <div class="col-12 mb-3 d-flex align-items-center">
        <?php if ($projek_manajer) { ?>
            <h4 class="mb-0 mr-3">Daftar Projek Manajer</h4>
            <button class="btn btn-success btn-sm" onclick="addProjectManager()"> <i class="la la-plus"></i> Tambah</button>
        <?php } ?>
    </div>

    <?php if ($projek_manajer) { ?>
        <?php foreach($projek_manajer as $pm) { ?>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center text-center mb-4">
                            <div class="mandor-profile my-3 mx-auto">
                                <img src="<?= $pm->user_profile == 'default-avatar.jpg' ? base_url('assets/img/'.'default-avatar.jpg') : base_url('uploads/profile/'.$pm->user_profile) ?>">
                            </div>
                            <small>ID: <strong><?= $pm->user_unique_id ?></strong></small>
                        </div>

                        <div class="mb-3">
                            <span class="d-block mb-1"><strong>Nama lengkap</strong></span>
                            <p class="text-secondary"><?= $pm->user_fullname ?></p>
                        </div>

                        <div class="mb-3">
                            <span class="d-block mb-1"><strong>Email</strong></span>
                            <p class="text-secondary"><?= $pm->user_email ?></p>
                        </div>

                        <div>
                            <span class="d-block mb-1"><strong>Jumlah proyek berjalan</strong></span>
                            <p class="text-secondary mb-0"><?= countProjectPM($pm->user_id) ?></p>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col-10 pr-0">
                                <button type="button" onclick="editProjectManager(<?= "'".$pm->user_unique_id."'" ?>, <?= "'".$pm->user_role."'" ?>)" class="btn btn-custom btn-sm btn-block">Edit Profile</button>
                            </div>
                            <div class="col-2 text-center">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" onclick="changePasswordPM(<?= "'".$pm->user_unique_id."'" ?>, <?= "'".$pm->user_role."'" ?>)" href="javascript:void(0)">Ganti password</a>
                                        <a class="dropdown-item text-danger" onclick="deleteProjectManajer(<?= "'".$pm->user_unique_id."'" ?>, <?= "'".$pm->user_role."'" ?>, <?= "'".$pm->user_profile."'" ?>)" href="javascript:void(0)">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="col-12 my-4 text-center">
            <img src="<?= base_url('assets/img/blank.png') ?>" width="120" class="mb-3">
            <h4 class="mb-1">Data proyek manajer belum tersedia.</h4>
            <p class="small text-muted">Klik tombol berikut untuk membuat data Proyek Manajer.</p>
            <button type="button" class="btn btn-sm btn-success py-2 px-4 my-2" onclick="addProjectManager()">Tambah Proyek Manajer</button>
        </div>
    <?php } ?>
</div>