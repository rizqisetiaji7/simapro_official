<table class="table table-striped table-bordered">
	<tbody>
		<tr>
			<th>ID</th>
			<td><?= $mandor->user_unique_id ?></td>
		</tr>
		<tr>
			<th>Profile</th>
			<td>
				<div class="profile-pic">
					<img src="<?= $mandor->user_profile == 'default-avatar.jpg' ? base_url('assets/img/'.$mandor->user_profile) : base_url('uploads/profile/'.$mandor->user_profile) ?>" alt="">
				</div>
			</td>
		</tr>
		<tr>
			<th>Nama</th>
			<td><?= $mandor->user_fullname ?></td>
		</tr>
		<tr>
			<th>Jabatan</th>
			<td><?= $mandor->user_role == 'employee' ? 'Mandor' : NULL ?></td>
		</tr>
		<tr>
			<th>Email</th>
			<td><?= $mandor->user_email ?></td>
		</tr>
		<tr>
			<th>Nomor Telepon</th>
			<td><?= $mandor->user_phone == NULL ? '-' : $mandor->user_phone ?></td>
		</tr>
		<tr>
			<th>Alamat</th>
			<td><?= $mandor->user_address == NULL ? '-' : $mandor->user_address ?></td>
		</tr>
	</tbody>
</table>

<span class="text-muted text-sm">Terakhir diperbarui: <strong class="text-dark"><?= $mandor->updated == NULL ? '-' : dateTimeIDN($mandor->updated, TRUE, TRUE) ?></strong></span>