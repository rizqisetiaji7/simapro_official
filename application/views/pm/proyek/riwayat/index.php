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
</div>

<form action="" method="POST" accept-charset="utf-8">
    <div class="row">
        <div class="col-4 col-sm-6 col-md-3">
            <select id="first_month" name="bulan_awal" class="form-control mb-3">
                <option value="">-- Pilih Bulan Awal --</option>
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
        
        <div class="px-3 text-center d-none d-md-block">
            <span class="text-muted d-block my-2">s/d</span>
        </div>

        <div class="col-4 col-sm-6 col-md-3">
            <select id="last_month" name="bulan_akhir" class="form-control mb-3">
                <option value="">-- Pilih Bulan Akhir --</option>
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

        <div class="col-4 col-sm-4 col-md-2">
            <select id="selectYear" name="tahun_proyek" class="form-control mb-3"></select>
        </div>

        <div class="col-12 col-sm-8 col-md-3">
            <button type="button" class="btn btn-info py-2 mr-1 mb-3" id="btn-filterData" data-toggle="tooltip" title="Filter"><i class="fa-solid fa-filter"></i> Filter data</button>
            <button type="submit" class="btn btn-success py-2 mb-3" id="btn-downloadData" data-toggle="tooltip"><i class="fa-solid fa-download"></i> Download</button>
        </div>
    </div>
</form>

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
                                <th>Deadline Akhir</th>
                                <th width="140px">Progress</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('assets/img/profiles/avatar-02.jpg') ?>" class="rounded-lg" width="50" alt="">
                                        <div class="ml-3">
                                            <h5 class="mb-0">Proyek Irigasi Sungai</h5>
                                            <p class="mb-0 text-xs text-muted">Kab. Ciamis</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('assets/img/profiles/avatar-02.jpg') ?>" class="rounded-lg" width="40" alt="">
                                        <div class="ml-3">
                                            <h5 class="mb-0">Rizqi PM</h5>
                                            <p class="mb-0 text-xs text-secondary">PT. Aryabakti Saluyu</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <span class="badge bg-inverse-success p-2">Selesai</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-muted small">12 Februari 2022</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-muted small">20 Februari 2022</span>
                                </td>
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
                                            <h5 class="mb-0">Pembangunan Mall</h5>
                                            <p class="mb-0 text-xs text-muted">Kab. Ciamis</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('assets/img/profiles/avatar-02.jpg') ?>" class="rounded-lg" width="40" alt="">
                                        <div class="ml-3">
                                            <h5 class="mb-0">Rizqi PM</h5>
                                            <p class="mb-0 text-xs text-secondary">PT. Aryabakti Saluyu</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <span class="badge bg-inverse-success p-2">Selesai</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-muted small">15 November 2020</span>
                                </td>
                                <td class="text-nowrap">
                                    <span class="text-muted small">8 November 2020</span>
                                </td>
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
                            <!-- <tr>
                                <td colspan="7" class="text-center">Riwayat Proyek Kosong.</td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>
</div>

<script>
    // Year Dropdown Lists
    let start = 2000;
    let end = new Date().getFullYear() + 50;
    let currDate = new Date().getFullYear();
    let options = "";
    for(let year = start ; year <= end; year++){
      options += `<option value="${year}" ${year == currDate ? 'selected' : ''}>${year}</option>`;
    }
    $('#selectYear').append(options);
</script>