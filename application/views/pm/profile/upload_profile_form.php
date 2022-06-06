<input type="hidden" name="unique_id" value="<?= urlencode(base64_encode($user->user_unique_id)) ?>">
<input type="hidden" name="user_role" value="<?= urlencode(base64_encode($user->user_role)) ?>">
<input type="hidden" name="old_profile" value="<?= $user->user_profile ?>">
<input type="file" name="profile_image" id="inputProfile" accept=".jpg,.png,.jpeg" class="d-none">

<div style="min-height: 200px; border-radius: 8px; background: #f7f7f7;" class="d-flex flex-column align-items-center justify-content-center py-4 px-3">
	<img src="<?= base_url('assets/img/cloud-computing.png') ?>" width="64" class="mb-3" alt="cloud computing icon">
	<div class="d-flex align-items-center mb-3 text-center">
		<p class="text-muted mb-0 mr-2">Unggah foto atau gambar dari komputer. <strong class="text-primary" style="cursor: pointer;" id="chooseFileImage">Pilih file</strong></p>
	</div>

	<div id="profileFileName" class="text-center py-2 px-3 d-none" style="border-radius: 4px; position: relative; overflow: hidden; background: #f0f0f0;"></div>

	<button type="submit" class="btn btn-secondary px-5" id="btnSubmitProfile" disabled="disabled">Upload</button>
</div>