<input type="hidden" name="subproject_id" value="<?= $subproject->subproject_id ?>">
<input type="hidden" name="ID_project" value="<?= $subproject->ID_project ?>">
<div class="form-row">
  <div class="col-12 mb-3">
    <label for="subproject_name">Nama Sub-proyek <span class="text-danger small">*</span></label>
    <input type="text" name="subproject_name" id="subproject_name" class="form-control" autocomplete="off" value="<?= $subproject->subproject_name ?>">
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="subproject_deadline">Deadline / Proyek Selesai <span class="text-danger small">*</span></label>
    <input type="date" name="subproject_deadline" id="subproject_deadline" class="form-control" value="<?= $subproject->subproject_deadline ?>" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="subproject_status">Status</label>
    <select id="subproject_status" name="subproject_status" class="form-control">
        <option value="">-- Pilih status subproyek</option>
        <option value="onprogress" <?= $subproject->subproject_status == 'onprogress' ? 'selected' : NULL ?>>Berjalan</option>
        <option value="pending" <?= $subproject->subproject_status == 'pending' ? 'selected' : NULL ?>>Pending</option>
        <option value="finish" <?= $subproject->subproject_status == 'finish' ? 'selected' : NULL ?>>Selesai</option>
    </select>
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="priority_level">Level Prioritas</label>
    <select id="priority_level" name="priority_level" class="form-control">
      <?php foreach($data_priority as $dp) { ?>
        <option value="<?= $dp->priority_id ?>" <?= $dp->priority_id == $subproject->ID_priority ? 'selected' : NULL ?>><?= $dp->priority_name ?></option>
      <?php } ?>
    </select>
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-2">
    <label>Pilih Warna Panel Sub-proyek</label>
    <div class="d-flex flex-wrap">
      <input type="radio" name="panel_color" value="kanban-danger" class="custom-radio mr-2" <?= $subproject->panel_color == 'kanban-danger' ? 'checked' : NULL ?>>
      <input type="radio" name="panel_color" value="kanban-success" class="custom-radio mr-2" <?= $subproject->panel_color == 'kanban-success' ? 'checked' : NULL ?>>
      <input type="radio" name="panel_color" value="kanban-info" class="custom-radio mr-2" <?= $subproject->panel_color == 'kanban-info' ? 'checked' : NULL ?>>
      <input type="radio" name="panel_color" value="kanban-warning" class="custom-radio mr-2" <?= $subproject->panel_color == 'kanban-warning' ? 'checked' : NULL ?>>
      <input type="radio" name="panel_color" value="kanban-purple" class="custom-radio mr-2" <?= $subproject->panel_color == 'kanban-purple' ? 'checked' : NULL ?>>
      <input type="radio" name="panel_color" value="kanban-primary" class="custom-radio mr-2" <?= $subproject->panel_color == 'kanban-primary' ? 'checked' : NULL ?>>
    </div>
  </div>
</div>