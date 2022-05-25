<div class="form-row mb-3">
  <div class="col-12">
    <label for="comp_name">Nama anak perusahaan <span class="text-danger">*</span></label>
    <input type="text" name="comp_name" id="comp_name" class="form-control" placeholder="Contoh: CV. Mitra Batik" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>
</div>

<div class="form-row mb-3">
  <div class="col-12">
    <label for="comp_email">Alamat Email <span class="text-danger">*</span></label>
    <input type="text" name="comp_email" id="comp_email" class="form-control" placeholder="Contoh: nama@mail.com" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>
</div>

<div class="form-row">
  <div class="col-12 col-md-6 col-lg-8 mb-3">
    <label for="comp_phone">Nomor Telepon <span class="text-danger">*</span></label>
    <input type="number" name="comp_phone" id="comp_phone" class="form-control" placeholder="Isi nomor telepon" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>
  <div class="col-12 col-md-6 col-lg-4 mb-3">
    <label for="comp_type">Tipe <span class="text-danger">*</span></label>
    <select id="comp_type" name="comp_type" class="form-control formSelect">
      <option value="">-- Pilih --</option>
      <option value="CV">CV</option>
      <option value="PT">Perseroan Terbatas (PT)</option>
    </select>
    <div class="invalid-feedback"></div>
  </div>
</div>

<div class="form-row">
  <div class="col-12 mb-3">
    <label for="comp_since">Didirikan pada <span class="text-danger">*</span></label>
    <input type="date" name="comp_since" id="comp_since" class="form-control">
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="upload_logo">Upload logo <span class="text-muted">(Opsional)</span></label>
    <input type="file" accept=".jpg,.jpeg,.png" name="comp_logo" id="upload_logo" class="form-control">
  </div>

  <div class="col-12 mb-3">
    <label for="comp_address">Alamat <span class="text-muted">(Opsional)</span></label>
    <textarea name="comp_address" id="comp_address" class="form-control" rows="2" placeholder="Alamat perusahaan"></textarea>
  </div>

  <div class="col-12">
    <label for="comp_desc">Deskripsi <span class="text-muted">(Opsional)</span></label>
    <textarea name="comp_desc" id="comp_desc" class="form-control" rows="4" placeholder="Deskripsi / Bio perusahaan"></textarea>
  </div>
</div>