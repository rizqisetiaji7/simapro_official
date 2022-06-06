<!-- <div class="row">
	<div class="col-12">
		<div class="card">
			
			<div class="card-body">
				<?php var_dump($company) ?>
			</div>

		</div>
	</div>
</div> -->

<div class="row">
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
						<li class="nav-item">
							<a href="#edit_profile_perusahaan" data-toggle="tab" class="nav-link">
								<i class="fa-solid fa-shield mr-1 text-primary"></i> Perusahaan
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
									<div class="profile-pic mr-4" id="userProfilePhoto">
										<img src="<?= user_login()->user_profile == 'default-avatar.jpg' ? base_url('assets/img/default-avatar.jpg') : base_url('uploads/profile/'.user_login()->user_profile) ?>" alt="<?= user_login()->user_fullname ?>">
									</div>
									<div>
										<span class="text-primary small d-block mb-1">#<?= user_login()->user_unique_id ?></span>
										<div>
											<button class="btn btn-custom px-4 mr-1" onclick="uploadProfile(<?= "'".urlencode(base64_encode(user_login()->user_unique_id))."'" ?>, <?= "'".urlencode(base64_encode(user_login()->user_role))."'" ?>)">Upload</button>
											<button class="btn btn-light px-4 ml-1" <?= user_login()->user_profile == 'default-avatar.jpg' ? 'disabled=disabled' : ' onclick="removeProfile('."'".urlencode(base64_encode(user_login()->user_unique_id))."'".', '."'".urlencode(base64_encode(user_login()->user_profile))."'".')"' ?> >Hapus Profile</button>
										</div>
									</div>
								</div>

								<div class="divider mt-3 mb-3"></div>

								<form id="editProfileData" action="<?= site_url('direktur/profile/edit_data') ?>" method="POST">
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
											<label for="user_address">Alamat <span class="text-muted small">(Opsional)</span></label>
											<textarea class="form-control" rows="7" name="user_address" placeholder="Isi alamat lengkap"><?= user_login()->user_address ?></textarea>
										</div>
									</div>

									<div class="form-row mb-3">
										<div class="col-12">
											<button type="submit" id="btnUpdate-profileData" class="btn btn-custom px-4">Update Profile</button>
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
											<input type="hidden" name="user_unique_id" value="<?= urlencode(base64_encode(user_login()->user_unique_id)) ?>">
											<input type="hidden" name="user_role" value="<?= urlencode(base64_encode(user_login()->user_role)) ?>">
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
													<button type="submit" id="btnUpdate-password" class="btn btn-custom btn-block py-2">Update password</button>
												</div>
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


			<!-- Edit Profile Perusahaan -->
			<div class="tab-pane fade" id="edit_profile_perusahaan">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<p class="text-muted">Detail Info Perusahaan</p>
								<!-- Content -->
								<div class="d-flex align-items-center">
									<img src="<?= $company->comp_logo == 'default-placeholder320x320.png' ? base_url('assets/img/default-placeholder320x320.png') : base_url('uploads/company/'.$company->comp_logo) ?>" height="80">
									<div class="ml-3">
										<span class="text-primary small d-block mb-1">#<?= $company->comp_code ?></span>
										<p class="text-secondary small mb-1"><?= 'Didirikan: '.dateTimeIDN($company->comp_since) ?></p>
										<div>
											<button class="btn btn-custom px-4 btn-sm mr-1" onclick="uploadLogo(<?= "'".urlencode(base64_encode($company->comp_code))."'" ?>)">Ganti Logo</button>
										</div>
									</div>
								</div>

								<div class="divider mt-3 mb-3"></div>

								<form id="editProfilePerusahaan" action="<?= site_url('direktur/perusahaan/edit') ?>" method="POST">
									<div class="form-row">
										<input type="hidden" name="company_id" value="<?= $company->company_id ?>">
										<input type="hidden" name="comp_code" value="<?= urlencode(base64_encode($company->comp_code)) ?>">
										<div class="col-12 col-sm-6 col-md-7 mb-3">
											<label for="comp_name">Nama Perusahaan <span class="text-danger small">*</span></label>
											<input type="text" name="comp_name" id="comp_name" class="form-control" value="<?= $company->comp_name ?>" placeholder="Isi nama perusahaan" autocomplete="off">
											<div class="invalid-feedback"></div>
										</div>

										<div class="col-12 col-sm-6 col-md-5 mb-3">
											<label for="comp_phone">Nomor Telepon <span class="text-muted small">(Opsional)</span></label>
											<input type="text" name="comp_phone" id="comp_phone" class="form-control" value="<?= $company->comp_phone ?>" placeholder="Nomor telepon" autocomplete="off">
											<div class="invalid-feedback"></div>
										</div>
									</div>

									<div class="form-row">
										<div class="col-12 col-sm-6 col-md-7 mb-3">
											<label for="comp_email">Email <span class="text-danger small">*</span></label>
											<input type="text" name="comp_email" id="comp_email" class="form-control" value="<?= $company->comp_email ?>" placeholder="Alamat email" autocomplete="off">
											<div class="invalid-feedback"></div>
										</div>
										<div class="col-12 col-sm-6 col-md-5 mb-3">
											<label for="comp_type">Tipe perusahaan <span class="text-danger small">*</span></label>
											<select name="comp_type" class="form-control" id="comp_type">
												<option value="PT" <?= $company->comp_type == 'PT' ? 'selected' : NULL ?>>Perseroan Terbatas (PT)</option>
												<option value="CV" <?= $company->comp_type == 'CV' ? 'selected' : NULL ?>>CV</option>
											</select>
											<div class="invalid-feedback"></div>
										</div>
									</div>

									<div class="form-row mb-3">
										<div class="col-12 mb-3">
											<label for="comp_address">Alamat <span class="text-muted small">(Opsional)</span></label>
											<input type="text" name="comp_address" id="comp_address" class="form-control" value="<?= $company->comp_address ?>" placeholder="Isi alamat lengkap" autocomplete="off">
										</div>

										<div class="col-12 mb-3">
											<label for="comp_desc">Deskripsi/Bio <span class="text-muted small">(Opsional)</span></label>
											<textarea class="form-control" rows="7" name="comp_desc" placeholder="Isi Biografi Perusahaan"><?= $company->comp_desc ?></textarea>
										</div>
									</div>

									<div class="form-row mb-3">
										<div class="col-12">
											<button type="submit" id="btnUpdate-Perusahaan" class="btn btn-custom px-4">Update</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Edit Profile Perusahaan -->
		</div>
	</div>
</div>

<?php $this->view('direktur/profile/modal'); ?>
<?php $this->view('direktur/profile/script'); ?>