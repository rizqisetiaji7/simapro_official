<div class="row">
	<!-- <div class="col-12 col-sm-11 m-auto">
		<div class="card">
			<div class="card-body">
				<?php var_dump(user_login()) ?>
			</div>
		</div>
	</div> -->


	<div class="col-12 col-sm-11 m-auto">
		<div class="card tab-box mb-0">
			<div class="row user-tabs">
				<div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
					<ul class="nav nav-tabs nav-tabs-bottom">
						<li class="nav-item">
							<a href="#user_profile" data-toggle="tab" class="nav-link active">
								<i class="fa-solid fa-user-pen mr-1 text-primary"></i> Edit Profile
							</a>
						</li>
						<li class="nav-item">
							<a href="#change_password" data-toggle="tab" class="nav-link">
								<i class="fa-solid fa-shield mr-1 text-primary"></i> Ganti Password
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="tab-content pt-0">			
			<!-- User Profile Tab -->
			<div id="user_profile" class="pro-overview tab-pane fade active show">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<p class="text-muted mt-2">Gambar Profile</p>
								<!-- Content -->
								<div class="d-flex align-items-center">
									<div class="profile-pic mr-4">
										<img src="<?= user_login()->user_profile == 'default-avatar.jpg' ? base_url('assets/img/default-avatar.jpg') : base_url('uploads/profile/'.user_login()->user_profile) ?>">
									</div>
									<div>
										<span class="text-primary small d-block mb-1">#<?= user_login()->user_unique_id ?></span>
										<div>
											<button class="btn btn-custom px-4 mr-1" onclick="uploadProfile(<?= "'".urlencode(base64_encode(user_login()->user_unique_id))."'" ?>, <?= "'".urlencode(base64_encode(user_login()->user_role))."'" ?>)">Upload</button>
											<button class="btn btn-light px-4 ml-1" onclick="removeProfile()">Hapus Profile</button>
										</div>
									</div>
								</div>

								<div class="divider mt-3 mb-3"></div>

								<form id="editProfile" action="<?= site_url('direktur/profile/edit') ?>" method="POST">
									<div class="form-row">
										<input type="hidden" name="user_unique_id" value="<?= urlencode(base64_encode(user_login()->user_unique_id)) ?>">
										<input type="hidden" name="user_role" value="<?= urlencode(base64_encode(user_login()->user_role)) ?>">
										<div class="col-12 col-md-6 mb-3">
											<label for="user_fullname">Nama lengkap <span class="text-danger small">*</span></label>
											<input type="text" name="user_fullname" id="user_fullname" class="form-control" value="<?= user_login()->user_fullname ?>" placeholder="Isi nama lengkap" autocomplete="off">
											<div class="invalid-feedback"></div>
										</div>

										<div class="col-12 col-md-6 mb-3">
											<label for="user_phone">Nomor Telepon <span class="text-muted small">(Opsional)</span></label>
											<input type="text" name="user_phone" id="user_phone" class="form-control" value="<?= user_login()->user_phone ?>" placeholder="Nomor telepon" autocomplete="off">
											<div class="invalid-feedback"></div>
										</div>
									</div>

									<div class="form-row mb-3">
										<div class="col-12 mb-3">
											<label for="user_email">Email <span class="text-danger small">*</span></label>
											<input type="text" name="user_email" id="user_email" class="form-control" value="<?= user_login()->user_email ?>" placeholder="Alamat email" autocomplete="off">
											<div class="invalid-feedback"></div>
										</div>

										<div class="col-12 mb-3">
											<label for="user_email">Alamat <span class="text-muted small">(Opsional)</span></label>
											<textarea class="form-control" rows="7" placeholder="Isi alamat lengkap"><?= user_login()->user_address ?></textarea>
										</div>
									</div>

									<div class="form-row mb-3">
										<div class="col-12">
											<button type="submit" class="btn btn-custom px-4">Update Profile</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /User Profile Tab -->
			
			<!-- Change Password Tab -->
			<div class="tab-pane fade" id="change_password">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-12 col-md-7 m-auto">
										<h4 class="project-title mt-2 mb-4">Ganti password akun login</h4>
										<form id="editPassword" action="<?= site_url('direktur/profile/edit_password') ?>" method="POST">
											<div class="form-row">
												<div class="col-12 mb-3">
													<label for="new_password">Password baru <span class="text-danger small">*</span></label>
													<input type="password" name="new_password" id="new_password" class="form-control" autocomplete="off">
													<div class="invalid-feedback"></div>
												</div>
												<div class="col-12 mb-4">
													<label for="confirm_password">Konfirmasi Password <span class="text-danger small">*</span></label>
													<input type="password" name="confirm_password" id="confirm_password" class="form-control" autocomplete="off">
													<div class="invalid-feedback"></div>
												</div>
											</div>
											<div class="form-row">
												<div class="col-12 mb-3">
													<button type="submit" class="btn btn-custom btn-block py-2">Update password</button>
												</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Change Password Tab -->	
		</div>
	</div>
</div>

<?php $this->view('direktur/profile/modal'); ?>
<?php $this->view('direktur/profile/script'); ?>