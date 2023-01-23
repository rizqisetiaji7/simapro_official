<input type="hidden" name="user_unique_id" value="<?= $user->user_unique_id ?>">
<input type="hidden" name="user_role" value="<?= $user->user_role ?>">
<input type="hidden" name="old_profile" value="<?= $user->user_profile ?>">

<input type="file" name="profile_image" id="inputProfile" accept=".jpg,.png,.jpeg" class="d-none">
<div style="min-height: 200px; border-radius: 8px; background: #f7f7f7;" class="d-flex flex-column align-items-center justify-content-center py-4 px-3 mb-4">
  <img src="<?= base_url('assets/img/cloud-computing.png') ?>" width="64" class="mb-3" alt="cloud computing icon">
  <div class="d-flex flex-column align-items-center mb-3 text-center">
    <p class="text-secondary mb-1 mr-2">Unggah foto atau gambar dari komputer. <strong class="text-primary" style="cursor: pointer;" id="chooseFileImage">Pilih file</strong></p>
    <p class="text-muted mb-0 small">Maksimal ukuran file <strong class="text-dark">4MB</strong></p>
  </div>
  <div id="profileFileName" class="text-center py-2 px-3 d-none" style="border-radius: 4px; position: relative; overflow: hidden; background: #f0f0f0;"></div>
</div>

<div class="form-row mb-3">
  <div class="col-12">
    <div class="profile-pic m-auto">
      <img src="<?= $user->user_profile == 'default-avatar.jpg' ? base_url('assets/img/default-avatar.jpg') : base_url('uploads/profile/'.$user->user_profile) ?>">
    </div>
  </div>
</div>

<div class="form-row">
  <div class="col-12 mb-3">
    <label for="user_fullname">Nama Lengkap <span class="text-danger">*</span></label>
    <input type="text" name="user_fullname" id="user_fullname" class="form-control" value="<?= $user->user_fullname ?>" placeholder="Nama Proyek Manajer" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="user_email">Email <span class="text-danger small">(Wajib email aktif)</span></label>
    <input type="text" name="user_email" id="user_email" class="form-control" value="<?= $user->user_email ?>" placeholder="Contoh: nama@mail.com" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>
</div>

<div class="form-row">
  <div class="col-12 mb-3">
    <label for="user_phone">Nomor Telepon <span class="text-muted small">(Opsional)</span></label>
    <input type="text" name="user_phone" id="user_phone" class="form-control" value="<?= $user->user_phone ?>" placeholder="Isi nomor telepon" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>
  
  <div class="col-12 mb-3">
    <label for="user_address">Alamat <span class="text-muted small">(Opsional)</span></label>
    <textarea name="user_address" id="user_address" class="form-control" rows="3" placeholder="Isi alamat..."><?= $user->user_address ?></textarea>
  </div>
</div>