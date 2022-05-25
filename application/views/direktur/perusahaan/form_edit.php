<div class="form-row mb-3">
  <div class="col-12">
    <input type="hidden" name="comp_parent_id" id="compParentID" value="<?= $company->comp_parent_id ?>">
    <input type="hidden" name="old" id="old" value="<?= base64_encode($company->comp_logo) ?>">
    <input type="hidden" name="comp_code_ID" value="<?= base64_encode($company->comp_code_ID) ?>">
    <label for="comp_name">Nama anak perusahaan <span class="text-danger">*</span></label>
    <input type="text" name="comp_name" id="comp_name" class="form-control" value="<?= $company->comp_name ?>" placeholder="Contoh: CV. Mitra Batik" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>
</div>

<div class="form-row mb-3">
  <div class="col-12">
    <label for="comp_email">Alamat Email <span class="text-danger">*</span></label>
    <input type="text" name="comp_email" id="comp_email" class="form-control" value="<?= $company->comp_email ?>" placeholder="Contoh: nama@mail.com" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>
</div>

<div class="form-row mb-3">
  <div class="col-12 col-md-6 col-lg-8 mb-3">
    <label for="comp_phone">Nomor Telepon <span class="text-danger">*</span></label>
    <input type="number" name="comp_phone" id="comp_phone" class="form-control" value="<?= $company->comp_phone ?>" placeholder="Isi nomor telepon" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>
  <div class="col-12 col-md-6 col-lg-4 mb-3">
    <label for="comp_type">Tipe <span class="text-danger">*</span></label>
    <select id="comp_type" name="comp_type" class="form-control formSelect">
      <option value="">-- Pilih --</option>
      <option value="CV" <?= $company->comp_type == 'CV' ? 'selected' : NULL ?>>CV</option>
      <option value="PT" <?= $company->comp_type == 'PT' ? 'selected' : NULL ?>>Perseroan Terbatas (PT)</option>
    </select>
    <div class="invalid-feedback"></div>
  </div>
</div>

<div class="form-row align-items-center mb-4">
  <div class="col-12 col-sm-4 col-md-3 mb-3">
    <img src="<?= $company->comp_logo == 'default-placeholder320x320.png' ? base_url('assets/img/'.$company->comp_logo) : base_url('uploads/company/'.$company->comp_logo) ?>" class="w-100" style="max-width: 170px; max-height: 140px; object-fit: cover;">
  </div>
  <div class="col-12 col-sm-8 col-md-9">
    <label for="upload_logo">Ubah logo <span class="text-muted">(Opsional)</span></label>
    <input type="file" name="comp_logo" accept=".jpg,.jpeg,.png" id="upload_logo" class="form-control">
  </div>
</div>

<div class="form-row">
  <div class="col-12 mb-3">
    <label for="comp_since">Didirikan pada <span class="text-danger">*</span></label>
    <input type="date" name="comp_since" id="comp_since" class="form-control" value="<?= $company->comp_since ?>">
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="comp_address">Alamat <span class="text-muted">(Opsional)</span></label>
    <textarea name="comp_address" id="comp_address" class="form-control" rows="2" placeholder="Alamat perusahaan"><?= $company->comp_address ?></textarea>
  </div>

  <div class="col-12">
    <label for="comp_desc">Deskripsi <span class="text-muted">(Opsional)</span></label>
    <textarea name="comp_desc" id="comp_desc" class="form-control" rows="4" placeholder="Deskripsi / Bio perusahaan"><?= $company->comp_desc ?></textarea>
  </div>
</div>