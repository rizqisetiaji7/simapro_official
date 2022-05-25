<!-- Content Starts -->
<div class="row mb-4">
    <div class="col-12 col-sm-6">
        <h3><?= $title ?></h3>
        <div class="d-none d-md-block">
            <ul class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item text-primary text-sm"><a href="<?= site_url('direktur') ?>">Dashboard</a></li>
                <li class="breadcrumb-item text-primary text-sm"><a href="<?= site_url('direktur/perusahaan') ?>">Perusahaan</a></li>
                <li class="breadcrumb-item text-sm active">Detail</li>
            </ul>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    <img alt="" style="object-fit: cover;" src="<?= $company->comp_logo == 'default-placeholder320x320.png' ? base_url('assets/img/'.$company->comp_logo) : base_url('uploads/company/'.$company->comp_logo) ?>">
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="profile-info-left">
                                            <h4 class="m-t-0 mb-3"><?= $director->row()->user_role == 'super_admin' ? '<i class="fa-solid fa-circle-check text-info mr-2"></i>' : NULL ?><?= $company->comp_name ?></h4>
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">ID:</div>
                                                    <div class="text"><span class="text-secondary"><?= $company->comp_code_ID == NULL ? ' - ' : $company->comp_code_ID ?></span></div>
                                                </li>

                                                <li>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><span class="text-secondary"><?= $company->comp_email == NULL ? ' - ' : $company->comp_email ?></span></div>
                                                </li>

                                                <li>
                                                    <div class="title">Telepon:</div>
                                                    <div class="text"><span class="text-secondary"><?= $company->comp_phone == NULL ? ' - ' : $company->comp_phone ?></span></div>
                                                </li>

                                                <li>
                                                    <div class="title">Alamat:</div>
                                                    <div class="text"><span class="text-secondary"><?= $company->comp_address == NULL ? ' - ' : $company->comp_address ?></span></div>
                                                </li>

                                                <li>
                                                    <div class="title">Deskripsi/Bio:</div>
                                                    <div class="text"><?= $company->comp_desc == NULL ? ' - ' : $company->comp_desc ?></div>
                                                </li>
                                                <li>
                                                    <div class="title">Di dirikan pada:</div>
                                                    <div class="text"><span class="text-secondary"><?= $company->comp_since == NULL ? ' - ' : dateTimeIDN($company->comp_since) ?></span></div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-5">

                                        <!-- Bagian Direktur Perusahaan -->
                                        <h4 class="m-t-0 mb-3">Data Direktur <?= $director->row()->user_role == 'super_admin' ? 'Utama' : 'Anak Perusahaan' ?></h4>
                                        <?php if ($director->num_rows() > 0) { ?> 
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Profile:</div>
                                                    <div class="text">
                                                        <div class="avatar-box">
                                                            <div class="avatar avatar-xs">
                                                                <img src="<?= $director->row()->user_profile == 'default-avatar.jpg' ? base_url('assets/img/'.$director->row()->user_profile) : base_url('uploads/profile/'.$director->row()->user_profile) ?>" alt="<?= 'Profile Pic. '.$director->row()->user_fullname  ?>">
                                                            </div>
                                                        </div>
                                                        <span class="text-secondary mb-0 d-inline-block"><?= $director->row()->user_fullname ?></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">ID:</div>
                                                    <div class="text"><span class="text-secondary"><?= $director->row()->user_unique_id == NULL ? '-' : $director->row()->user_unique_id ?></span></div>
                                                </li>
                                                <li>
                                                    <div class="title">Jabatan:</div>
                                                    <div class="text"><span class="text-secondary"><?= $director->row()->user_role == 'super_admin' ? 'Direktur Utama' : 'Direktur' ?></span></div>
                                                </li>

                                                <li>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><span class="text-secondary"><?= $director->row()->user_email == NULL ? '-' : $director->row()->user_email ?></span></div>
                                                </li>
                                                <li class="mt-4">
                                                    <?php if ($director->row()->user_role == 'super_admin') { ?>
                                                        <a href="<?= site_url('direktur/profile') ?>" class="btn btn-custom btn-sm">Lihat Profile</a>
                                                    <?php } else { ?>
                                                        <button class="btn btn-secondary btn-sm" onclick="viewDetailDirector(<?= "'".$director->row()->user_unique_id."'" ?>)" data-toggle="tooltip" title="Lihat detail"><i class="fa-solid fa-up-right-from-square"></i></button>
                                                        <button class="btn btn-success btn-sm" onclick="editDirector(<?= "'".$director->row()->user_unique_id."'" ?>)" data-toggle="tooltip" title="Edit profile"><i class="fa-solid fa-user-pen"></i></button>
                                                        <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus" disabled="disabled"><i class="fa-solid fa-trash-can"></i></button>
                                                        <!-- <button class="btn btn-light btn-sm" onclick="changePassword(<?= "'".$director->row()->user_unique_id."'" ?>, <?= "'".$director->row()->user_role."'" ?>)"><i class="fa-solid fa-key mr-1"></i> Ganti password</button> -->
                                                    <?php } ?>
                                                </li>
                                            </ul>
                                        <?php } else { ?> 
                                            <p class="text-muted">Data direktur belum tersedia. Silahkan klik tombol berikut untuk menambahkan direktur.</p>
                                            <button type="button" onclick="addDirector(<?= "'".$company->comp_handle_ID."'" ?>, <?= $company->company_id ?>, <?= "'".$user_role."'" ?>)" class="btn btn-success btn-sm">Tambah direktur</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =========================================  -->
<!-- ============== Data Mandor ============== -->
<!-- =========================================  -->

<?php if ($director->num_rows() > 0) { ?>
<div class="row">
    <div class="col-12 mb-3 d-flex align-items-center">
        <h4 class="mb-0 mr-3">Daftar Karyawan (Mandor)</h4>
        <?php if ($director->row()->user_role == 'super_admin') { ?>
        <button class="btn btn-success btn-sm" onclick="addEmployee(<?= $company->company_id ?>, <?= "'".$company->comp_handle_ID."'" ?>, 'tambah')"> <i class="la la-plus"></i> Tambah</button>
        <?php } ?>
    </div>

    <?php if ($mandor) { ?>
        <?php foreach ($mandor as $mdr) { ?>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center text-center mb-4">
                            <div class="mandor-profile my-3 mx-auto">
                                <img src="<?= $mdr->user_profile == 'default-avatar.jpg' ? base_url('assets/img/'.$mdr->user_profile) : base_url('uploads/profile/'.$mdr->user_profile) ?>">
                            </div>
                            <small>ID: <strong><?= $mdr->uniqID ?></strong></small>
                        </div>

                        <div class="mb-3">
                            <span class="d-block mb-1"><strong>Nama lengkap</strong></span>
                            <p class="text-secondary"><?= $mdr->user_fullname ?></p>
                        </div>

                        <div class="mb-3">
                            <span class="d-block mb-1"><strong>Email</strong></span>
                            <p class="text-secondary"><?= $mdr->user_email ?></p>
                        </div>

                        <div>
                            <span class="d-block mb-1"><strong>Jumlah proyek berjalan</strong></span>
                            <p class="text-secondary mb-0">0</p>
                        </div>
                    </div>

                    <?php if ($director->row()->user_role == 'super_admin') { ?>
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col-10 pr-0">
                                <button type="button" onclick="editEmployee(<?= $mdr->ID_company ?>, <?= "'".$mdr->uniqID."'" ?>)" class="btn btn-custom btn-sm btn-block">Edit Profile</button>
                            </div>
                            <div class="col-2 text-center">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" onclick="showDetailEmployee(<?= "'".$mdr->uniqID."'" ?>, <?= "'".$mdr->user_role."'" ?>)" href="javascript:void(0)">Detail</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Ganti password</a>
                                        <a class="dropdown-item text-danger" href="javascript:void(0)">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } elseif ($director->row()->user_role == 'admin') { ?>
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <button type="button" onclick="showDetailEmployee(<?= "'".$mdr->uniqID."'" ?>, <?= "'".$mdr->user_role."'" ?>)" class="btn btn-custom btn-sm btn-block">Detail</button>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="col-12">
            <?php if ($director->row()->user_role == 'super_admin') { ?>
                <p><i class="fa fa-warning text-warning mr-2"></i>Data mandor tidak terdaftar. Silahkan klik tombol <b class="text-success">Tambah</b> diatas untuk menambahkan data mandor.</p>
            <?php } else { ?>
                <p class="text-muted"><i class="fa fa-warning text-warning mr-2"></i> Tidak ada data mandor anak perusahaan.</p>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<?php } ?>

<?php $this->view('direktur/perusahaan/detail/modal'); ?>
<?php $this->view('direktur/perusahaan/detail/script'); ?>