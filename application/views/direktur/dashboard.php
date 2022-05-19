<!-- Content Starts -->
<!-- <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-1">Selamat Datang, <span class="text-primary"><?= user_login()->fullname ?></span></h4>
                <span class="text-xs text-muted"><?= user_login()->display_name ?></span>
                <p class="mb-0 text-sm text-secondary"></p>   
            </div>
        </div>
    </div>
</div> -->

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
                    <h1 class="mb-3">50</h1>
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
                    <h1 class="mb-3">10</h1>
                    <p class="mb-0 text-muted text-sm">Proyek sedang di kerjakan</p>
                </div>
            </div>
        
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">Anak perusahaan</span>
                        </div>
                        <i class="la la-rocket text-xl text-success"></i>
                    </div>
                    <h1 class="mb-3">3</h1>
                    <!-- <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mb-0">Previous Month <span class="text-muted">$7,500</span></p> -->
                </div>
            </div>
        
            <!-- <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">Profit</span>
                        </div>
                        <div>
                            <span class="text-danger">-75%</span>
                        </div>
                    </div>
                    <h3 class="mb-3">$1,12,000</h3>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mb-0">Previous Month <span class="text-muted">$1,42,000</span></p>
                </div>
            </div> -->
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
                            <tr>
                                <td>
                                    <div class="d-flex flex-row align-items-center">
                                        <img alt="" src="assets/img/profiles/avatar-19.jpg" class="rounded-circle" width="40">
                                        <div class="ml-3">
                                            <h2><a href="#">Pembangunan Gedung Sekolah...</a></h2>
                                            <small class="block text-ellipsis">
                                                <span>1</span> <span class="text-muted">open tasks, </span>
                                                <span>9</span> <span class="text-muted">tasks completed</span>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>CV. Berkah Jaya Buana</td>
                                <td><span class="badge bg-inverse-primary">Berjalan</span></td>
                                <td>12 Agustus 2022</td>
                                <td>
                                    <div class="progress progress-xs progress-striped">
                                        <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="70%" data-original-title="70%" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="d-flex flex-row align-items-center">
                                        <img alt="" src="assets/img/profiles/avatar-19.jpg" class="rounded-circle" width="40">
                                        <div class="ml-3">
                                            <h2><a href="#">Pembangunan Gedung Sekolah...</a></h2>
                                            <small class="block text-ellipsis">
                                                <span>1</span> <span class="text-muted">open tasks, </span>
                                                <span>9</span> <span class="text-muted">tasks completed</span>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>CV. Berkah Jaya Buana</td>
                                <td><span class="badge bg-inverse-primary">Berjalan</span></td>
                                <td>12 Agustus 2022</td>
                                <td>
                                    <div class="progress progress-xs progress-striped">
                                        <div class="progress-bar bg-info" role="progressbar" data-toggle="tooltip" title="70%" data-original-title="70%" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="d-flex flex-row align-items-center">
                                        <img alt="" src="assets/img/profiles/avatar-19.jpg" class="rounded-circle" width="40">
                                        <div class="ml-3">
                                            <h2><a href="#">Pembangunan Gedung Sekolah...</a></h2>
                                            <small class="block text-ellipsis">
                                                <span>1</span> <span class="text-muted">open tasks, </span>
                                                <span>9</span> <span class="text-muted">tasks completed</span>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>CV. Berkah Jaya Buana</td>
                                <td><span class="badge bg-inverse-primary">Berjalan</span></td>
                                <td>12 Agustus 2022</td>
                                <td>
                                    <div class="progress progress-xs progress-striped">
                                        <div class="progress-bar bg-info" role="progressbar" data-toggle="tooltip" title="70%" data-original-title="70%" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="d-flex flex-row align-items-center">
                                        <img alt="" src="assets/img/profiles/avatar-19.jpg" class="rounded-circle" width="40">
                                        <div class="ml-3">
                                            <h2><a href="#">Pembangunan Gedung Sekolah...</a></h2>
                                            <small class="block text-ellipsis">
                                                <span>1</span> <span class="text-muted">open tasks, </span>
                                                <span>9</span> <span class="text-muted">tasks completed</span>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>CV. Berkah Jaya Buana</td>
                                <td><span class="badge bg-inverse-primary">Berjalan</span></td>
                                <td>12 Agustus 2022</td>
                                <td>
                                    <div class="progress progress-xs progress-striped">
                                        <div class="progress-bar bg-info" role="progressbar" data-toggle="tooltip" title="70%" data-original-title="70%" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="d-flex flex-row align-items-center">
                                        <img alt="" src="assets/img/profiles/avatar-19.jpg" class="rounded-circle" width="40">
                                        <div class="ml-3">
                                            <h2><a href="#">Pembangunan Gedung Sekolah...</a></h2>
                                            <small class="block text-ellipsis">
                                                <span>1</span> <span class="text-muted">open tasks, </span>
                                                <span>9</span> <span class="text-muted">tasks completed</span>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>CV. Berkah Jaya Buana</td>
                                <td><span class="badge bg-inverse-primary">Berjalan</span></td>
                                <td>12 Agustus 2022</td>
                                <td>
                                    <div class="progress progress-xs progress-striped">
                                        <div class="progress-bar bg-info" role="progressbar" data-toggle="tooltip" title="70%" data-original-title="70%" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="#">Lihat semua proyek</a>
            </div>
        </div>
    </div>
</div>
<!-- /Content End