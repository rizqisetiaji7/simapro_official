<input type="hidden" name="project_code_ID" value="<?= $project_status->project_code_ID ?>">
<input type="hidden" name="current_progress" value="<?= $project_status->project_progress ?>">
<div class="form-row mb-3">
	<div class="col-12">
		<label for="project_status">Status proyek</label>
		<select name="project_status" class="form-control" id="project_status" required>
			<option <?= $project_status->project_status == 'on_progress' ? 'selected' : NULL ?> value="on_progress">Berjalan</option>
			<option <?= $project_status->project_status == 'pending' ? 'selected' : NULL ?> value="pending">Ditunda</option>
		</select>
	</div>
</div>