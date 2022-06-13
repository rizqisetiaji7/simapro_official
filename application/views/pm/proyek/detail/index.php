<div class="row">
    <div class="col-12 col-sm-8">
        <div class="d-flex flex-row align-items-start justify-content-between justify-content-sm-start">
            <div class="mr-5">
                <h4 class="mb-0">Proyek Rumah sakit Kawali</h4>
                <p class="text-secondary small mb-2">Jl. Blabla, No.69, Kab. Ciamis</p>

                <span class="d-inline-block text-primary mb-1 small">Penanggung Jawab</span>
                <div class="d-flex align-items-center mb-3">
                    <div class="profile-pic mr-2" style="width: 40px !important; height: 40px !important;">
                        <img src="<?= base_url('assets/img/default-avatar.jpg') ?>">
                    </div>
                    <p class="mb-0">Rizqi PM <br>
                        <span class="d-block text-muted small">Proyek Manajer</span>
                    </p>
                </div>
            </div>

            <div>
                <button type="button" class="btn btn-sm mb-1 btn-info" onclick="editProyek()" data-toggle="tooltip" title="Edit proyek"><i class="fa fa-pencil"></i></button>

                <button type="button" class="btn btn-sm mb-1 btn-danger" onclick="editProjectStatus()" data-toggle="tooltip" title="Edit status proyek"><i class="fas fa-edit"></i></button>

                <button type="button" class="btn btn-sm mb-1 btn-purple text-white" onclick="uploadDocumentation()" data-toggle="tooltip" title="Upload Foto Dokumentasi Proyek"><i class="fa fa-cloud-upload"></i></button>

                <button type="button" class="btn btn-sm mb-1 btn-custom" onclick="showDocProject()" data-toggle="tooltip" title="Lihat Foto Dokumentasi">
                    <i class="fas fa-camera"></i> <span class="d-none d-lg-inline-block ml-1">Lihat Foto</span>
                </button>
            </div>
            
        </div>
    </div>

    <div class="col-12 col-sm-4 text-sm-right">
        <a href="<?= site_url('pm/chat') ?>" class="btn btn-primary mb-1 btn-sm" style="position: relative;" data-toggle="tooltip" title="Kirim Pesan"><i class="fa-solid fa-message"></i></a>

        <button type="button" class="btn btn-info mb-1 btn-sm" data-toggle="tooltip" title="Buat Sub-Proyek" onclick="add_subProject()"><i class="fas fa-plus"></i> <span class="d-inline-block d-md-none d-lg-inline-block ml-1">Sub-proyek</span></button>

        <!-- Button ini akan muncul jika progress mencapai 100% dan dokumentasi telah lengkap -->
        <button type="button" class="btn btn-success btn-sm mb-1" data-toggle="tooltip" title="Klik proyek dinyatakan selesai" onclick="finishProject('')"><i class="fas fa-check"></i> <span class="d-inline-block d-md-none d-lg-inline-block ml-1">Proyek Selesai</span></button>
    </div>

    <div class="col-12">
        <div class="d-flex align-items-center mt-3">
            <div class="mr-4 ml-0">
                <i class="fa-solid fa-map-pin mr-2"></i> <span class="badge bg-inverse-info px-2 py-1">Berjalan</span>  
            </div>
            <div class="mr-3 small">
                <i class="fa-solid fa-clock mr-2"></i><span class="text-secondary">Dimulai: <strong class="text-dark">12 Oktober 2023</strong></span>
            </div>
            <div class="mr-2 small">
                <i class="fa-solid fa-clock mr-2"></i><span class="text-secondary">Selesai: <strong class="text-dark">28 Oktober 2024</strong></span>
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
                    <div class="progress-bar bg-success" role="progressbar" style="width: 50%"></div>
                </div>
                <span>50%</span>
            </div>
        </div>
    </div>
</div>
<!-- ./ Progress Bar Main Proyek -->


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
                                <a class="dropdown-item" href="javascript:void(0)" onclick="edit_subProject()">Edit</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="delete_subElProject('subproject')">Hapus</a>
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
                        <div>
                            <button type="button" class="btn btn-sm btn-uploadGambarProyek" onclick="uploadDocumentation()" data-toggle="tooltip" title="Klik untuk Upload"><i class="fa fa-cloud-upload"></i></button>
                            <button type="button" class="btn btn-sm btn-custom" onclick="showDocSubproject()" data-toggle="tooltip" title="Lihat Foto"><i class="fas fa-camera"></i></button>
                        </div>
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
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="edit_subElemenProject()">Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="delete_subElProject('sub_elemen')">Hapus</a>
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
                    <button type="button" class="btn btn-light btn-sm btn-block" onclick="add_subElemenProject()" ><i class="fas fa-plus mr-2 small"></i>Buat List</button>
                </div>
            </div>
            <!-- End "Subproyek" Board -->

            <!-- "Subproyek" Board -->
            <div class="kanban-list kanban-danger">
                <!-- Kanban Header -->
                <div class="kanban-header">
                    <span class="status-title">
                        <span class="mr-2">Ruang IGD</span>
                        <span class="badge">Low</span>
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
                                <div class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                            </div>
                            <span>0%</span>
                        </div>
                    </div>

                    <!-- End Task Sub-Element "Proyek" -->
                    <div class="text-center">
                        <p class="mb-0 text-secondary small">List Belum tersedia</p>
                    </div>
                </div>
                <!-- End "Subproyek" Content -->

                <!-- Button Add new Kanban "Subproyek" Task -->
                <div class="add-new-task">
                    <button type="button" class="btn btn-light btn-sm btn-block" onclick="add_subElemenProject()" ><i class="fas fa-plus mr-2 small"></i>Buat List</button>
                </div>
            </div>
            <!-- End "Subproyek" Board -->
        </div>
    </div>
</div>


<?php $this->view('pm/proyek/detail/modal_script/modal'); ?>
<?php $this->view('pm/proyek/detail/modal_script/script'); ?>
<?php $this->view('pm/proyek/detail/modal_script/modal_upload'); ?>
<?php $this->view('pm/proyek/detail/modal_script/script_upload_doc'); ?>