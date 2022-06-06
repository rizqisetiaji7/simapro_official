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
		formModal.attr('action', 'update_profile');

		$.ajax({
			url: `<?= site_url('pm/profile/show_upload_profile_form') ?>`,
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
					url: `<?= site_url('pm/profile/remove_profile') ?>`,
					method: 'POST',
					dataType: 'json',
					cache: false,
					data: {
						unique_id: unique_id,
						user_profile: user_profile
					},
					success: function(data) {
						if (data.status == 'success') {
							window.location.reload();					
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
			url: `<?= site_url('pm/profile/') ?>${url}`,
			method: 'POST',
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			data: dataForm,
			beforeSend: function() {
				if (url == 'update_profile') {
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
</script>