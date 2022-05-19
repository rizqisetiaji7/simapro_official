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
                                    <span class="badge bg-inverse-danger p-2">Tertunda</span>
                                </td>
                                <td class="text-nowrap">12 Agustus 2022</td>
                                <td class="text-nowrap">
                                    <!-- <p class="text-xs mb-1">Completed Projects <strong>(8/12)</strong></p> -->
                                    <div class="progress progress-lg">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 26%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">26%</div>
                                    </div>
                                </td>
                                <td class="text-nowrap text-center">
                                    <button type="button" class="btn btn-sm my-1 btn-info" data-toggle="tooltip" title="Arsipkan"><i class="la la-archive"></i></button>
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
                                    <span class="badge bg-inverse-warning p-2">Berjalan</span>
                                </td>
                                <td class="text-nowrap">12 Agustus 2022</td>
                                <td class="text-nowrap">
                                    <!-- <p class="text-xs mb-1">Completed Projects <strong>(8/12)</strong></p> -->
                                    <div class="progress progress-lg">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                                    </div>
                                </td>
                                <td class="text-nowrap text-center">
                                    <button type="button" class="btn btn-sm my-1 btn-info" data-toggle="tooltip" title="Arsipkan"><i class="la la-archive"></i></button>
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
                                    <span class="badge bg-inverse-success p-2">Sedang ditinjau</span>
                                </td>
                                <td class="text-nowrap">12 Agustus 2022</td>
                                <td class="text-nowrap">
                                    <!-- <p class="text-xs mb-1">Completed Projects <strong>(8/12)</strong></p> -->
                                    <div class="progress progress-lg">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                    </div>
                                </td>
                                <td class="text-nowrap text-center">
                                    <button type="button" class="btn btn-sm my-1 btn-info" data-toggle="tooltip" title="Arsipkan"><i class="la la-archive"></i></button>
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

<!-- Modal -->
<div class="modal fade" id="addProject-modal" tabindex="-1" role="dialog" aria-labelledby="addProject-modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
        <form action="" method="post" accept-charset="utf-8">
            <div class="modal-header">
                <h4 class="modal-title" id="addProject-modalLabel">Tambah Proyek Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- <div class="col col-sm-10 mx-auto">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-center">
                                    <div>
                                        <img src="<?= base_url('assets/img/profiles/avatar-02.jpg') ?>" class="rounded-lg" width="80">
                                        <div class="d-flex flex-row align-items-center mt-2">
                                            Radio Button for thumbnail
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="col-12">
                        <div class="form-group">
                            <label for="judul-proyek">Judul Proyek:</label>
                            <input type="text" id="judul-proyek" name="proyek_name" class="form-control" required placeholder="Ketik judul proyek...">
                        </div>

                        <div class="form-group">
                            <label for="mandor">Penanggung Jawab Lapangan:</label>
                            <select name="mandor" class="custom-select" require>
                                <option value="">Nama mandor 1</option>
                                <option value="">Nama mandor 2</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="mandor">Lokasi/Alamat Proyek:</label>
                            <textarea name="alamat_proyek" class="form-control" rows="4" placeholder="Alamat proyek..."></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="start-proyek">Mulai Pengerjaan:</label>
                                <input type="date" class="form-control" name="start_proyek" id="start-proyek">
                            </div>
                            <div class="form-group col-6">
                                <label for="finish-proyek">Berakhir Pada:</label>
                                <input type="date" class="form-control" name="finish_proyek" id="finish-proyek">
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" name="save_proyek" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
  </div>
</div>