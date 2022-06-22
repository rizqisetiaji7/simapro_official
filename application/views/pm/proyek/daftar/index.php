<!-- <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php 

                    $str = 'PROYM100921';
                    $enc = $this->str_secure->encryptid($str);
                    $dec = $this->str_secure->decryptid($enc);

                    echo "Encrypted: $enc <br/>";
                    echo "Decrypted: $dec <br/>";
                ?>
            </div>
        </div>
    </div>
</div>   -->


<!-- Content Starts -->
<div class="row mb-4">
    <div class="col-12 col-sm-6">
        <h3>Daftar proyek terbaru</h3>
        <div class="d-none d-md-block">
            <ul class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item text-primary text-sm"><a href="<?= site_url('pm') ?>">Dashboard</a></li>
                <li class="breadcrumb-item text-sm active"><?= $title ?></li>
            </ul>
        </div>
    </div>

    <?php if ($projects) { ?>
    <div class="col-12 col-sm-6 text-sm-right">
        <button type="button" class="btn btn-success py-2 px-4 my-2" onclick="addNewProject()">Tambah Proyek</button>
    </div>
    <?php } ?>
</div>

<?php if($projects) { ?>
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
                            <?php foreach($projects as $pro) { ?>
                                <tr>
                                    <td class="text-nowrap">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= $pro->project_thumbnail == 'placeholder.jpg' ? base_url('assets/img/placeholder.jpg') : base_url('uploads/thumbnail/'.$pro->project_thumbnail) ?>" class="rounded-lg" width="50">
                                            <div class="ml-3">
                                                <h5 class="mb-0"><?= $pro->project_name ?></h5>
                                                <p class="mb-0 text-xs text-muted"><?= $pro->project_address ?></p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php if ($pro->user_id != NULL) { ?>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= $pro->user_profile == 'default-avatar.jpg' ? base_url('assets/img/default-avatar.jpg') : base_url('uploads/profile/'.$pro->user_profile) ?>" class="rounded-lg" width="40">
                                                <div class="ml-3">
                                                    <h5 class="mb-0"><?= $pro->user_fullname ?></h5>
                                                    <p class="mb-0 text-xs text-secondary"><?= $pro->comp_name ?></p>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <p class="mb-0 text-danger small text-center">Tidak Terdaftar</p>
                                        <?php } ?>
                                    </td>
                                    <td class="text-nowrap">
                                        <?php 
                                            if ($pro->project_status == 'none') {
                                                echo '<span class="badge bg-inverse-light p-2"><span class="text-dark">Belum ada</span></span>';
                                            } else if ($pro->project_status == 'pending') {
                                                echo '<span class="badge bg-inverse-danger p-2">Ditunda</span>';
                                            } else if ($pro->project_status == 'finish') {
                                                echo '<span class="badge bg-inverse-success p-2">Selesai</span>';
                                            } else if ($pro->project_status == 'revision') {
                                                echo '<span class="badge bg-inverse-warning p-2"><i class="fas fa-pencil mr-1"></i> Revisi</span>';
                                            } else if ($pro->project_status == 'review') {
                                                echo '<span class="badge bg-inverse-purple p-2"><i class="fas fa-eye mr-1"></i> Sedang Diperiksa</span>';
                                            } else if ($pro->project_status == 'on_progress') {
                                                echo '<span class="badge bg-inverse-info p-2">Berjalan</span>';
                                            }
                                        ?>
                                    </td>
                                    <td class="text-nowrap">
                                        <span class="text-secondary small"><?= datetimeIDN($pro->project_deadline) ?></span>
                                    </td>
                                    <td class="text-nowrap">
                                        <?php 
                                            $progress_bg = '';
                                            if ($pro->project_progress <= 25) {
                                                $progress_bg = 'bg-danger';
                                            } else if ($pro->project_progress <= 50) {
                                                $progress_bg = 'bg-warning';
                                            } else if ($pro->project_progress <= 75) {
                                                $progress_bg = 'bg-info';
                                            } else {
                                                $progress_bg = 'bg-success';
                                            }
                                        ?>
                                        <div class="progress progress-lg">
                                            <div class="progress-bar <?= $progress_bg ?>" role="progressbar" <?= 'style="width:'.$pro->project_progress.'%;"' ?> aria-valuenow="<?= $pro->project_progress?>" aria-valuemin="0" aria-valuemax="100"><?= $pro->project_progress >= 100 ? '100%' : $pro->project_progress.'%'?></div>
                                        </div>
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <?php if($pro->project_status == 'pending') { ?>
                                        <button type="button" onclick="archiveProject(<?= "'".$pro->projectID."'" ?>)" class="btn btn-sm my-1 btn-info" data-toggle="tooltip" title="Arsipkan"><i class="la la-archive"></i></button>
                                        <?php } ?>
                                        <?php if ($pro->project_status != 'review') { ?>
                                        <button type="button" onclick="editProjectStatus(<?= "'".$pro->projectID."'" ?>)" class="btn btn-sm my-1 btn-danger" data-toggle="tooltip" title="Ubah status"><i class="fas fa-edit"></i></button>
                                        <?php } ?>
                                        <a href="<?= site_url('pm/proyek/detail/'.$pro->company_id.'/'.$pro->projectID) ?>" class="btn btn-sm my-1 btn-primary text-nowrap" data-toggle="tooltip" title="Lihat Proyek">Detail</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>
</div>
<?php } else { ?>
<div class="row">
    <div class="col-12 my-5 text-center">
        <img src="<?= base_url('assets/img/blank.png') ?>" width="120" class="mb-3">
        <h3 class="mb-1">Proyek belum tersedia.</h3>
        <p class="small text-muted">Klik tombol tambah berikut untuk membuat proyek baru.</p>
        <button type="button" class="btn btn-success py-2 px-4 my-2" onclick="addNewProject()">Tambah Proyek</button>
    </div>
</div>
<?php } ?>

<?php $this->view('pm/proyek/daftar/modal'); ?>
<?php $this->view('pm/proyek/daftar/script'); ?>