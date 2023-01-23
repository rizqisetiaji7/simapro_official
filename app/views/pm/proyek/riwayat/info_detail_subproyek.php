<table class="table table-bordered mb-4">
	<tbody>
		<tr>
			<th style="width: 180px;">Nama Sub-Proyek</th>
			<td><?= $subproject->subproject_name ?></td>
		</tr>
		<tr>
			<th style="width: 180px;">Akhir pengerjaan</th>
			<td><?= datetimeIDN($subproject->subproject_deadline) ?></td>
		</tr>
		<tr>
			<th style="width: 180px;">Progress Pengerjaan</th>
			<td><?= $subproject->subproject_progress.'%' ?></td>
		</tr>
		<tr>
			<th style="width: 180px;">Level Prioritas</th>
			<td>
				<span class="badge <?= $subproject->priority_color ?>"><?= $subproject->priority_name ?></span>
			</td>
		</tr>
		<tr>
			<th style="width: 180px;">Dibuat pada: </th>
			<td>
				<span class="text-secondary small">
					<?= $subproject->created == NULL ? '' : datetimeIDN($subproject->created, TRUE, TRUE) ?>	
				</span>
			</td>
		</tr>
		<tr>
			<th style="width: 180px;">Terakhir Diperbarui: </th>
			<td>
				<span class="text-secondary small">
					<?= $subproject->updated == NULL ? '' : datetimeIDN($subproject->updated, TRUE, TRUE) ?>
				</span>
			</td>
		</tr>
	</tbody>
</table>