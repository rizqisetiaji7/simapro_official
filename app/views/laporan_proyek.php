<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Laporan Proyek | <?= $title ?></title>
	<style type="text/css" media="screen">
		* , *::before, *::after {
			box-sizing: border-box;
			margin: 0;
			padding: 0;
			font-family: 'Poppins', sans-serif;
		}

		body {
			font-size: 0.9rem;
		}

		.container {
			width: 90%;
			padding: 20px;
			margin: 0 auto;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			background-color: #fff;
			text-align: left;
			overflow: hidden;
		}

		table tr th {
			font-family: sans-serif;
			padding: 15px 10px;
			text-transform: uppercase;
			letter-spacing: 0.025rem;
			font-size: 0.7rem;
			font-weight: 800;
		}

		td {
			padding: 15px 10px;
			font-size: .75rem;
			vertical-align: middle;
		}

		td div.profile {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
		}

		td div.profile img {
			width: 45px;
			height: 40px;
			margin-right: 10px;
			border-radius: 10px;
			object-fit: cover;
			object-position: center;
		}

		tr:nth-child(even) {
			background-color: #f7f7f7;
		}

		.status {
			display: inline-block;
			text-align: center;
			border-radius: 6px;
			padding: 5px 10px;
			font-size: 0.64rem;
		}

		.status.success {
			background-color: #E8F5E9;
			color: #2E7D32;
		}

		.status.danger {
			background-color: #FFEBEE;
			color: #D32F2F;
		}

		.status.purple {
			background-color: #F3E5F5;
			color: #7B1FA2;
		}

		.header {
			display: flex;
			flex-wrap: wrap;
			margin-bottom: 30px;
		}

		.header-logo {
			text-align: center;
		}

		.header-desc h3 {
			margin-bottom: 10px;
		}
		.header-desc p {
			font-size: .8rem;
			margin-bottom: .5rem;
			font-weight: 600;
		}

	</style>
</head>
<body>
	<div class="container">
		<div class="header-logo">
			<img src="<?= base_url('uploads/company/'.$logo) ?>" height="80">
		</div>

		<div class="header-desc">
			<h3><?= $company ?></h3>
			<p>Periode : <?= $month == '' ? ' ~ ' : $month ?></p>
			<p>Jumlah Proyek : <?= $total_count ?></p>
		</div>

		<table>
			<tr>
				<th>No.</th>
				<th>ID Proyek</th>
				<th>Nama Proyek</th>
				<th>Proyek Manajer</th>
				<th>Alamat</th>
				<th>Deadline</th>
				<th>Proyek Selesai</th>
				<th>Keterangan</th>
			</tr>
			<?php $no=1; foreach($query as $qr) { ?>
			<tr>
				<td><?= $no++ ?></td>
				<td><?= $qr['proID'] ?></td>
				<td>
					<div class="profile">
						<img src="<?= $qr['thumbnail'] == 'placeholder.jpg' ? base_url('assets/img/placeholder.jpg') : base_url('uploads/thumbnail/'.$qr['thumbnail']) ?>"> <?= $qr['project_name'] ?>
					</div>
				 </td>
				<td><?= $qr['pm'] ?></td>
				<td><?= $qr['address'] ?></td>
				<td><?= $qr['deadline'] ?></td>
				<td><?= $qr['curr_deadline'] ?></td>
				<td>
					<?php 
						$cn = '';
						if ($qr['keterangan'] == 'Lebih Awal') {
							$cn = 'purple';
						} else if ($qr['keterangan'] == 'Tepat Waktu') {
							$cn = 'success';
						} else {
							$cn = 'danger';
						}
					?>
					<span class="status <?= $cn ?>"><?= $qr['keterangan'] ?></span>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>

</body>
</html>