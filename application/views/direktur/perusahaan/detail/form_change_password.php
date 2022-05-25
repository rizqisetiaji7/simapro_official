<input type="hidden" name="user_unique_id" value="<?= $unique_id ?>">
<input type="hidden" name="user_role" value="<?= $user_role ?>">

<div class="form-row mb-3">
	<div class="col-12">
   	<label for="user_password">Password baru <span class="text-danger small">*</span></label>
   	<input type="password" name="user_password" id="user_password" class="form-control" placeholder="Ketik Password baru" autocomplete="off">
   	<div class="invalid-feedback"></div>
 	</div>
</div>

<div class="form-row mb-3">
	<div class="col-12">
   	<label for="password_confirm">Konfirmasi Password <span class="text-danger small">*</span></label>
   	<input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Ketik ulang password baru" autocomplete="off">
   	<div class="invalid-feedback"></div>
 	</div>
</div>