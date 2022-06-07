<!-- <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php 
                    $data['subproject'] = $subproject->result();
                    $data['total_rows'] = $subproject->num_rows();
                    var_dump($data);
                ?>
            </div>
        </div>
    </div>    
</div> -->

<!-- <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php 
                    var_dump($project);
                ?>
            </div>
        </div>
    </div>    
</div> -->

<div class="row">
    <div class="col-12 col-sm-6">
        <div class="d-flex flex-row align-items-start justify-content-between justify-content-sm-start">
            <div class="mr-3">
                <h4 class="mb-0"><?= $project->project_name ?></h4>
                <p class="text-secondary mb-2"><?= $project->project_address ?></p>
                <?php if ($project->user_id != NULL) { ?>
                    <span class="d-inline-block text-primary mb-1 small">Penanggung Jawab</span>
                    <div class="d-flex align-items-center mb-3">
                        <div class="profile-pic mr-2" style="width: 40px !important; height: 40px !important;">
                            <img src="<?= $project->user_profile == 'default-avatar.jpg' ? base_url('assets/img/default-avatar.jpg') : base_url('uploads/profile/'.$project->user_profile) ?>">
                        </div>
                        <p class="mb-0">
                            <?= $project->user_fullname ?> <br>
                            <span class="d-block text-muted small"><?= $project->user_role == 'pm' ? 'Projek Manajer' : NULL ?></span>
                        </p>
                    </div>
                <?php } else { ?>
                    <span class="d-inline-block text-danger mb-1 small"><i class="fas fa-user mr-2"></i>Penanggung Jawab Tidak Terdaftar</span>
                <?php } ?>
            </div>
            <button type="button" class="btn btn-sm btn-info" onclick="editProyek(<?= "'".$project->projectID."'" ?>)" data-toggle="tooltip" title="Edit proyek">
                <i class="fa fa-pencil"></i>
            </button>
        </div>
    </div>
    <div class="col-12 col-sm-6 text-sm-right">
        <a href="<?= site_url('direktur/chat') ?>" class="btn btn-primary py-2 px-3" data-toggle="tooltip" title="Kirim Pesan"><i class="fa-solid fa-message"></i></a>
        <button type="button" class="btn btn-success py-2 px-4 ml-1" onclick="add_subProject()">Buat Sub-proyek</button>
    </div>

    <div class="col-12">
        <div class="d-flex align-items-center mt-3">
            <div class="mr-4 ml-0">
                <?php 
                    $status_badge = '';
                    if ($project->project_status == NULL) {
                        $status_badge = '<span class="badge bg-inverse-light px-2 py-1"><span class="text-dark">Belum ada</span></span>';
                    } else if ($project->project_status == 'pending') {
                        $status_badge = '<span class="badge bg-inverse-danger px-2 py-1">Ditunda</span>';
                    } else if ($project->project_status == 'revision') {
                        $status_badge = '<span class="badge bg-inverse-warning px-2 py-1">Direvisi</span>';
                    } else if ($project->project_status == 'review') {
                        $status_badge = '<span class="badge bg-inverse-info px-2 py-1">Diperiksa</span>';
                    } else if ($project->project_status == 'on_progress') {
                        $status_badge = '<span class="badge bg-inverse-success px-2 py-1">Berjalan</span>';
                    }
                ?>
                <i class="fa-solid fa-map-pin mr-2"></i><?= $status_badge ?>
            </div>
            <div class="mr-3 small">
                <i class="fa-solid fa-clock mr-2"></i><span class="text-secondary">Dimulai: <strong class="text-dark"><?= datetimeIDN($project->project_start) ?></strong></span>
            </div>
            <div class="mr-2 small">
                <i class="fa-solid fa-clock mr-2"></i><span class="text-secondary">Selesai: <strong class="text-dark"><?= datetimeIDN($project->project_deadline) ?></strong></span>
            </div>
        </div>
    </div>
</div>

<div class="row my-4">
    <div class="col-12">
        <div class="pro-progress">
            <div class="pro-progress-bar">
                <h4>Progress</h4>
                <?php 
                    $progress_bg = '';
                    if ($project->project_progress <= 25) {
                        $progress_bg = 'bg-danger';
                    } else if ($project->project_progress <= 50) {
                        $progress_bg = 'bg-warning';
                    } else if ($project->project_progress <= 75) {
                        $progress_bg = 'bg-info';
                    } else {
                        $progress_bg = 'bg-success';
                    }
                ?>
                <div class="progress">
                    <div class="progress-bar <?= $progress_bg ?>" role="progressbar" <?= 'style="width:'.$project->project_progress.'%;"' ?>></div>
                </div>
                <span><?= $project->project_progress.'%' ?></span>
            </div>
        </div>
    </div>
</div>

<div class="kanban-board card mb-0">
    <div class="card-body">
        <?php if ($subproject->num_rows() > 0) { ?>
        <div class="kanban-cont">
            <!-- "Subproyek" Board -->
            <?php foreach ($subproject->result() as $sp) { ?>
            <div class="kanban-list <?= $sp->panel_color ?>">
                <!-- Kanban Header -->
                <div class="kanban-header">
                    <span class="status-title">
                        <span class="mr-2"><?= $sp->subproject_name ?></span>
                        <span class="badge"><?= $sp->priority_name ?></span>
                    </span>
                    <div class="kanban-header-right">
                        <div class="dropdown kanban-action">
                            <a href="" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:void(0)" onclick="edit_subProject()">Edit</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="hapus_subElProject('subproject')" >Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Kanban Header -->

                <?php $total_subelemen = subelemen_project($sp->subproject_id)->num_rows(); ?>
                <!-- "Subproyek" Content -->
                <div class="kanban-wrap">
                    <div class="pro-progress mb-3">
                        <div class="pro-progress-bar">
                            <h5>Progres</h5>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" <?= 'style="width: '.subproject_progress($sp->subproject_id, $total_subelemen).'%;"' ?>></div>
                            </div>
                            <span><?= subproject_progress($sp->subproject_id, $total_subelemen).'%' ?></span>
                        </div>
                    </div>

                    <?php if ($total_subelemen > 0) { ?>
                        <?php foreach(subelemen_project($sp->subproject_id)->result() as $se) { ?>
                            <!-- Task Sub-Element "Proyek" -->
                            <div class="card panel">
                                <div class="kanban-box ui-sortable-handle">
                                    <div class="task-board-header">
                                        <span class="status-title"><?= $se->project_task_name ?></span>
                                        <div class="dropdown kanban-task-action">
                                            <a href="" data-toggle="dropdown">
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="edit_subElemenProject()">Edit</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="hapus_subElProject('sub_elemen')">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="task-board-body">
                                        <div class="kanban-info">
                                            <div class="progress progress-xs">
                                                <div class="progress-bar" role="progressbar" <?= 'style="width: '.$se->project_task_progress.'%"' ?> aria-valuenow="<?= $se->project_task_progress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span><?= $se->project_task_progress >= 100 ? 100 : $se->project_task_progress ?>%</span>
                                        </div>
                                        <div class="kanban-footer mb-3">
                                            <span class="task-info-cont">
                                                <span class="task-date"><i class="fa-solid fa-clock"></i> <?= datetimeIDN($se->project_task_deadline) ?></span>
                                                <span class="task-priority badge <?= $se->priority_color ?>"><?= $se->priority_name ?></span>
                                            </span>
                                            <span class="task-users">
                                                <span class="task-date"><i class="fa-solid fa-map-pin"></i> Status</span>
                                                <?php 
                                                    if ($se->project_task_status == NULL) {
                                                        echo '<span class="task-priority badge bg-inverse-light"><span class="text-dark">Belum ada</span></span>';
                                                    } else if ($se->project_task_status == 'pending') {
                                                        echo '<span class="task-priority badge bg-inverse-danger">Ditunda</span>';
                                                    } else if ($se->project_task_status == 'onprogress') {
                                                        echo '<span class="task-priority badge bg-inverse-info">Berjalan</span>';
                                                    } else if ($se->project_task_status == 'finish') {
                                                        echo '<span class="task-priority badge bg-inverse-success">Selesai</span>';
                                                    }
                                                ?>
                                            </span>
                                        </div>
                                        <?php if ($se->updated != NULL) { ?>
                                            <div class="d-block text-center">
                                                <span class="text-xs text-muted small">Diperbarui: <strong><?= datetimeIDN($se->updated, TRUE) ?></strong></span>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- End Task Sub-Element "Proyek" -->
                        <?php } ?>
                    <?php } else { ?>
                    <div class="text-center">
                        <p class="mb-0 text-secondary small">List Belum tersedia</p>
                    </div>
                    <?php } ?>

                </div>
                <!-- End "Subproyek" Content -->

                <!-- Button Add new Kanban "Subproyek" Task -->
                <div class="add-new-task">
                    <button type="button" onclick="add_subElemenProject()" class="btn btn-light btn-sm btn-block"><i class="fas fa-plus mr-2 small"></i>Buat List</button>
                    <!-- <a href="javascript:void(0);" >Tambah Sub-elemen</a> -->
                </div>

                <!-- <div class="p-3">
                    <p><?= 'Sub-project ID : '. $sp->subproject_id ?></p>
                    <p><?= 'Total sub_elemen : '. $total_subelemen; ?></p>
                    <p><?= 'Progress : '. subproject_progress($sp->subproject_id, $total_subelemen) ?></p>
                </div> -->
            </div>
            <?php } ?>
            <!-- End "Subproyek" Board -->
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

<?php $this->view('direktur/proyek/detail_proyek/modal'); ?>
<?php $this->view('direktur/proyek/detail_proyek/script'); ?>