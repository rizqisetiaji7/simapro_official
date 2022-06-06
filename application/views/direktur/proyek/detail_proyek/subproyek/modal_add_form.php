<div class="form-row">
  <div class="col-12 mb-3">
    <label for="subproject_name">Nama Sub-proyek <span class="text-danger small">*</span></label>
    <input type="text" name="subproject_name" id="subproject_name" class="form-control" placeholder="" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="subproject_deadline">Deadline / Proyek Selesai <span class="text-danger small">*</span></label>
    <input type="date" name="subproject_deadline" id="subproject_deadline" class="form-control" placeholder="" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="priority_level">Level Prioritas <span class="text-danger small">*</span></label>
    <select id="priority_level" name="priority_level" class="form-control">
      <option value="">Rendah</option>
      <option value="">Sedang</option>
      <option value="">Menengah</option>
      <option value="">Tinggi</option>
    </select>
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-2">
    <label>Pilih Warna Panel Sub-proyek <span class="text-muted small">(Opsional)</span></label>
    <div class="d-flex flex-wrap">
      <input type="radio" name="panel_color" value=".djkjdk" class="custom-radio mr-2" checked>
      <input type="radio" name="panel_color" value=".djkjdk" class="custom-radio mr-2">
      <input type="radio" name="panel_color" value=".djkjdk" class="custom-radio mr-2">
    </div>
  </div>
</div>