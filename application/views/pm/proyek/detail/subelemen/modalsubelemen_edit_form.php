<input type="hidden" name="ID_subproject" value="<?= $subelemen->ID_subproject ?>">
<input type="hidden" name="project_task_id" value="<?= $subelemen->project_task_id ?>">
<input type="hidden" name="current_progress" value="<?= $subelemen->project_task_progress ?>">

<div class="form-row">
  <div class="col-12 mb-3">
    <label for="project_task_name">Nama Sub-Elemen Proyek <span class="text-danger small">*</span></label>
    <input type="text" name="project_task_name" id="project_task_name" class="form-control" value="<?= $subelemen->project_task_name ?>" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="task_priority_level">Level Prioritas <span class="text-danger small">*</span></label>
    <select id="task_priority_level" name="task_priority_level" class="form-control">
      <?php foreach($priority as $pr) { ?>
        <option value="<?= $pr->priority_id ?>" <?= $pr->priority_id == $subelemen->ID_priority ? 'selected' : NULL ?>><?= $pr->priority_name ?></option>
      <?php } ?>
    </select>
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="project_task_status">Status <span class="text-danger small">*</span></label>
    <select id="project_task_status" name="project_task_status" class="form-control">
        <option value="none" <?= $subelemen->project_task_status == 'none' ? 'selected' : NULL ?>>-- Pilih status --</option>
        <option value="onprogress" <?= $subelemen->project_task_status == 'onprogress' ? 'selected' : NULL ?>>Berjalan</option>
        <option value="pending" <?= $subelemen->project_task_status == 'pending' ? 'selected' : NULL ?>>Pending</option>
        <option value="finish" <?= $subelemen->project_task_status == 'finish' ? 'selected' : NULL ?>>Selesai</option>
    </select>
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="project_task_deadline">Deadline / Proyek Selesai <span class="text-danger small">*</span></label>
    <input type="date" name="project_task_deadline" id="project_task_deadline" class="form-control" value="<?= $subelemen->project_task_deadline ?>" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>
</div>