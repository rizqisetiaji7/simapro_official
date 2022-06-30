<div class="row">
    <div class="col-12 col-sm-8">
        <div class="d-flex flex-row align-items-start justify-content-between justify-content-sm-start">
            <div class="mr-5">
                <h4 class="mb-0"><?= $project['project_name'] ?></h4>
                <p class="text-secondary small mb-2"><?= $project['project_address'] ?></p>

                <span class="d-inline-block text-primary mb-1 small">Penanggung Jawab</span>
                <div class="d-flex align-items-center mb-3">
                    <div class="profile-pic mr-2" style="width: 40px !important; height: 40px !important;">
                        <img src="<?= $project['user_profile'] == 'default-avatar.jpg' ? base_url('assets/img/default-avatar.jpg') : base_url('uploads/profile/'.$project['user_profile']) ?>">
                    </div>
                    <p class="mb-0"><?= $project['user_fullname'] ?><br>
                        <span class="d-block text-muted small"><?= $project['user_role'] == 'pm' ? 'Proyek Manajer' : '-' ?></span>
                    </p>
                </div>
            </div>

            <div>
                <button type="button" class="btn btn-sm mb-1 btn-success" onclick="revisiProyek(<?= "'".$project['project_id']."'" ?>)" data-toggle="tooltip" title="Revisi ulang proyek ni">
                	<i class="fa fa-pencil"></i> <span class="d-none d-lg-inline-block ml-1">Revisi</span>
                </button>
                
                <button type="button" class="btn btn-sm mb-1 btn-custom" onclick="showPhotos(<?= $project['project_id'] ?>, '',<?= "'".$project['project_name']."'" ?>)" data-toggle="tooltip" title="Lihat Foto Dokumentasi">
                    <i class="fas fa-camera"></i> <span class="d-none d-lg-inline-block ml-1">Lihat Foto</span>
                </button>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-4 text-sm-right">
        <?php $pm_id = $project['user_id'] != NULL ? $project['user_id'] : 0 ?>
        <button type="button" onclick="set_data_chat(<?= user_login()->user_id ?>, <?= $pm_id ?>, <?= $project['project_id'] ?>)" class="btn btn-primary mb-1 btn-sm" style="position: relative;" data-toggle="tooltip" title="Kirim Pesan">
            <div style="top: 3px; left: 4px; border-radius: 50%; height: 8px; width: 8px; background: #55ce63; position: absolute;"></div>
            <i class="fa-solid fa-message"></i>
        </button>
        <button type="button" class="btn btn-dark mb-1 btn-sm" data-toggle="tooltip" title="Detail Proyek" onclick="detailProject(<?= $project['project_id'] ?>, <?= "'".$project['projectID']."'" ?>)"><i class="fas fa-plus"></i> <span class="d-inline-block d-md-none d-lg-inline-block ml-1">Detail Proyek</span></button>
    </div>

    <div class="col-12">
        <div class="d-flex align-items-center mt-3">
            <div class="mr-4 ml-0">
                <i class="fa-solid fa-map-pin mr-2"></i>
                <span class="badge bg-inverse-success px-2 py-1"><i class="fas fa-check mr-1"></i><?= $project['project_status'] == 'finish' ? 'Selesai' : '-' ?></span>
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
                        <div class="d-flex flex-row justify-content-between align-items-center mb-3 kanban-upload-area">
                            <div>
                                <p class="text-dark mb-0">Dokumentasi</p>
                                <?php if (getCountDocumentation($project['project_id'], $sub['subproject_id']) > 0) { ?>
                                    <p class="text-xs mb-0 text-success">Jumlah Foto : <?= getCountDocumentation($project['project_id'], $sub['subproject_id']); ?></p>
                                <?php } else { ?>
                                    <p class="text-xs text-secondary mb-0">Belum ada foto</p>
                                <?php } ?>
                            </div>
                            <div>
                            	<button type="button" class="btn btn-sm btn-custom" onclick="showPhotos(<?= $project['project_id'] ?>, <?= $sub['subproject_id'] ?>, <?= "'".$sub['subproject_name']."'" ?>)" data-toggle="tooltip" title="Lihat Foto"><i class="fas fa-camera mr-1"></i> Foto</button>
                            </div>
                        </div>

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
            </div>
        <?php } ?>
    </div>
</div>

<?php $this->view('direktur/proyek/riwayat/modal'); ?>
<?php $this->view('direktur/proyek/riwayat/script'); ?>