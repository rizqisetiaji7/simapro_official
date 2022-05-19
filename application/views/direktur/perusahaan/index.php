<!-- Content Starts -->
<div class="row mb-4">
    <div class="col-12 col-sm-6">
        <h3><?= $title ?></h3>
        <div class="d-none d-md-block">
            <ul class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item text-primary text-sm"><a href="<?= site_url('direktur') ?>">Dashboard</a></li>
                <li class="breadcrumb-item text-sm active">Perusahaan</li>
            </ul>
        </div>
    </div>
    <div class="col-12 col-sm-6 text-sm-right">
        <button class="btn btn-success py-2 px-4 my-2" onclick="addCompanyModal(<?= $main_comp->company_id ?>)">Tambah</button>
    </div>
</div>

<div class="row staff-grid-row mb-4">
    <div class="col-lg-4 col-md-5 col-sm-6 col-12 m-auto">
        <div class="profile-widget py-4 text-center">
            <h4 class="user-name m-t-10 mb-0 text-ellipsis"><?= $main_comp->comp_name ?></h4>
            <img alt="" src="<?= $main_comp->comp_logo == 'default-placeholder320x320.png' ? base_url('assets/img/'.$main_comp->comp_logo) : base_url('uploads/company/'.$main_comp->comp_logo) ?>" class="w-100 my-3" style="max-width: 200px;">
            <div>
                <a href="<?= site_url('direktur/perusahaan/detail/'.$main_comp->company_id.'/'.$main_comp->comp_parent_id.'/'.urlencode(base64_encode('maincompany'))) ?>" class="btn btn-white btn-sm m-t-10">Detail</a>
                <button type="button" onclick="editCompanyModal(<?= $main_comp->company_id ?>, <?= $main_comp->comp_parent_id ?>)" class="btn btn-info btn-sm m-t-10">Edit</button>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12 text-center">
        <h3>Daftar anak perusahaan</h3>
    </div>
</div>

<div class="row staff-grid-row">
    <?php foreach($subcompany as $sc) { ?>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="profile-widget py-4">
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><?= $sc->comp_name ?></h4>
                <img alt="" src="<?= $sc->comp_logo == 'default-placeholder320x320.png' ? base_url('assets/img/'.$sc->comp_logo) : base_url('uploads/company/'.$sc->comp_logo) ?>" class="w-100 my-3" style="max-width: 250px;">
                <a href="<?= site_url('direktur/perusahaan/detail/'.$sc->company_id.'/'.$sc->comp_parent_id.'/'.urlencode(base64_encode('subcompany'))) ?>" class="btn btn-white btn-sm m-t-10">Detail</a>
                <button type="button" class="btn btn-info btn-sm m-t-10" onclick="editCompanyModal(<?= $sc->company_id ?>, <?= $sc->comp_parent_id ?>)">Edit</button>
            </div>
        </div>
    <?php } ?>
</div>

<?php $this->view('direktur/perusahaan/modal'); ?>
<?php $this->view('direktur/perusahaan/script'); ?>