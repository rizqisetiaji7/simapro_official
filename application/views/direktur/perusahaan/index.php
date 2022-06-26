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
                                    <img alt="" style="object-fit: cover;" src="<?= $main_comp->comp_logo != 'default-placeholder320x320.png' ? base_url('uploads/company/'.$main_comp->comp_logo) : base_url('assets/img/'.'default-placeholder320x320.png') ?>">
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="profile-info-left">
                                            <h4 class="m-t-0 mb-3"><?= $main_comp->comp_parent_id != 0 ? $main_comp->comp_name : '<i class="fa-solid fa-circle-check text-info mr-2"></i> '. $main_comp->comp_name ?></h4>
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">ID:</div>
                                                    <div class="text"><span class="text-secondary"><?= $main_comp->comp_code ?></span></div>
                                                </li>

                                                <li>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><span class="text-secondary"><?= $main_comp->comp_email ?></span></div>
                                                </li>

                                                <li>
                                                    <div class="title">Telepon:</div>
                                                    <div class="text"><span class="text-secondary"><?= $main_comp->comp_phone == '' ? '-' : $main_comp->comp_phone ?></span></div>
                                                </li>

                                                <li>
                                                    <div class="title">Alamat:</div>
                                                    <div class="text"><span class="text-secondary"><?= $main_comp->comp_address == '' ? '-' : $main_comp->comp_address ?></span></div>
                                                </li>

                                                <li>
                                                    <div class="title">Di dirikan pada:</div>
                                                    <div class="text"><span class="text-secondary"><?= datetimeIDN($main_comp->comp_since) ?></span></div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-5">

                                        <!-- Bagian Direktur Perusahaan -->
                                        <h4 class="m-t-0 mb-3">Data Direktur <?= $main_comp->user_role == 'direktur' ? 'Utama' : NULL ?></h4>
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Profile:</div>
                                                <div class="text">
                                                    <div class="avatar-box">
                                                        <div class="avatar avatar-xs">
                                                            <img src="<?= $main_comp->user_profile == 'default-avatar.jpg' ? base_url('assets/img/default-avatar.jpg') : base_url('uploads/profile/'.$main_comp->user_profile) ?>" alt="<?= $main_comp->user_fullname ?>">
                                                        </div>
                                                    </div>
                                                    <span class="text-secondary mb-0 d-inline-block"><?= $main_comp->user_fullname ?></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">ID:</div>
                                                <div class="text"><span class="text-secondary"><?= $main_comp->user_unique_id ?></span></div>
                                            </li>

                                            <li>
                                                <div class="title">Email:</div>
                                                <div class="text"><span class="text-secondary"><?= $main_comp->user_email ?></span></div>
                                            </li>

                                            <li class="mt-4">
                                                <a href="<?= site_url('direktur/profile') ?>" class="btn btn-custom btn-sm">Lihat Profile</a>
                                            </li>
                                        </ul>
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

<!-- Tampil data proyek manajer by ajax request -->
<div id="dataProyekManajer"></div>

<!-- Script And Modal -->
<?php $this->view('direktur/perusahaan/modal') ?>
<?php $this->view('direktur/perusahaan/script') ?>