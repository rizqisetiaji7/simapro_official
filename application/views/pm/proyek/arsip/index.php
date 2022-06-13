<!-- Content Starts -->
<div class="row mb-4">
    <div class="col-12 col-sm-6">
        <h3>Proyek Diarsipkan</h3>
        <div class="d-none d-md-block">
            <ul class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item text-primary text-sm"><a href="<?= site_url('direktur') ?>">Dashboard</a></li>
                <li class="breadcrumb-item text-sm active"><?= $title ?></li>
            </ul>
        </div>
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
                                            <h5 class="mb-0">Pembangunan Gedung Perpus...</h5>
                                            <p class="mb-0 text-xs text-muted">Kab. Ciamis</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('assets/img/profiles/avatar-02.jpg') ?>" class="rounded-lg" width="40" alt="">
                                        <div class="ml-3">
                                            <h5 class="mb-0">Rizqi Setiaji</h5>
                                            <p class="mb-0 text-xs text-secondary">PT. Aryabakti Saluyu</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <span class="badge bg-inverse-danger p-2">Tertunda</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-secondary small">12 Agustus 2022</span>
                                </td>
                                <td class="text-nowrap">
                                    <!-- <p class="text-xs mb-1">Completed Projects <strong>(8/12)</strong></p> -->
                                    <div class="progress progress-lg">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 26%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">26%</div>
                                    </div>
                                </td>
                                <td class="text-nowrap text-center">
                                    <button type="button" class="btn btn-sm my-1 btn-info" data-toggle="tooltip" title="Kembalikan proyek"><i class="fa-solid fa-arrow-up-from-bracket"></i></button>
                                    <a href="<?= site_url('direktur/proyek/detail_proyek') ?>" class="btn btn-sm my-1 btn-primary text-nowrap" data-toggle="tooltip" title="Lihat Proyek">Detail</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>
</div>

<!-- Jika Arsip Kosong maka kode berikut ditampilkan -->
<!-- <div class="row">
    <div class="col-12 my-5 text-center">
        <img src="<?= base_url('assets/img/blank.png') ?>" width="120" class="mb-3">
        <h3 class="mb-1">Arsip proyek tidak tersedia.</h3>
        <p class="small text-muted">Hanya proyek berstatus tertunda/pending yang akan ditampilkan sebagai arsip.</p>
    </div>
</div> -->