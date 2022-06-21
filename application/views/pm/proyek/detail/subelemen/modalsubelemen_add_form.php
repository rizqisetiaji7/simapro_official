<input type="hidden" name="ID_subproject" value="<?= $subproject_id ?>">
<input type="hidden" name="project_id" value="<?= $project_id ?>">
<div class="form-row">
  <div class="col-12 mb-3">
    <label for="project_task_name">Nama Sub-Elemen Proyek <span class="text-danger small">*</span></label>
    <input type="text" name="project_task_name" id="project_task_name" class="form-control" placeholder="" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="task_priority_level">Level Prioritas <span class="text-danger small">*</span></label>
    <select id="task_priority_level" name="task_priority_level" class="form-control">
      <?php foreach ($priority as $pr) { ?>
      <option value="<?= $pr->priority_id ?>"><?= $pr->priority_name ?></option>
      <?php } ?>
    </select>
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="project_task_deadline">Deadline / Proyek Selesai <span class="text-danger small">*</span></label>
    <input type="date" name="project_task_deadline" id="project_task_deadline" class="form-control" placeholder="" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>
</div>