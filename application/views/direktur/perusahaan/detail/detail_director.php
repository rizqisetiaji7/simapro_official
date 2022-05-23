<table class="table table-striped table-bordered">
	<tbody>
		<tr>
			<th>ID</th>
			<td><?= $director->user_unique_id ?></td>
		</tr>
		<tr>
			<th>Profile</th>
			<td>
				<div class="profile-pic">
					<img src="<?= $director->user_profile == 'default-avatar.jpg' ? base_url('assets/img/'.$director->user_profile) : base_url('uploads/profile/'.$director->user_profile) ?>" alt="">
				</div>
			</td>
		</tr>
		<tr>
			<th>Nama</th>
			<td><?= $director->user_fullname ?></td>
		</tr>
		<tr>
			<th>Jabatan</th>
			<td><?= $director->user_role == 'admin' ? 'Direktur' : NULL ?></td>
		</tr>
		<tr>
			<th>Email</th>
			<td><?= $director->user_email ?></td>
		</tr>
		<tr>
			<th>Nomor Telepon</th>
			<td><?= $director->user_phone ?></td>
		</tr>
		<tr>
			<th>Alamat</th>
			<td><?= $director->user_address ?></td>
		</tr>
	</tbody>
</table>

<span class="text-muted text-sm">Terakhir diperbarui: <strong><?= $director->updated == NULL ? '-' : $director->updated ?></strong></span>