<div class="row">
    <div class="col-md-12">
        <div class="card-group m-b-30">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">Total Proyek</span>
                        </div>
                        <i class="la la-rocket text-xl text-success"></i>
                    </div>
                    <h1 class="mb-3"><?= $finished ?></h1>
                    <p class="mb-0 text-muted text-sm">Total project selesai</p>
                </div>
            </div>
        
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">Proyek Berjalan</span>
                        </div>
                        <i class="la la-rocket text-xl text-success"></i>
                    </div>
                    <h1 class="mb-3"><?= $on_progress ?></h1>
                    <p class="mb-0 text-muted text-sm">Proyek sedang di kerjakan</p>
                </div>
            </div>
        
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">Arsip</span>
                        </div>
                        <i class="la la-rocket text-xl text-success"></i>
                    </div>
                    <h1 class="mb-3"><?= $archived ?></h1>
                    <p class="mb-0 text-muted text-sm">Proyek yang diarsipkan</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 d-flex">
        <div class="card card-table flex-fill">
            <div class="card-header">
                <h3 class="card-title mb-0">Project Terbaru <span class="text-xs text-secondary">(Daftar proyek yang sedang di kerjakan)</span></h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th>Proyek</th>
                                <th>Penanggung Jawab</th>
                                <th>Status</th>
                                <th>Deadline</th>
                                <th>Progress</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($projects) { ?>
                                <?php foreach($projects as $p) { ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex flex-row align-items-center">
                                                <img src="<?= $p->project_thumbnail == 'placeholder.jpg' ? base_url('assets/img/placeholder.jpg') : base_url('uploads/thumbnail/'.$p->project_thumbnail) ?>" class="rounded-lg" width="50">
                                                <div class="ml-3">
                                                    <h2><?= $p->project_name ?></h2>
                                                    <small class="block text-ellipsis">
                                                        <span class="text-muted"><?= $p->project_address ?></span>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h5 class="mb-0"><?= $p->user_fullname ?></h5>
                                            <small class="block text-ellipsis">
                                                <span class="text-muted"><?= $p->comp_name ?></span>
                                            </small>
                                        </td>
                                        <td>
                                            <?php 
                                                if ($p->project_status == 'none') {
                                                    echo '<span class="badge bg-inverse-light p-2"><span class="text-dark">Belum ada</span></span>';
                                                } else if ($p->project_status == 'pending') {
                                                    echo '<span class="badge bg-inverse-danger p-2">Ditunda</span>';
                                                } else if ($p->project_status == 'revision') {
                                                    echo '<span class="badge bg-inverse-warning p-2">Direvisi</span>';
                                                } else if ($p->project_status == 'review') {
                                                    echo '<span class="badge bg-inverse-primary p-2">Diperiksa</span>';
                                                } else if ($p->project_status == 'on_progress') {
                                                    echo '<span class="badge bg-inverse-info p-2">Berjalan</span>';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <span class="small text-secondary"><?= datetimeIDN($p->project_deadline) ?></span>
                                        </td>
                                        <td>
                                            <?php 
                                                $progress_bg = '';
                                                if ($p->project_progress <= 25) {
                                                    $progress_bg = 'bg-danger';
                                                } else if ($p->project_progress <= 50) {
                                                    $progress_bg = 'bg-warning';
                                                } else if ($p->project_progress <= 75) {
                                                    $progress_bg = 'bg-info';
                                                } else {
                                                    $progress_bg = 'bg-success';
                                                }
                                            ?>
                                            <div class="progress progress-xs progress-striped">
                                                <div class="progress-bar <?= $progress_bg ?>" role="progressbar" data-toggle="tooltip" title="<?= $p->project_progress.'%' ?>" data-original-title="<?= $p->project_progress.'%' ?>" <?= 'style="width: '.$p->project_progress.'%;"' ?> aria-valuenow="<?= $p->project_progress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="<?= site_url('direktur/proyek/detail_proyek/'.$p->company_id.'/'.$p->projectID) ?>"><i class="fas fa-pencil m-r-5"></i>Detail</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    <p class="mb-0 text-secondary">Proyek Telah selesai.</p>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= site_url('direktur/proyek/daftar_proyek') ?>">Lihat semua proyek</a>
            </div>
        </div>
    </div>
</div>
<!-- /Content End