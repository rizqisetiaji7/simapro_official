<!-- Content Starts -->
<div class="row mb-4">
    <div class="col-12 col-sm-6">
        <h3>Daftar riwayat proyek</h3>
        <div class="d-none d-md-block">
            <ul class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item text-primary text-sm"><a href="<?= site_url('direktur') ?>">Dashboard</a></li>
                <li class="breadcrumb-item text-sm active"><?= $title ?></li>
            </ul>
        </div>
    </div>

    <!-- <div class="col-12 col-sm-6 text-sm-right">
        <button type="button" class="btn btn-success py-2 px-3 ml-1" data-toggle="tooltip" title="Download laporan proyek">
            <i class="fa-solid fa-download"></i> Download
        </button>
    </div> -->
</div>

<div class="form-row">
    <div class="col-5 col-sm-3">
        <select name="from_month" class="form-control mb-3">
            <option value="01">Januari</option>
            <option value="02">Februari</option>
            <option value="03">Maret</option>
            <option value="04">April</option>
            <option value="05">Mei</option>
            <option value="06">Juni</option>
            <option value="07">Juli</option>
            <option value="08">Agustus</option>
            <option value="09">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
        </select>
    </div>
    
    <div class="col-1 text-center">
        <span class="text-muted d-block my-2">s/d</span>
    </div>

    <div class="col-6 col-sm-3">
        <select name="to_month" class="form-control mb-3">
            <option value="01">Januari</option>
            <option value="02">Februari</option>
            <option value="03">Maret</option>
            <option value="04">April</option>
            <option value="05">Mei</option>
            <option value="06">Juni</option>
            <option value="07">Juli</option>
            <option value="08">Agustus</option>
            <option value="09">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
        </select>
    </div>

    <div class="col-9 col-sm-3 pr-0">
        <select name="year" class="form-control mb-3" id="">
            <option value="2022">2022</option>
            <option value="2021">2021</option>
            <option value="2020">2020</option>
            <option value="2019">2019</option>
            <option value="2018">2018</option>
        </select>
    </div>

    <div class="col-3 col-sm-2 text-right text-md-center">
        <button type="submit" class="btn btn-secondary py-2 mr-1 mb-3" data-toggle="tooltip" title="Filter"><i class="fa-solid fa-filter"></i></button>
        <button type="submit" class="btn btn-success py-2 mb-3" data-toggle="tooltip" title="Download"><i class="fa-solid fa-download"></i></button>
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
                                            <h4 class="mb-0">Proyek Rumah Sakit Kawali</h4>
                                            <p class="mb-0 text-xs text-muted">Jl. Martadinata, No. 13, Kab. Ciamis</p>
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
                                    <span class="badge bg-inverse-success p-2">Selesai</span>
                                </td>
                                <td class="text-nowrap">12 Agustus 2022</td>
                                <td class="text-nowrap">
                                    <!-- <p class="text-xs mb-1">Completed Projects <strong>(8/12)</strong></p> -->
                                    <div class="progress progress-lg">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                    </div>
                                </td>
                                <td class="text-nowrap text-center">
                                    <!-- <button type="button" class="btn btn-sm my-1 btn-info" data-toggle="tooltip" title="Download laporan"><i class="la la-download"></i></button> -->
                                    <a href="<?= site_url('direktur/proyek/detail_proyek') ?>" class="btn btn-sm my-1 btn-primary text-nowrap" data-toggle="tooltip" title="Lihat Proyek">Detail</a>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('assets/img/profiles/avatar-02.jpg') ?>" class="rounded-lg" width="50" alt="">
                                        <div class="ml-3">
                                            <h4 class="mb-0">Proyek Rumah Sakit Kawali</h4>
                                            <p class="mb-0 text-xs text-muted">Jl. Martadinata, No. 13, Kab. Ciamis</p>
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
                                    <span class="badge bg-inverse-success p-2">Selesai</span>
                                </td>
                                <td class="text-nowrap">12 Agustus 2022</td>
                                <td class="text-nowrap">
                                    <!-- <p class="text-xs mb-1">Completed Projects <strong>(8/12)</strong></p> -->
                                    <div class="progress progress-lg">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                    </div>
                                </td>
                                <td class="text-nowrap text-center">
                                    <!-- <button type="button" class="btn btn-sm my-1 btn-info" data-toggle="tooltip" title="Download laporan"><i class="la la-download"></i></button> -->
                                    <a href="<?= site_url('direktur/proyek/detail_proyek') ?>" class="btn btn-sm my-1 btn-primary text-nowrap" data-toggle="tooltip" title="Lihat Proyek">Detail</a>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('assets/img/profiles/avatar-02.jpg') ?>" class="rounded-lg" width="50" alt="">
                                        <div class="ml-3">
                                            <h4 class="mb-0">Proyek Rumah Sakit Kawali</h4>
                                            <p class="mb-0 text-xs text-muted">Jl. Martadinata, No. 13, Kab. Ciamis</p>
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
                                    <span class="badge bg-inverse-success p-2">Selesai</span>
                                </td>
                                <td class="text-nowrap">12 Agustus 2022</td>
                                <td class="text-nowrap">
                                    <!-- <p class="text-xs mb-1">Completed Projects <strong>(8/12)</strong></p> -->
                                    <div class="progress progress-lg">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                    </div>
                                </td>
                                <td class="text-nowrap text-center">
                                    <!-- <button type="button" class="btn btn-sm my-1 btn-info" data-toggle="tooltip" title="Download laporan"><i class="la la-download"></i></button> -->
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