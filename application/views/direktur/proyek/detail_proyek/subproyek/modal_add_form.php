<input type="hidden" name="ID_project" value="<?= $project_id ?>">
<div class="form-row">
  <div class="col-12 mb-3">
    <label for="subproject_name">Nama Sub-proyek <span class="text-danger small">*</span></label>
    <input type="text" name="subproject_name" id="subproject_name" class="form-control" placeholder="" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="subproject_deadline">Deadline / Subproyek Selesai <span class="text-danger small">*</span></label>
    <input type="date" name="subproject_deadline" id="subproject_deadline" class="form-control" placeholder="" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="priority_level">Level Prioritas</label>
    <select id="priority_level" name="priority_level" class="form-control">
      <?php foreach($data_priority as $dp) { ?>
      <option value="<?= $dp->priority_id ?>"><?= $dp->priority_name ?></option>
      <?php } ?>
    </select>
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-2">
    <label>Pilih Warna Panel Sub-proyek</label>
    <div class="d-flex flex-wrap">
      <input type="radio" name="panel_color" value="kanban-danger" class="custom-radio mr-2" checked>
      <input type="radio" name="panel_color" value="kanban-success" class="custom-radio mr-2">
      <input type="radio" name="panel_color" value="kanban-info" class="custom-radio mr-2">
      <input type="radio" name="panel_color" value="kanban-warning" class="custom-radio mr-2">
      <input type="radio" name="panel_color" value="kanban-purple" class="custom-radio mr-2">
      <input type="radio" name="panel_color" value="kanban-primary" class="custom-radio mr-2">
    </div>
  </div>
</div>