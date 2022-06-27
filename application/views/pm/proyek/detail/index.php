<?php if ($project['project_status'] == 'finish') {
    redirect('pm/proyek');
} else { ?>
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

                <?php if ($project['project_status'] != 'review') { ?>
                <button type="button" class="btn btn-sm mb-1 btn-info" onclick="editProyek(<?= "'".$project['projectID']."'" ?>)" data-toggle="tooltip" title="Edit proyek"><i class="fa fa-pencil"></i></button>
                <?php } ?>

                <?php if ($project['project_status'] != 'review') { ?>
                <button type="button" class="btn btn-sm mb-1 btn-danger" onclick="editProjectStatus(<?= "'".$project['projectID']."'" ?>)" data-toggle="tooltip" title="Edit status proyek"><i class="fas fa-edit"></i></button>
                <?php } ?>

                <?php if ($project['project_status'] != 'review') { ?>
                <button type="button" class="btn btn-sm mb-1 btn-purple text-white" onclick="uploadDocumentation('proyek', <?= $project['project_id'] ?>, null)" data-toggle="tooltip" title="Upload Foto Dokumentasi Proyek"><i class="fa fa-cloud-upload"></i></button>
                <?php } ?>

                <button type="button" class="btn btn-sm mb-1 btn-custom" onclick="showPhoto(<?= $project['project_id'] ?>, 0, <?= "'".$project['project_name']."'" ?>, <?= "'".$project['project_status']."'" ?>, <?= "'".'proyek'."'" ?>)" data-toggle="tooltip" title="Lihat Foto Dokumentasi">
                    <i class="fas fa-camera"></i> <span class="d-none d-lg-inline-block ml-1">Lihat Foto</span>
                </button>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-4 text-sm-right">
        <a href="<?= site_url('chat') ?>" class="btn btn-primary mb-1 btn-sm" style="position: relative;" data-toggle="tooltip" title="Kirim Pesan"><i class="fa-solid fa-message"></i></a>


        <?php if ($project['project_status'] == 'review') { ?>
            <button type="button" class="btn btn-info mb-1 btn-sm" data-toggle="tooltip" title="Buat Sub-Proyek" disabled="disabled"><i class="fas fa-plus"></i> <span class="d-inline-block d-md-none d-lg-inline-block ml-1">Sub-proyek</span></button>
        <?php } else { ?>
            <button type="button" class="btn btn-info mb-1 btn-sm" data-toggle="tooltip" title="Buat Sub-Proyek" onclick="add_subProject(<?= $project['project_id'] ?>)"><i class="fas fa-plus"></i> <span class="d-inline-block d-md-none d-lg-inline-block ml-1">Sub-proyek</span></button>
        <?php } ?>

        <!-- Button ini akan muncul jika progress mencapai 100% dan dokumentasi telah lengkap -->
        <?php if ($project['project_progress'] >= 100 && $docs->num_rows() > 0) { ?>
            <?php if ($project['project_status'] == 'review') { ?>
                <button type="button" class="btn btn-secondary btn-sm mb-1" data-toggle="tooltip" title="Klik untuk ditinjau oleh Direktur" disabled="disabled"><i class="fas fa-eye"></i> <span class="d-inline-block d-md-none d-lg-inline-block ml-1">Sedang Diperiksa</span></button>
            <?php } else if ($project['project_status'] == 'none' || $project['project_status'] == 'pending') { ?> 
                <button type="button" class="btn btn-secondary btn-sm mb-1" data-toggle="tooltip" title="Klik untuk ditinjau oleh Direktur" disabled="disabled"><i class="fas fa-check"></i> <span class="d-inline-block d-md-none d-lg-inline-block ml-1">Tinjau ke Direktur</span></button>
            <?php } else if ($project['project_status'] == 'on_progress' || $project['project_status'] == 'revision') { ?>
                <button type="button" class="btn btn-dark btn-sm mb-1" data-toggle="tooltip" title="Klik untuk ditinjau oleh Direktur" onclick="sendReview(<?= $project['project_id'] ?>, <?= $project['ID_pm'] ?>, <?= $project['ID_company'] ?>)"><i class="fas fa-check"></i> <span class="d-inline-block d-md-none d-lg-inline-block ml-1">Tinjau ke Direktur</span></button>
            <?php } ?>
        <?php } else { ?>
            <button type="button" class="btn btn-secondary btn-sm mb-1" data-toggle="tooltip" title="Klik untuk ditinjau oleh Direktur" disabled="disabled"><i class="fas fa-check"></i> <span class="d-inline-block d-md-none d-lg-inline-block ml-1">Tinjau ke Direktur</span></button>
        <?php } ?>
    </div>

    <div class="col-12">
        <div class="d-flex align-items-center mt-3">
            <div class="mr-4 ml-0">
                <?php 
                    $status_badge = '';
                    if ($project['project_status'] == 'none') {
                        $status_badge = '<span class="badge bg-inverse-light px-2 py-1"><span class="text-dark">Belum ada</span></span>';
                    } else if ($project['project_status'] == 'pending') {
                        $status_badge = '<span class="badge bg-inverse-danger px-2 py-1">Ditunda</span>';
                    } else if ($project['project_status'] == 'revision') {
                        $status_badge = '<span class="badge bg-inverse-warning px-2 py-1">Direvisi</span>';
                    } else if ($project['project_status'] == 'review') {
                        $status_badge = '<span class="badge bg-inverse-purple px-2 py-1">Diperiksa</span>';
                    } else if ($project['project_status'] == 'on_progress') {
                        $status_badge = '<span class="badge bg-inverse-info px-2 py-1">Berjalan</span>';
                    } else if ($project['project_status'] == 'finish') {
                        $status_badge = '<span class="badge bg-inverse-success px-2 py-1">Selesai</span>';
                    }
                ?>
                <i class="fa-solid fa-map-pin mr-2"></i><?= $status_badge ?> 
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
                <?php 
                    $progress_bg = '';
                    if ($project['project_progress'] <= 25) {
                        $progress_bg = 'bg-danger';
                    } else if ($project['project_progress'] <= 50) {
                        $progress_bg = 'bg-warning';
                    } else if ($project['project_progress'] <= 75) {
                        $progress_bg = 'bg-info';
                    } else {
                        $progress_bg = 'bg-success';
                    }
                ?>
                <div class="progress">
                    <div class="progress-bar <?= $progress_bg ?>" role="progressbar" <?= 'style="width:'.$project['project_progress'].'%;"' ?>></div>
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

                    <?php if ($project['project_status'] == 'none' || $project['project_status'] == 'on_progress' || $project['project_status'] == 'revision') { ?>
                    <div class="kanban-header-right">
                        <div class="dropdown kanban-action">
                            <a href="" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:void(0)" onclick="edit_subProject(<?= $project['project_id'] ?>,<?= $sub['subproject_id'] ?>)">Edit</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="delete_subProject(<?= $sub['subproject_id'] ?>, <?= $project['project_id'] ?>)">Hapus</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
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

                        <!-- Upload Photo Documentation Section (Hanya Projek Manajer) -->
                        <div class="d-flex flex-row justify-content-between align-items-center mb-3 kanban-upload-area">
                            <div>
                                <p class="text-dark mb-0">Unggah Gambar</p>
                                <?php if (getCountDocumentation($project['project_id'], $sub['subproject_id']) > 0) { ?>
                                    <p class="text-xs mb-0 text-success">Jumlah Foto : <?= getCountDocumentation($project['project_id'], $sub['subproject_id']); ?></p>
                                <?php } else { ?>
                                    <p class="text-xs text-secondary mb-0">Belum ada foto</p>
                                <?php } ?>
                            </div>
                            <div>
                                <?php if ($project['project_status'] == 'pending' || $project['project_status'] == 'review') { ?>
                                    <button type="button" class="btn btn-sm btn-uploadGambarProyek" disabled="disabled" data-toggle="tooltip" title="Klik untuk Upload"><i class="fa fa-cloud-upload"></i></button>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-sm btn-uploadGambarProyek" onclick="uploadDocumentation('subproyek', <?= $project['project_id'] ?>, <?= $sub['subproject_id'] ?>)" data-toggle="tooltip" title="Klik untuk Upload"><i class="fa fa-cloud-upload"></i></button>
                                <?php } ?>
                                <button type="button" class="btn btn-sm btn-custom" onclick="showPhoto(<?= $project['project_id'] ?>, <?= $sub['subproject_id'] ?>, <?= "'".$sub['subproject_name']."'" ?>, <?= "'".$project['project_status']."'" ?>, <?= "'".'subproyek'."'" ?>)" data-toggle="tooltip" title="Lihat Foto"><i class="fas fa-camera"></i></button>
                            </div>
                        </div>

                        <?php foreach($subelemen_task['subelemen'] as $se) { ?>
                            <div class="card panel">
                                <div class="kanban-box ui-sortable-handle">
                                    <div class="task-board-header">
                                        <span class="status-title"><?= $se['project_task_name'] ?></span>

                                        <?php if ($project['project_status'] == 'none' || $project['project_status'] == 'on_progress' || $project['project_status'] == 'revision') { ?>
                                        <div class="dropdown kanban-task-action">
                                            <a href="" data-toggle="dropdown">
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="edit_subElemenProject(<?= $se['project_task_id'] ?>, <?= $sub['subproject_id'] ?>, <?= $project['project_id'] ?>)">Edit</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="deleteSubelemen(<?= $se['project_task_id'] ?>, <?= $sub['subproject_id'] ?>, <?= $project['project_id'] ?>)">Hapus</a>
                                            </div>
                                        </div>
                                        <?php } ?>
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

                <?php if ($project['project_status'] == 'none' || $project['project_status'] == 'on_progress' || $project['project_status'] == 'revision') { ?>
                    <!-- Button Add new Kanban "Subproyek" Task -->
                    <div class="add-new-task">
                        <button type="button" class="btn btn-light btn-sm btn-block" onclick="add_subElemenProject(<?= $project['project_id'] ?>, <?= $sub['subproject_id'] ?>)" ><i class="fas fa-plus mr-2 small"></i>Buat List</button>
                    </div>
                <?php } ?>
            </div>
            <!-- End "Subproyek" Board -->
            <?php } ?>
        </div>
        <?php } else { ?>
            <div class="text-center py-5">
                <img src="<?= base_url('assets/img/blank.png') ?>" width="120" class="mb-3">
                <h3 class="mb-1">Sub-Proyek belum tersedia.</h3>
                <p class="small text-muted">Silahkan klik tombol <strong class="text-success">Buat Sub-Proyek</strong>, untuk membuat sub baru.</p>
            </div>
        <?php } ?>
    </div>
</div>

<?php $this->view('pm/proyek/detail/modal_script/modal'); ?>
<?php $this->view('pm/proyek/detail/modal_script/script'); ?>
<?php $this->view('pm/proyek/detail/modal_script/modal_upload'); ?>
<?php $this->view('pm/proyek/detail/modal_script/script_upload_doc'); ?>
<?php } ?>