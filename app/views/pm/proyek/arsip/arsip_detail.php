<div class="row">
    <div class="col-12 col-sm-8">
        <div class="d-flex flex-row align-items-start justify-content-between justify-content-sm-start">
            <div class="mr-5">
                <h4 class="mb-0"><?= character_limiter($project['project_name'], 40, ' ...') ?></h4>
                <p class="text-secondary small mb-2"><?= character_limiter($project['project_address'], 35, ' ...') ?></p>
            </div>
        </div>

        <div class="row my-2">
            <div class="col-12 col-sm-6 col-md-5 col-lg-4">
                <span class="d-inline-block text-primary mb-1 small">Penanggung Jawab</span>
                <?php if($project['user_id'] != NULL) { ?>
                <div class="d-flex align-items-center mb-3">
                    <div class="profile-pic mr-2" style="width: 40px !important; height: 40px !important;">
                        <img src="<?= $project['user_profile'] == 'default-avatar.jpg' ? base_url('assets/img/default-avatar.jpg') : base_url('uploads/profile/'.$project['user_profile']) ?>">
                    </div>
                    <p class="mb-0"><?= $project['user_fullname'] ?> <?= $project['account_status'] == 'disable' ? '<span class="text-danger small">(Nonaktif)</span>' : NULL ?><br>
                        <span class="d-block text-muted small"><?= $project['user_role'] == 'pm' ? 'Proyek Manajer' : '-' ?></span>
                    </p>
                </div>
                <?php } else { ?>
                    <span class="d-inline-block text-danger mb-1 small"><i class="fas fa-user mr-2"></i>Penanggung Jawab Tidak Terdaftar</span>
                <?php } ?>
            </div>

            <!-- 
                ============================
                PREVIEW PROJECT DESIGN PHOTO 
                ============================
            -->
            <?php if($project_design->num_rows() > 0) { ?>
                <div class="col-6 col-sm-6 col-md-5 col-lg-4 mb-3">
                    <div class="img-photo-preview">
                        <img src="<?= base_url('uploads/'.$project_design->result()[0]->url) ?>">
                        <div class="img-photo-overlay text-center" onclick="showDesignProject(<?= $project['project_id'] ?>, <?= "'".$project['project_name']."'" ?>, <?= "'".'design'."'" ?>)">
                            <i class="fa-solid fa-image"></i>
                            <span class="d-block">Lihat Desain</span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="col-12 col-sm-4 text-sm-right">
        <button type="button" class="btn btn-dark mb-1 btn-sm" data-toggle="tooltip" title="Detail Proyek" onclick="viewDetailInfo(<?= $project['project_id'] ?>, <?= "'".$project['projectID']."'" ?>)"><i class="fas fa-plus"></i> <span class="d-inline-block d-md-none d-lg-inline-block ml-1">Detail Proyek</span></button>
    </div>

    <div class="col-12">
        <div class="d-flex align-items-center mt-3">
            <div class="mr-4 ml-0">
                <i class="fa-solid fa-map-pin mr-2"></i>
                <span class="badge bg-inverse-danger px-2 py-1"><i class="fas fa-check mr-1"></i><?= $project['project_status'] ?></span>
            </div>
            <div class="mr-3 small">
                <i class="fa-solid fa-clock mr-2"></i><span class="text-secondary">Dimulai: <strong class="text-dark"><?= datetimeIDN($project['project_start']) ?></strong></span>
            </div>
            <div class="mr-2 small">
                <i class="fa-solid fa-clock mr-2"></i><span class="text-secondary">Selesai: <strong class="text-dark"><?= datetimeIDN($project['project_deadline']) ?></strong></span>
            </div>
        </div>
    </div>
</div>

<!-- Progress Bar Main Proyek -->
<div class="row my-4">
    <div class="col-12">
        <div class="pro-progress">
            <div class="pro-progress-bar">
                <h4>Progress</h4>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" <?= 'style="width:'.$project['project_progress'].'%;"' ?>></div>
                </div>
                <span><?= $project['project_progress'].'%' ?></span>
            </div>
        </div>
    </div>
</div>
<!-- ./ Progress Bar Main Proyek -->

<div class="kanban-board card mb-0">
    <div class="card-body">
        <?php if ($project['subproject']) { ?>
        <div class="kanban-cont">
            <?php foreach($project['subproject'] as $sub) { ?>
            <!-- "Subproyek" Board -->
            <div class="kanban-list <?= $sub['panel_color'] ?>">
                <!-- Kanban Header -->
                <div class="kanban-header">
                    <span class="status-title">
                        <span class="mr-2"><?= $sub['subproject_name'] ?></span>
                        <span class="badge"><?= $sub['priority_name'] ?></span>
                    </span>

                    <div class="kanban-header-right">
                        <div class="dropdown kanban-action">
                            <a href="" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:void(0)" onclick="detail_subProject(<?= $project['project_id'] ?>,<?= $sub['subproject_id'] ?>)">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Kanban Header -->

                <!-- "Subproyek" Content -->
                <div class="kanban-wrap">
                    <div class="pro-progress mb-3">
                        <div class="pro-progress-bar">
                            <h5>Progres</h5>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" <?= 'style="width: '.$sub['subproject_progress'].'%;"' ?>></div>
                            </div>
                            <span><?= $sub['subproject_progress'].'%' ?></span>
                        </div>
                    </div>
                    
                    <?php $subelemen_task = tampilSubelemen($sub['subproject_id']); ?>
                    <!-- Task Sub-Element "Proyek" -->
                    <?php if ($subelemen_task['total_tasks'] > 0) { ?>
                        <!-- Photo Documentation Section -->
                        <button type="button" class="btn btn-light btn-block btn-sm mb-3" data-toggle="tooltip" title="Lihat Foto dokumentasi lapangan" onclick="showDocSubproject(<?= $project['project_id'] ?>, <?= $sub['subproject_id'] ?>, <?= "'".$sub['subproject_name']."'" ?>)"><i class="fa-solid fa-camera mr-1"></i> Dokumentasi</button>

                        <?php foreach($subelemen_task['subelemen'] as $se) { ?>
                            <div class="card panel">
                                <div class="kanban-box ui-sortable-handle">
                                    <div class="task-board-header">
                                        <span class="status-title"><?= $se['project_task_name'] ?></span>
                                    </div>
                                    <div class="task-board-body">
                                        <div class="kanban-info">
                                            <div class="progress progress-xs">
                                                <div class="progress-bar" role="progressbar" <?= 'style="width: '.$se['project_task_progress'].'%"' ?> aria-valuenow="<?= $se['project_task_progress'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span><?= $se['project_task_progress'].'%' ?></span>
                                        </div>
                                        <div class="kanban-footer mb-3">
                                            <span class="task-info-cont">
                                                <span class="task-date"><i class="fa-solid fa-clock"></i> <?= datetimeIDN($se['project_task_deadline']) ?></span>
                                                <span class="task-priority badge <?= $se['priority_color'] ?>"><?= $se['priority_name'] ?></span>
                                            </span>
                                            <span class="task-users">
                                                <span class="task-date"><i class="fa-solid fa-map-pin"></i> Status</span>
                                                <?php 
                                                    if ($se['project_task_status'] == 'none') {
                                                        echo '<span class="task-priority badge bg-inverse-light"><span class="text-dark">Belum ada</span></span>';
                                                    } else if ($se['project_task_status'] == 'pending') {
                                                        echo '<span class="task-priority badge bg-inverse-danger">Ditunda</span>';
                                                    } else if ($se['project_task_status'] == 'onprogress') {
                                                        echo '<span class="task-priority badge bg-inverse-info">Berjalan</span>';
                                                    } else if ($se['project_task_status'] == 'finish') {
                                                        echo '<span class="task-priority badge bg-inverse-success">Selesai</span>';
                                                    }
                                                ?>
                                            </span>
                                        </div>
                                        <?php if ($se['updated'] != NULL) { ?>
                                        <div class="d-block text-center">
                                            <span class="text-xs text-muted small">Update: <?= datetimeIDN($se['updated'], FALSE, TRUE) ?></span>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                    <div class="text-center">
                        <p class="mb-0 text-secondary small">List Belum tersedia</p>
                    </div>
                    <?php } ?>
                    <!-- End Task Sub-Element "Proyek" -->
                </div>
                <!-- End "Subproyek" Content -->
            </div>
            <!-- End "Subproyek" Board -->
            <?php } ?>
        </div>
        <?php } else { ?>
            <div class="text-center py-5">
                <img src="<?= base_url('assets/img/blank.png') ?>" width="120" class="mb-3">
                <h3 class="mb-1">Sub-Proyek tidak tersedia.</h3>
                <p class="small text-muted">Proyek telah diarsipkan.</p>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Script & Modal -->
<?php $this->view('pm/proyek/arsip/modal') ?>
<?php $this->view('pm/proyek/arsip/script') ?>
<!-- ./Script & Modal -->