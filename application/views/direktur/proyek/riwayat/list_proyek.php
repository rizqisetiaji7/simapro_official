<?php if ($projects->num_rows() > 0) { ?>
	<?php foreach($projects->result() as $project) { ?>
		<tr>
		  <td class="text-nowrap">
		      <div class="d-flex align-items-center">
		          <img src="<?= $project->project_thumbnail == 'placeholder.jpg' ? base_url('assets/img/placeholder.jpg') : base_url('uploads/thumbnail/'.$project->project_thumbnail) ?>" class="rounded-lg" width="50" alt="">
		          <div class="ml-3">
		              <h5 class="mb-0"><?= word_limiter($project->project_name, 4, '...') ?></h5>
		              <p class="mb-0 text-xs text-muted"><?= $project->project_address ?></p>
		          </div>
		      </div>
		  </td>
		  <td class="text-nowrap">
		      <div class="d-flex align-items-center">
		          <?php if ($project->user_id != NULL) { ?>
		              <img src="<?= $project->user_profile == 'default-avatar.jpg' ? base_url('assets/img/default-avatar.jpg') : base_url('uploads/profile/'.$project->user_profile) ?>" class="rounded-lg" width="40" alt="">
		              <div class="ml-3">
		                  <h5 class="mb-0"><?= $project->user_fullname ?></h5>
		                  <p class="mb-0 text-xs text-secondary"><?= $project->comp_name ?></p>
		              </div>
		          <?php } else { ?>
		              <p class="mb-0 text-danger small text-center">Tidak Terdaftar</p>
		          <?php } ?>
		      </div>
		  </td>
		  <td class="text-nowrap">
		      <span class="badge bg-inverse-success p-2"><?= $project->project_status == 'finish' ? 'Selesai' : NULL ?></span>
		  </td>
		  <td class="text-nowrap">
		      <span class="text-secondary small"><?= datetimeIDN($project->project_deadline) ?></span>
		  </td>
		  <td class="text-nowrap">
		      <span class="text-secondary small"><?= datetimeIDN($project->project_current_deadline) ?></span>
		  </td>
		  <td class="text-nowrap">
		      <!-- <p class="text-xs mb-1">Completed Projects <strong>(8/12)</strong></p> -->
		      <div class="progress progress-lg">
		          <div class="progress-bar bg-success" role="progressbar" <?= 'style="width: '.$project->project_progress.'%"' ?>  aria-valuenow="<?= $project->project_progress ?>" aria-valuemin="0" aria-valuemax="100"><?= $project->project_progress ?>%</div>
		      </div>
		  </td>
		  <td class="text-nowrap text-center">
		      <a href="<?= site_url('direktur/riwayat/detail/'.$project->company_id.'/'.$project->projectID) ?>" class="btn btn-sm my-1 btn-primary text-nowrap" data-toggle="tooltip" title="Lihat Proyek">Detail</a>
		  </td>
		</tr>
	<?php } ?>
<?php } else { ?>
	<tr>
		<td colspan="7" class="text-center">Riwayat Proyek Kosong.</td>
	</tr>
<?php } ?>