<div class="row">
    <div class="col-12 col-sm-6">
        <div class="d-flex flex-row align-items-start justify-content-between justify-content-sm-start">
            <div class="mr-3">
                <h4 class="mb-0">Proyek Rumah sakit Kawali</h4>
                <p class="text-secondary text-sm">Jl. Blabla, No.69, Kab. Ciamis</p>
            </div>
            <button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit proyek">
                <i class="fa fa-pencil"></i>
            </button>
        </div>
    </div>
    <div class="col-12 col-sm-6 text-sm-right">
        <a href="<?= site_url('pm/chat') ?>" class="btn btn-primary py-2 px-3" data-toggle="tooltip" title="Kirim Pesan"><i class="fa-solid fa-message"></i></a>
        <button type="button" class="btn btn-success py-2 px-4 ml-1" data-toggle="modal" data-target="#addSubProject">Buat Sub-proyek</button>
    </div>

    <div class="col-12">
        <div class="d-flex mt-3">
            <div class="mr-4 ml-0">
                <i class="fa-solid fa-map-pin mr-2"></i><span class="badge bg-inverse-warning px-2 py-1">On Progress</span>  
            </div>
            <div class="mr-2">
                <i class="fa-solid fa-clock mr-2"></i><span class="text-secondary">Deadline: <strong class="text-dark">12 Oktober 2023</strong></span>
            </div>
        </div>
    </div>
</div>

<div class="row my-4">
    <div class="col-12">
        <div class="pro-progress">
            <div class="pro-progress-bar">
                <h4>Progress</h4>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 50%"></div>
                </div>
                <span>50%</span>
            </div>
        </div>
    </div>
</div>

<div class="kanban-board card mb-0">
    <div class="card-body">
        <div class="kanban-cont">

            <!-- "Subproyek" Board -->
            <div class="kanban-list kanban-purple">
                <!-- Kanban Header -->
                <div class="kanban-header">
                    <span class="status-title">
                        <span class="mr-2">Pembangunan Area Parkir</span>
                        <span class="badge">High</span>
                    </span>
                    <div class="kanban-header-right">
                        <div class="dropdown kanban-action">
                            <a href="" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" href="#">Delete</a>
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
                                <div class="progress-bar bg-success" role="progressbar" style="width: 50%"></div>
                            </div>
                            <span>50%</span>
                        </div>
                    </div>

                    <!-- Upload Photo Documentation Section (Hanya Projek Manajer) -->
                    <div class="d-flex flex-row justify-content-between align-items-center mb-3 kanban-upload-area">
                        <div>
                            <p class="text-dark mb-0">Unggah Gambar</p>
                            <p class="text-xs text-secondary mb-0">Foto dokumentasi proyek</p>
                        </div>
                        <button type="button" class="btn btn-sm btn-uploadGambarProyek"  data-title="Lapang parkir" data-toggle="tooltip" title="Klik untuk Upload">
                            <i class="fa fa-cloud-upload"></i>
                        </button>
                    </div>
                    
                    <!-- Task Sub-Element "Proyek" -->
                    <div class="card panel">
                        <div class="kanban-box ui-sortable-handle">
                            <div class="task-board-header">
                                <span class="status-title">Pengaspalan parkir</span>
                                <div class="dropdown kanban-task-action">
                                    <a href="" data-toggle="dropdown">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_modal">Edit</a>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <div class="task-board-body">
                                <div class="kanban-info">
                                    <div class="progress progress-xs">
                                        <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span>70%</span>
                                </div>
                                <div class="kanban-footer mb-3">
                                    <span class="task-info-cont">
                                        <span class="task-date"><i class="fa-solid fa-clock"></i> 26 September 2022</span>
                                        <span class="task-priority badge bg-inverse-danger">High</span>
                                    </span>
                                    <span class="task-users">
                                        <span class="task-date"><i class="fa-solid fa-map-pin"></i> Status</span>
                                        <span class="task-priority badge bg-info">On Progress</span>
                                    </span>
                                </div>
                                <div class="d-block text-center">
                                    <span class="text-xs text-muted">Diperbarui: <strong>12 September 2022</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Task Sub-Element "Proyek" -->

                </div>
                <!-- End "Subproyek" Content -->

                <!-- Button Add new Kanban "Subproyek" Task -->
                <div class="add-new-task">
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#add_task_modal">Add New Task</a>
                </div>
            </div>
            <!-- End "Subproyek" Board -->

        </div>
    </div>
</div>

<?php $this->view('pm/proyek/detail/modal_upload_subproyek'); ?>
<?php $this->view('pm/proyek/detail/script'); ?>