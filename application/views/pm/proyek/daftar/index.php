<!-- Content Starts -->
<div class="row mb-4">
    <div class="col-12 col-sm-6">
        <h3>Daftar proyek terbaru</h3>
        <div class="d-none d-md-block">
            <ul class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item text-primary text-sm"><a href="<?= site_url('direktur') ?>">Dashboard</a></li>
                <li class="breadcrumb-item text-sm active"><?= $title ?></li>
            </ul>
        </div>
    </div>

    <!-- Tombol muncul setelah terdapat proyek -->
    <div class="col-12 col-sm-6 text-sm-right">
        <button type="button" class="btn btn-success py-2 px-4 my-2" data-toggle="modal" data-target="#addProject-modal">Tambah Proyek</button>
    </div>
</div>

<div class="row">
    <div class="col-12 d-flex">
        <div class="card card-table flex-fill">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless custom-table mb-0">
                        <thead>
                            <tr>
                                <th>Nama Proyek</th>
                                <th>Penanggung Jawab</th>
                                <th>Status</th>
                                <th>Deadline</th>
                                <th width="140px">Progres</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('assets/img/profiles/avatar-02.jpg') ?>" class="rounded-lg" width="50" alt="">
                                        <div class="ml-3">
                                            <h5 class="mb-0">Perbaikan Jembatan Cirahong</h5>
                                            <p class="mb-0 text-xs text-muted">Desa Cirahong, Kab. Ciamis</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('assets/img/default-avatar.jpg') ?>" class="rounded-lg" width="40">
                                        <div class="ml-3">
                                            <h5 class="mb-0">Rizqi PM</h5>
                                            <p class="mb-0 text-xs text-secondary">PT. Aryabakti Saluyu</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <span class="badge bg-inverse-warning p-2">Direvisi</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-secondary small">12 Agustus 2022</span>
                                </td>
                                <td class="text-nowrap">
                                    <div class="progress progress-lg">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                    </div>
                                </td>
                                <td class="text-nowrap text-center">
                                    <button type="button" onclick="editProjectStatus()" class="btn btn-sm my-1 btn-danger" data-toggle="tooltip" title="Ubah status"><i class="fas fa-edit"></i></button>
                                    <a href="<?= site_url('pm/proyek/detail') ?>" class="btn btn-sm my-1 btn-primary text-nowrap" data-toggle="tooltip" title="Lihat Proyek">Detail</a>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('assets/img/profiles/avatar-02.jpg') ?>" class="rounded-lg" width="50" alt="">
                                        <div class="ml-3">
                                            <h5 class="mb-0">Pembangunan SMPN 2 Cijeungjing</h5>
                                            <p class="mb-0 text-xs text-muted">Desa Cijeungjing, Kab. Ciamis</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('assets/img/default-avatar.jpg') ?>" class="rounded-lg" width="40">
                                        <div class="ml-3">
                                            <h5 class="mb-0">Rizqi PM</h5>
                                            <p class="mb-0 text-xs text-secondary">PT. Aryabakti Saluyu</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <span class="badge bg-inverse-info p-2">Berjalan</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-secondary small">24 Mei 2023</span>
                                </td>
                                <td class="text-nowrap">
                                    <div class="progress progress-lg">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
                                    </div>
                                </td>
                                <td class="text-nowrap text-center">
                                    <button type="button" onclick="editProjectStatus()" class="btn btn-sm my-1 btn-danger" data-toggle="tooltip" title="Ubah status"><i class="fas fa-edit"></i></button>
                                    <a href="<?= site_url('pm/proyek/detail') ?>" class="btn btn-sm my-1 btn-primary text-nowrap" data-toggle="tooltip" title="Lihat Proyek">Detail</a>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('assets/img/profiles/avatar-02.jpg') ?>" class="rounded-lg" width="50" alt="">
                                        <div class="ml-3">
                                            <h5 class="mb-0">Rumah Sakit Kawali</h5>
                                            <p class="mb-0 text-xs text-muted">Desa Kawali, Kab. Ciamis</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('assets/img/default-avatar.jpg') ?>" class="rounded-lg" width="40">
                                        <div class="ml-3">
                                            <h5 class="mb-0">Rizqi PM</h5>
                                            <p class="mb-0 text-xs text-secondary">PT. Aryabakti Saluyu</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <span class="badge bg-inverse-info p-2">Berjalan</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-secondary small">24 Desember 2023</span>
                                </td>
                                <td class="text-nowrap">
                                    <div class="progress progress-lg">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">40%</div>
                                    </div>
                                </td>
                                <td class="text-nowrap text-center">
                                    <button type="button" onclick="editProjectStatus()" class="btn btn-sm my-1 btn-danger" data-toggle="tooltip" title="Ubah status"><i class="fas fa-edit"></i></button>
                                    <a href="<?= site_url('pm/proyek/detail') ?>" class="btn btn-sm my-1 btn-primary text-nowrap" data-toggle="tooltip" title="Lihat Proyek">Detail</a>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('assets/img/profiles/avatar-02.jpg') ?>" class="rounded-lg" width="50" alt="">
                                        <div class="ml-3">
                                            <h5 class="mb-0">Pembangunan Jalan Raya Ciamis - Cidolog</h5>
                                            <p class="mb-0 text-xs text-muted">Kab. Ciamis</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('assets/img/default-avatar.jpg') ?>" class="rounded-lg" width="40">
                                        <div class="ml-3">
                                            <h5 class="mb-0">Rizqi PM</h5>
                                            <p class="mb-0 text-xs text-secondary">PT. Aryabakti Saluyu</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <span class="badge bg-inverse-danger p-2">Pending</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-secondary small">10 Agustus 2024</span>
                                </td>
                                <td class="text-nowrap">
                                    <div class="progress progress-lg">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
                                    </div>
                                </td>
                                <td class="text-nowrap text-center">
                                    <button type="button" class="btn btn-sm my-1 btn-info" data-toggle="tooltip" title="Arsipkan"><i class="la la-archive"></i></button>
                                    <button type="button" onclick="editProjectStatus()" class="btn btn-sm my-1 btn-danger" data-toggle="tooltip" title="Ubah status"><i class="fas fa-edit"></i></button>
                                    <a href="<?= site_url('pm/proyek/detail') ?>" class="btn btn-sm my-1 btn-primary text-nowrap" data-toggle="tooltip" title="Lihat Proyek">Detail</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>
</div>

<!-- Kode berikut akan muncul jika proyek belum ada -->
<!-- <div class="row">
    <div class="col-12 my-5 text-center">
        <img src="<?= base_url('assets/img/blank.png') ?>" width="120" class="mb-3">
        <h3 class="mb-1">Proyek belum tersedia.</h3>
        <p class="small text-muted">Klik tombol tambah berikut untuk membuat proyek baru.</p>
        <button type="button" class="btn btn-success py-2 px-4 my-2" data-toggle="modal" data-target="#addProject-modal">Tambah Proyek</button>
    </div>
</div> -->

<?php $this->view('pm/proyek/daftar/modal'); ?>