<input type="hidden" name="ID_project" value="">
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
      <option value="">Rendah</option>
      <option value="">Normal</option>
      <option value="">Tinggi</option>
    </select>
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-2">
    <label>Pilih Warna Panel Sub-proyek</label>
    <div class="input-radio">
      <!-- Color 1 -->
      <input type="radio" id="kanbanSuccess" name="panel_color" value="kanban-success" class="d-none custom-radio-input" checked>
      <label for="kanbanSuccess" class="label-box bg-success">
        <i class="fas fa-check text-white check-icon"></i>
      </label>

      <!-- Color 2 -->
      <input type="radio" id="kanbanDanger" name="panel_color" value="kanban-danger" class="d-none custom-radio-input">
      <label for="kanbanDanger" class="label-box bg-danger">
        <i class="fas fa-check text-white check-icon"></i>
      </label>

      <!-- Color 3 -->
      <input type="radio" id="kanbanWarning" name="panel_color" value="kanban-warning" class="d-none custom-radio-input">
      <label for="kanbanWarning" class="label-box bg-warning">
        <i class="fas fa-check text-white check-icon"></i>
      </label>

      <!-- Color 4 -->
      <input type="radio" id="kanbanInfo" name="panel_color" value="kanban-info" class="d-none custom-radio-input">
      <label for="kanbanInfo" class="label-box bg-info">
        <i class="fas fa-check text-white check-icon"></i>
      </label>

      <!-- Color 5 -->
      <input type="radio" id="kanbanPurple" name="panel_color" value="kanban-purple" class="d-none custom-radio-input">
      <label for="kanbanPurple" class="label-box bg-purple">
        <i class="fas fa-check text-white check-icon"></i>
      </label>

      <!-- Color 6 -->
      <input type="radio" id="kanbanPrimary" name="panel_color" value="kanban-primary" class="d-none custom-radio-input">
      <label for="kanbanPrimary" class="label-box bg-primary">
        <i class="fas fa-check text-white check-icon"></i>
      </label>
    </div>
  </div>
</div>