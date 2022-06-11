<script>
	const modal = $('#modalProfile');
	const title = $('#modalProfileTitle');
	const modalDialog = $('#modalProfile .modal-dialog');
	const modalHeader = $('#modalProfile .modal-header');
	const modalBody = $('#modalProfile .modal-body');
	const modalFooter = $('#modalProfile .modal-footer');
	const formModal = $('#form_modal_profile');
	const btnSubmit = $('#btnProfile-submit');

	$(document).on('keyup', '.form-control', function(e) {
		$(this).removeClass('is-invalid');
		$(this).next().html('');
	});
	
	// Profile CRUD
	function uploadProfile(unique_id, user_role) {
		modalHeader.addClass('d-none');
		modalFooter.addClass('d-none');
		formModal.attr('action', 'upload_foto_profile');

		$.ajax({
			url: `<?= site_url('direktur/profile/show_upload_profile_form') ?>`,
			method: 'POST',
			dataType: 'html',
			data: {
				unique_id: unique_id,
				user_role: user_role
			},
			success: function(data) {
				modalBody.html(data);
				modal.modal('show');
			}
		});
	}

	// Choose file from computer
	chooseFile('#chooseFileImage', '#inputProfile');

	// Remove Profile Picture
	function removeProfile(unique_id, user_profile) {
		Swal.fire({
         icon: 'warning',
         title: 'Hapus profile',
         text: `Yakin akan menghapus foto profie?`,
         confirmButtonText: 'Ya, Hapus',
         // confirmButtonColor: '#f31a69',
         showCancelButton: true,
         cancelButtonText: 'Batal'
      }).then((result) => {
      	if (result.isConfirmed) {
      		$.ajax({
					url: `<?= site_url('direktur/profile/hapus_foto_profile') ?>`,
					method: 'POST',
					dataType: 'json',
					cache: false,
					data: {
						unique_id: unique_id,
						user_profile: user_profile
					},
					success: function(data) {
						if (data.status == 'success') {
							Swal.fire({
				            icon: 'success',
				            title: 'Berhasil',
				            text: `${data.message}`,
				            showConfirmButton: false,
				            timer: 2000,
				         }).then((result) => {
				         	window.location.reload();
				         });					
						} else if (data.status == 'failed') {
							Swal.fire({
				            icon: 'error',
				            title: 'Gagal',
				            text: `${data.message}`,
				            showConfirmButton: false,
				            timer: 2000,
				         }).then((result) => {
				         	window.location.reload();
				         });
						}
					}
				});
      	}
      });
	}

	// Update Profile Data
	$(document).on('submit', '#editProfileData', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: 'POST',
			dataType: 'json',
			cache: false,
			data: $(this).serialize(),
			beforeSend: function() {
				$('#btnUpdate-profileData').attr('disabled', true).text('Loading...')
			},
			complete: function() {
				$('#btnUpdate-profileData').attr('disabled', false).text('Update Profile')
			},
			success: function(data) {
				if (data.status == 'validation_error') {
					for (let i = 0; i < data.message.length; i++) {
						if (data.message[i].err_message == '') {
							$(`[name="${data.message[i].field}"]`).removeClass('is-invalid');
		            	$(`[name="${data.message[i].field}"]`).next().html('');
						} else {
							$(`[name="${data.message[i].field}"]`).addClass('is-invalid');
		            	$(`[name="${data.message[i].field}"]`).next().html(data.message[i].err_message);
						}
					}
				} else if (data.status == 'success') {
					Swal.fire({
		            icon: 'success',
		            title: 'Berhasil',
		            text: `${data.message}`,
		            showConfirmButton: false,
		            timer: 2000,
		         }).then((result) => {
		         	window.location.reload();
		         });
				}
			}
		});
	});

	// Update new password
	$(document).on('submit', '#editPassword', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: 'POST',
			dataType: 'json',
			cache: false,
			data: $(this).serialize(),
			beforeSend: function() {
				$('#btnUpdate-password').attr('disabled', true).text('Loading...')
			},
			complete: function() {
				$('#btnUpdate-password').attr('disabled', false).text('Update password')
			},
			success: function(data) {
				if (data.status == 'validation_error') {
					for (let i = 0; i < data.message.length; i++) {
						if (data.message[i].err_message == '') {
							$(`[name="${data.message[i].field}"]`).removeClass('is-invalid');
		            	$(`[name="${data.message[i].field}"]`).next().html('');
						} else {
							$(`[name="${data.message[i].field}"]`).addClass('is-invalid');
		            	$(`[name="${data.message[i].field}"]`).next().html(data.message[i].err_message);
						}
					}
				} else if (data.status == 'success') {
					Swal.fire({
		            icon: 'success',
		            title: 'Berhasil',
		            text: `${data.message}`,
		            showConfirmButton: false,
		            timer: 2000,
		         }).then((result) => {
		         	window.location.reload();
		         });
				}
			}
		});
	});

	$(document).on('change', '#inputProfile', function() {
		if (this.files && this.files[0]) {
			// Get and display filename
			$('#profileFileName').removeClass('d-none');
			$('#profileFileName').addClass('mb-3').html(`<p class="mb-0 small text-muted">Gambar: <strong class="text-dark">${this.files[0].name}</strong></p>`);
			$('#btnSubmitProfile').removeClass('btn-secondary').removeAttr('disabled');
			$('#btnSubmitProfile').addClass('btn-custom');
		}
	});

	formModal.on('submit', function(e) {
		e.preventDefault();
		let url = $(this).attr('action');
		let dataForm = new FormData(this);

		$.ajax({
			url: `<?= site_url('direktur/profile/') ?>${url}`,
			method: 'POST',
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			data: dataForm,
			beforeSend: function() {
				if (url == 'upload_foto_profile') {
					$('#btnSubmitProfile').attr('disabled', true).text('Mengunggah...');
				}
			},
			complete: function() {
				if(url == 'update_profile') {
					$('#btnSubmitProfile').attr('disabled', true).text('Upload');
					$('#btnSubmitProfile').removeClass('btn-custom');
					$('#btnSubmitProfile').addClass('btn-secondary');
					$('#form_modal_profile')[0].reset();
					$('#profileFileName').addClass('d-none').empty();
				}
			},
			success: function(data) {
				modal.modal('hide');
				if (data.status == 'success') {
					Swal.fire({
		            icon: 'success',
		            title: 'Berhasil',
		            text: `${data.message}`,
		            showConfirmButton: false,
		            timer: 2000,
		         }).then((result) => {
		         	window.location.reload();
		         });				
				} else if (data.status == 'failed') {
					Swal.fire({
		            icon: 'error',
		            title: 'Gagal',
		            text: `${data.message}`,
		            showConfirmButton: false,
		            timer: 2000,
		         }).then((result) => {
		         	window.location.reload();
		         });
				}
			}
		});
	});

	modal.on('hidden.bs.modal', function() {
		title.empty();
		modalDialog.removeClass('modal-lg');
		modalBody.empty();
		formModal.removeAttr('action');
		btnSubmit.text('Simpan');
		modalHeader.removeClass('d-none');
		modalFooter.removeClass('d-none');
   });


	/*====================*/ 
	/* Company Profile */
	/*====================*/ 
	const modalLogo = $('#modalUploadLogo');
	const formModalLogo = $('#form_modalLogo');
	const modalLogoBody = $('#form_modalLogo .modal-body');

	// Choose file from computer
	chooseFile('#chooseLogoImage', '#inputLogo');

	$(document).on('change', '#inputLogo', function() {
		if (this.files && this.files[0]) {
			// Get and display filename
			$('#profileFileName').removeClass('d-none');
			$('#profileFileName').addClass('mb-3').html(`<p class="mb-0 small text-muted">Gambar: <strong class="text-dark">${this.files[0].name}</strong></p>`);
			$('#btnSubmitLogo').removeClass('btn-secondary').removeAttr('disabled');
			$('#btnSubmitLogo').addClass('btn-custom');
		}
	});

	// Edit Data Company Profile
	$('#editProfilePerusahaan').on('submit', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: 'POST',
			dataType: 'json',
			cache: false,
			data: $(this).serialize(),
			beforeSend: function() {
				$('#btnUpdate-Perusahaan').attr('disabled', true).text('Memproses...');
			},
			complete: function() {
				$('#btnUpdate-Perusahaan').attr('disabled', false).text('Update');
			},
			success: function(data) {
				// console.log(data);
				if (data.status == 'validation_error') {
					for (let i = 0; i < data.message.length; i++) {
						if (data.message[i].err_message == '') {
							$(`[name="${data.message[i].field}"]`).removeClass('is-invalid');
		            	$(`[name="${data.message[i].field}"]`).next().html('');
						} else {
							$(`[name="${data.message[i].field}"]`).addClass('is-invalid');
		            	$(`[name="${data.message[i].field}"]`).next().html(data.message[i].err_message);
						}
					}
				} else if (data.status == 'success') {
					modal.modal('hide');
					Swal.fire({
		            icon: 'success',
		            title: 'Berhasil',
		            text: `${data.message}`,
		            showConfirmButton: false,
		            timer: 2000,
		         }).then((result) => {
		         	window.location.reload();
		         });
				} else {
					modal.modal('hide');
					Swal.fire({
		            icon: 'error',
		            title: 'Gagal',
		            text: `${data.message}`,
		            showConfirmButton: false,
		            timer: 2000,
		         }).then((result) => {
		         	window.location.reload();
		         });
				}
			}
		});
	});

	// Show Modal Upload Logo
	function uploadLogo(comp_code) {
		formModalLogo.attr('action', `<?= site_url('direktur/perusahaan/upload_logo_company') ?>`);
		$.ajax({
			url: `<?= site_url('direktur/perusahaan/upload_form_logo') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				company_code: comp_code
			},
			success: function(data) {
				modalLogoBody.html(data);
				modalLogo.modal('show');
			}
		});
	}

	// Submit Logo Upload
	formModalLogo.on('submit', function(e) {
		e.preventDefault();
		let url = $(this).attr('action');
		let dataForm = new FormData(this);
		$.ajax({
			url: url,
			method: 'POST',
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			data: dataForm,
			beforeSend: function() {
				$('#btnSubmitLogo').attr('disabled', true).text('Mengunggah...');
			},
			complete: function() {
				$('#btnSubmitLogo').attr('disabled', true).text('Upload');
				$('#btnSubmitLogo').removeClass('btn-custom');
				$('#btnSubmitLogo').addClass('btn-secondary');
				$('#form_modalLogo')[0].reset();
				$('#profileFileName').addClass('d-none').empty();
			},
			success: function(data) {
				console.log(data);
				modalLogo.modal('hide');
			}
		});
	});

   modalLogo.on('hidden.bs.modal', function() {
   	modalLogoBody.empty();
   	formModalLogo.removeAttr('action');
   });
</script>