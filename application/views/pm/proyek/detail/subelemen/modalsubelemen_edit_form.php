<input type="hidden" name="ID_subproject" value="">
<input type="hidden" name="project_task_id" value="">
<input type="hidden" name="current_progress" value="">

<div class="form-row">
  <div class="col-12 mb-3">
    <label for="project_task_name">Nama Sub-Elemen Proyek <span class="text-danger small">*</span></label>
    <input type="text" name="project_task_name" id="project_task_name" class="form-control" value="" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="task_priority_level">Level Prioritas <span class="text-danger small">*</span></label>
    <select id="task_priority_level" name="task_priority_level" class="form-control">
      <option value="">Rendah</option>
      <option value="" selected="selected">Normal</option>
      <option value="">Tinggi</option>
    </select>
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="project_task_status">Status</label>
    <select id="project_task_status" name="project_task_status" class="form-control">
        <option value="">-- Pilih status --</option>
        <option value="onprogress">Berjalan</option>
        <option value="pending">Pending</option>
        <option value="finish">Selesai</option>
    </select>
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="project_task_deadline">Deadline / Proyek Selesai <span class="text-danger small">*</span></label>
    <input type="date" name="project_task_deadline" id="project_task_deadline" class="form-control" value="" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>
</div>