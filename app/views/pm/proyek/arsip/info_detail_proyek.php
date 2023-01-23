<h4>Data Proyek</h4>
<table class="table table-sm table-bordered mb-4">
	<tbody>
		<tr>
			<th style="width: 180px;">Gambar</th>
			<td>
				<img src="<?= $project->project_thumbnail == 'placeholder.jpg' ? base_url('assets/img/placeholder.jpg') : base_url('uploads/thumbnail/'.$project->project_thumbnail) ?>" class="w-100" style="max-width: 400px;">
			</td>
		</tr>
		<tr>
			<th style="width: 180px;">Nomor Kode Proyek</th>
			<td><strong>#<?= $project->project_code_ID ?></strong></td>
		</tr>
		<tr>
			<th style="width: 180px;">Nama Proyek</th>
			<td><?= $project->project_name ?></td>
		</tr>
		<tr>
			<th style="width: 180px;">Mulai pengerjaan</th>
			<td><?= datetimeIDN($project->project_start) ?></td>
		</tr>
		<tr>
			<th style="width: 180px;">Akhir pengerjaan</th>
			<td><?= datetimeIDN($project->project_deadline) ?></td>
		</tr>
		<tr>
			<th style="width: 180px;">Alamat / Lokasi Proyek</th>
			<td><?= $project->project_address ?></td>
		</tr>
		<tr>
			<th style="width: 180px;">Deskripsi Proyek</th>
			<td><?= $project->project_description ?></td>
		</tr>
	</tbody>
</table>

<div class="divider mt-3 mb-3"></div>

<h4>Data Proyek Manajer</h4>
<?php if ($project->user_id != NULL) { ?>
<table class="table table-sm table-bordered mb-4">
	<tbody>
		<tr>
			<th style="width: 180px;">Profile</th>
			<td>
				<div class="profile-pic">
					<img src="<?= $project->user_profile == 'default-avatar.jpg' ? base_url('assets/img/default-avatar.jpg') : base_url('uploads/profile/'.$project->user_profile) ?>">
				</div>
			</td>
		</tr>
		<tr>
			<th style="width: 180px;">User ID</th>
			<td><strong>#<?= $project->user_unique_id ?></strong></td>
		</tr>
		<tr>
			<th style="width: 180px;">Nama Lengkap</th>
			<td><?= $project->user_fullname ?></td>
		</tr>
		<tr>
			<th style="width: 180px;">Alamat Email</th>
			<td><?= $project->user_email ?></td>
		</tr>
	</tbody>
</table>
<?php } else { ?>
<p class="text-secondary small">Data Proyek manajer tidak terdaftar.</p>
<?php } ?>

<div class="divider mt-3 mb-3"></div>

<h4>Dokumentasi Foto</h4>
<?php if ($docs->num_rows() > 0) { ?>
	<div class="row">
		<?php foreach($docs->result() as $doc) { ?>
			<div class="col-6 col-sm-4 col-md-3 col-lg-2">
				<img src="<?= base_url('uploads/'.$doc->url) ?>" class="img-fluid rounded" alt="">
			</div>
		<?php } ?>
	</div>
<?php } else { ?>
	<p class="text-secondary small">Data dokumentasi media tidak tersedia.</p>
<?php } ?>