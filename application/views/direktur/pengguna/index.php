<!-- Content Starts -->
<div class="row mb-4">
    <div class="col-12 col-sm-6">
        <h3><?= $title ?></h3>
        <div class="d-none d-md-block">
            <ul class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item text-primary text-sm"><a href="<?= site_url('direktur') ?>">Dashboard</a></li>
                <li class="breadcrumb-item text-sm active">User</li>
            </ul>
        </div>
    </div>
    <div class="col-12 col-sm-6 text-sm-right">
        <button type="button" class="btn btn-success py-2 px-4 my-2" data-toggle="modal" data-target="#addUsers-modal">Tambah</button>
    </div>
</div>

<div class="row">
    
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0" id="my-datatable">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th>Pengguna</th>
                                <th>Perusahaan</th>
                                <th>Jabatan</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex flex-row align-items-center">
                                        <img alt="" src="<?= base_url('assets/img/profiles/avatar-19.jpg') ?>" class="rounded-circle" width="40">
                                        <div class="ml-3">
                                            <h2>Rizqi Setiaji</h2>
                                            <small class="block text-ellipsis">
                                                <span class="text-muted">#ksjdksdsk</span>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>CV. Berkah Jaya Buana</td>
                                <td>Mandor</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i class="fa-regular fa-pen-to-square"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus"><i class="fa-regular fa-trash-can"></i></button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function() {
        $('#my-datatable').DataTable()
    });

</script>