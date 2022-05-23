<input type="hidden" name="user_unique_id" value="<?= $director->user_unique_id ?>">
<input type="hidden" name="user_id" value="<?= $director->user_id ?>">
<input type="hidden" name="old_profile" value="<?= $director->user_profile ?>">

<div class="form-row mb-3">
	<div class="col-3 text-center">
		<div class="profile-pic">
			<img src="<?= $director->user_profile == 'default-avatar.jpg' ? base_url('assets/img/'.$director->user_profile) : base_url('uploads/profile/'.$director->user_profile) ?>">
		</div>
	</div>
	<div class="col-9">
		<label for="user_profile">Upload Foto <span class="text-muted small">(Opsional)</span></label>
		<input type="file" accept=".jpg,.jpeg,.png" name="user_profile" id="upload_profile" class="form-control">
	</div>
</div>

<div class="form-row mb-3">
	<div class="col-12">
		<label for="user_fullname">Nama Lengkap <span class="text-danger small">*</span></label>
		<input type="text" name="user_fullname" id="user_fullname" value="<?= $director->user_fullname ?>" class="form-control" placeholder="Isi nama lengkap" autocomplete="off">
		<div class="invalid-feedback"></div>
	</div>
</div>

<div class="form-row mb-3">
	<div class="col-12">
   	<label for="user_email">Alamat Email <span class="text-danger small">(Wajib email aktif)</span></label>
   	<input type="text" name="user_email" id="user_email" value="<?= $director->user_email ?>" class="form-control" placeholder="Contoh: nama@mail.com" autocomplete="off">
   	<div class="invalid-feedback"></div>
 	</div>
</div>

<div class="form-row mb-3">
  <div class="col-12">
    <label for="user_phone">Nomor Telepon <span class="text-muted small">(Opsional)</span></label>
    <input type="text" name="user_phone" id="user_phone" value="<?= $director->user_phone ?>" class="form-control" placeholder="Isi nomor telepon" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>
</div>

<div class="form-row">
	<div class="col-12">
	   <label for="user_address">Alamat <span class="text-muted small">(Opsional)</span></label>
	   <textarea name="user_address" id="user_address" class="form-control" placeholder="Alamat lengkap..." rows="3"><?= $director->user_address ?></textarea>
	   <div class="invalid-feedback"></div>
	</div>
</div>