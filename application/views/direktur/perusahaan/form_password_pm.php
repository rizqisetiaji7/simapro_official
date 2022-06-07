<input type="hidden" name="user_unique_id" value="<?= $unique_id ?>">
<input type="hidden" name="user_role" value="<?= $user_role ?>">
<div class="form-row">
  <div class="col-12 mb-3">
    <label for="user_password">Password baru <span class="text-danger">*</span></label>
    <input type="password" name="user_password" id="user_password" class="form-control" placeholder="Isi password" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>

  <div class="col-12 mb-3">
    <label for="password_confirm">Konfirmasi password <span class="text-danger">*</span></label>
    <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Isi Konfirmasi password" autocomplete="off">
    <div class="invalid-feedback"></div>
  </div>
</div>