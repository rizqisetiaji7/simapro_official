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

<!-- <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php var_dump($archived) ?>
            </div>
        </div>
    </div>
</div> -->

<?php if ($archived) { ?>
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
                            <?php foreach($archived as $arc) { ?>
                            <tr>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= $arc->project_thumbnail == 'placeholder.jpg' ? base_url('assets/img/placeholder.jpg') : base_url('uploads/thumbnail/'.$arc->project_thumbnail) ?>" class="rounded-lg" width="50" alt="">
                                        <div class="ml-3">
                                            <h4 class="mb-0"><?= $arc->project_name ?></h4>
                                            <p class="mb-0 text-xs text-muted"><?= $arc->project_address ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= $arc->user_profile == 'default-avatar.jpg' ? base_url('assets/img/default-avatar.jpg') : base_url('uploads/profile/'.$arc->user_profile) ?>" class="rounded-lg" width="40" alt="">
                                        <div class="ml-3">
                                            <h5 class="mb-0"><?= $arc->user_fullname ?></h5>
                                            <p class="mb-0 text-xs text-secondary"><?= $arc->comp_name ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <span class="badge bg-inverse-danger p-2"><?= $arc->project_status == 'pending' ? 'Ditunda' : NULL ?></span>
                                </td>
                                <td class="text-nowrap"><?= datetimeIDN($arc->project_deadline) ?></td>
                                <td class="text-nowrap">
                                    <!-- <p class="text-xs mb-1">Completed Projects <strong>(8/12)</strong></p> -->
                                    <div class="progress progress-lg">
                                        <div class="progress-bar bg-danger" role="progressbar" <?= 'style="width: '.$arc->project_progress.'%;"' ?> aria-valuenow="<?= $arc->project_progress ?>" aria-valuemin="0" aria-valuemax="100"><?= $arc->project_progress.'%' ?></div>
                                    </div>
                                </td>
                                <td class="text-nowrap text-center">
                                    <button type="button" onclick="removeArchive(<?= "'".$arc->projectID."'" ?>)" class="btn btn-sm my-1 btn-info" data-toggle="tooltip" title="Kembalikan proyek"><i class="fa-solid fa-arrow-up-from-bracket"></i></button>
                                    <a href="<?= site_url('direktur/proyek/detail_arsip/'.$arc->company_id.'/'.$arc->projectID) ?>" class="btn btn-sm my-1 btn-primary text-nowrap" data-toggle="tooltip" title="Lihat Proyek">Detail</a>
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
        <h3 class="mb-1">Arsip proyek tidak tersedia.</h3>
        <p class="small text-muted">Hanya proyek berstatus tertunda/pending yang akan ditampilkan sebagai arsip.</p>
    </div>
</div>
<?php } ?>

<?php $this->view('direktur/proyek/arsip/script') ?>