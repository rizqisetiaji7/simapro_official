<input type="hidden" name="comp_handle_ID" value="<?= $data['handle_id'] ?>">
<input type="hidden" name="ID_company" value="<?= $data['company_id'] ?>">
<input type="hidden" name="user_role" value="<?= $data['user_role'] ?>">
<input type="hidden" name="user_role_name" value="<?= $data['role_name'] ?>">

<div class="form-row mb-3">
	<div class="col-3 text-center">
		<div class="profile-pic">
			<img src="<?= base_url('assets/img/default-avatar.jpg') ?>">
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
		<input type="text" name="user_fullname" id="user_fullname" class="form-control" placeholder="Isi nama lengkap" autocomplete="off">
		<div class="invalid-feedback"></div>
	</div>
</div>

<div class="form-row mb-3">
	<div class="col-12">
   	<label for="user_email">Alamat Email <span class="text-danger small">(Wajib email aktif)</span></label>
   	<input type="text" name="user_email" id="user_email" class="form-control" placeholder="Contoh: nama@mail.com" autocomplete="off">
   	<div class="invalid-feedback"></div>
 	</div>
</div>

<div class="form-row mb-3">
	<div class="col-12">
   	<label for="user_password">Password <span class="text-danger small">*</span></label>
   	<input type="password" name="user_password" id="user_password" class="form-control" placeholder="Password" autocomplete="off">
   	<div class="invalid-feedback"></div>
 	</div>
</div>

<div class="form-row mb-3">
	<div class="col-12">
   	<label for="password_confirm">Konfirmasi Password <span class="text-danger small">*</span></label>
   	<input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Password" autocomplete="off">
   	<div class="invalid-feedback"></div>
 	</div>
</div>

<div class="form-row mb-3">
  <div class="col-12">
    <label for="user_phone">Nomor Telepon <span class="text-danger small">*</span></label>
    <input type="text" name="user_phone" id="user_phone" class="form-control" placeholder="Isi nomor telepon" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>
</div>

<div class="form-row">
	<div class="col-12">
	   <label for="user_address">Alamat <span class="text-muted small">(Opsional)</span></label>
	   <textarea name="user_address" id="user_address" class="form-control" placeholder="Alamat lengkap..." rows="3"></textarea>
	   <div class="invalid-feedback"></div>
	</div>
</div>