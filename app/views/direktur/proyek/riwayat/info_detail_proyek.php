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
			<td><strong>#<?= $project->projectID ?></strong></td>
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
			<td><?= $project->user_fullname ?> <?= $project->account_status == 'disable' ? '<span class="text-danger small">(Nonaktif)</span>' : NULL ?></td>
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