<script>
	const modal = $('#manageProjectModal');
  	const title = $('#manageProjectModalLabel');
	const modalDialog = $('#manageProjectModal .modal-dialog');
	const modalBody = $('#manageProjectModal .modal-body');
	const formModal = $('#form_modal_manageProject');
	const btnSubmit = $('#btnSubmit-manageProject');
	const modalFooter = $('#manageProjectModal .modal-footer');

	$(document).on('keyup', '.form-control', function(e) {
        $(this).removeClass('is-invalid');
        $(this).next().html('');
    });

    $(document).on('change', '.formSelect', function(e) {
        $(this).removeClass('is-invalid');
        $(this).next().html('');
    });

    // Choose file from computer
	chooseFile('#chooseFileImage', '#inputProfile');

	$(document).on('change', '#inputProfile', function() {
		if (this.files && this.files[0]) {
			// Get and display filename
			$('#profileFileName').removeClass('d-none');
			$('#profileFileName').addClass('mb-3').html(`<p class="mb-0 small text-muted">Gambar: <strong class="text-dark">${this.files[0].name}</strong></p>`);
		}
	});

	// EDIT PROJECT
	function editProyek(project_code) {
		title.text('Edit Detail Proyek');
		formModal.attr('action', `<?= site_url('pm/proyek/edit_proyek') ?>`);
		$.ajax({
			url: `<?= site_url('pm/proyek/tampil_form_edit_proyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {project_code_ID: project_code},
			beforeSend: function() {
				modalBody.html(`<p class="text-secondary mb-0">Memuat konten...</p>`);
			},
			success: function(data) {
				modalBody.empty();
				modalBody.html(data);
			}
		});
		modal.modal('show');
	}

	// EDIT PROJECT STATUS
	function editProjectStatus(project_code) {
		title.text('Ubah Status Proyek');
		formModal.attr('action', `<?= site_url('pm/proyek/update_status_proyek') ?>`);
		$.ajax({
			url: `<?= site_url('pm/proyek/form_update_status') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: { project_code: project_code },
			beforeSend: function() {
				modalBody.html(`<p class="text-secondary mb-0">Memuat konten...</p>`);
			},
			success: function(data) {
				modalBody.empty();
				modalBody.html(data);
			}
		});
		modal.modal('show');
	}

	// ADD SUB-PROJECT
	function add_subProject(project_id) {
		title.text('Tambah Sub-Proyek');
		formModal.attr('action', `<?= site_url('pm/subproyek/tambah') ?>`);
		$.ajax({
			url: `<?= site_url('pm/subproyek/form_tambah_subproyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {project_id: project_id},
			beforeSend: function() {
				modalBody.html(`<p class="text-secondary mb-0">Memuat konten...</p>`);
			},
			success: function(data) {
				modalBody.empty();
				modalBody.html(data);
			}
		});
		modal.modal({
			show: true,
			backdrop: 'static'
		});
	}

	// EDIT SUB-PROJECT
	function edit_subProject(project_id, subproject_id) {
		title.text('Edit data Sub-Proyek');
		formModal.attr('action', `<?= site_url('pm/subproyek/edit') ?>`);
		$.ajax({
			url: `<?= site_url('pm/subproyek/form_edit_subproyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				project_id: project_id,
				subproject_id: subproject_id
			},
			beforeSend: function() {
				modalBody.html(`<p class="text-secondary mb-0">Memuat konten...</p>`);
			},
			success: function(data) {
				modalBody.empty();
				modalBody.html(data);
			}
		});
		modal.modal({
			show: true,
			backdrop: 'static'
		});
	}

	// DELETE SUB-PROJECT
	// function delete_subProject(subproject_id, project_id) {
	// 	Swal.fire({
	// 		icon: 'warning',
	// 		title: 'Hapus Sub-Proyek?',
	// 		text: 'Anda akan menghapus Sub-Proyek.',
	// 		confirmButtonText: 'Ya, Hapus',
	// 		showCancelButton: true,
	// 		cancelButtonText: 'Batal'
 //     	}).then((res) => {
 //     		if (res.isConfirmed) {
 //     			$.ajax({
	// 				url: `<?= site_url('pm/subproyek/hapus') ?>`,
	// 				method: 'POST',
	// 				dataType: 'json',
	// 				cache: false,
	// 				data: {
	// 					subproject_id: subproject_id,
	// 					project_id: project_id
	// 				},
	// 				success: function(data) {
	// 					if (data.status == 'success') {
	// 						Swal.fire({
	// 							icon: 'success',
	// 							title: 'Berhasil',
	// 							text: `${data.message}`,
	// 							showConfirmButton: false,
	// 							timer: 2000,
	// 						}).then((result) => {
	// 							window.location.reload();
	// 						});
	// 					} else if (data.status == 'failed') {
	// 						Swal.fire({
	// 							icon: 'error',
	// 							title: 'Gagal',
	// 							text: `${data.message}`,
	// 							showConfirmButton: false,
	// 							timer: 2000,
	// 						}).then((result) => {
	// 							window.location.reload();
	// 						});
	// 					}
	// 				}
	// 			});
 //     		}
 //     	});
	// }

	// ADD SUB-ELEMENT / Task Lists
	function add_subElemenProject(project_id, subproject_id) {
		title.text('Tambah List');
		formModal.attr('action', `<?= site_url('pm/subelemen/tambah') ?>`);
		$.ajax({
			url: `<?= site_url('pm/subelemen/form_tambah_subelemen') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				project_id: project_id,
				subproject_id: subproject_id
			},
			beforeSend: function() {
				modalBody.html(`<p class="text-secondary mb-0">Memuat konten...</p>`);
			},
			success: function(data) {
				modalBody.empty();
				modalBody.html(data);
			}
		});
		modal.modal({
			show: true,
			backdrop: 'static'
		});
	}

	// EDIT SUB-ELEMENT / Task Lists
	function edit_subElemenProject(task_id, subproject_id, project_id) {
		title.text('Edit List');
		formModal.attr('action', `<?= site_url('pm/subelemen/edit') ?>`);
		$.ajax({
			url: `<?= site_url('pm/subelemen/form_edit_subelemen') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				task_id: task_id,
				subproject_id: subproject_id,
				project_id: project_id
			},
			beforeSend: function() {
				modalBody.html(`<p class="text-secondary mb-0">Memuat konten...</p>`);
			},
			success: function(data) {
				modalBody.empty();
				modalBody.html(data);
			}
		});
		modal.modal({
			show: true,
			backdrop: 'static'
		});
	}

	// function deleteSubelemen(subelemen_id, subproject_id, project_id) {
	// 	Swal.fire({
	// 		icon: 'warning',
	// 		title: 'Hapus Sub-Elemen Proyek?',
	// 		text: 'Anda akan menghapus Sub-elemen Proyek.',
	// 		confirmButtonText: 'Ya, Hapus',
	// 		showCancelButton: true,
	// 		cancelButtonText: 'Batal'
 //     	}).then((res) => {
 //     		if (res.isConfirmed) {
 //     			$.ajax({
	// 				url: `<?= site_url('pm/subelemen/hapus') ?>`,
	// 				method: 'POST',
	// 				dataType: 'json',
	// 				cache: false,
	// 				data: {
	// 					subelemen_id: subelemen_id,
	// 					subproject_id: subproject_id,
	// 					project_id: project_id
	// 				},
	// 				success: function(data) {
	// 					if (data.status == 'success') {
	// 						Swal.fire({
	// 							icon: 'success',
	// 							title: 'Berhasil',
	// 							text: `${data.message}`,
	// 							showConfirmButton: false,
	// 							timer: 2000,
	// 						}).then((result) => {
	// 							window.location.reload();
	// 						});
	// 					} else if (data.status == 'failed') {
	// 						Swal.fire({
	// 							icon: 'error',
	// 							title: 'Gagal',
	// 							text: `${data.message}`,
	// 							showConfirmButton: false,
	// 							timer: 2000,
	// 						}).then((result) => {
	// 							window.location.reload();
	// 						});
	// 					}
	// 				}
	// 			});
 //     		}
 //     	});
	// }

	// SHOW PHOTO DOCUMENTATION PROJECT / SUB-PROJECT
	function showPhoto(project_id, subproject_id='', project_name, project_status='', proj_type='', photo_category=null) {
		title.html(`Dokumentasi Proyek: <span class="text-secondary small">${project_name}</span>`);
		modalDialog.addClass('modal-xl');
		modalFooter.addClass('d-none');
		$.ajax({
			url: `<?= site_url('pm/foto/tampil_foto') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				project_id: project_id,
				subproject_id: subproject_id,
				proj_name: project_name,
				project_status: project_status,
				proj_type: proj_type,
				photo_category: photo_category
			},
			beforeSend: function() {
				modalBody.html(`<p class="text-secondary mb-0">Memuat konten...</p>`);
			},
			success: function(data) {
				modalBody.empty();
				modalBody.html(data);
			}
		});
		modal.modal({
			backdrop: 'static',
			show: true,
		});
	}

	// DELETE PHOTO PROJECT / SUB-PROJECT
	function delete_photo(photo_id, project_id, subproject_id='', photo_url, proj_name, proj_type='', proj_status='', photo_category=null) {
		Swal.fire({
			icon: 'warning',
			html: `
				<h3>Hapus Foto</h3>
				<p class="text-secondary">Anda akan menghapus foto ini?</p>
			`,
			confirmButtonText: 'Ya, Hapus',
			showCancelButton: true,
			cancelButtonText: 'Batal'
     	}).then((result) => {
     		if (result.isConfirmed) {
     			$.ajax({
					url: `<?= site_url('pm/foto/hapus') ?>`,
					method: 'POST',
					dataType: 'json',
					cache: false,
					data: {
						photo_id: photo_id,
						project_id: project_id,
						subproject_id: subproject_id,
						photo_url: photo_url,
						proj_name: proj_name,
						proj_type: proj_type,
						photo_category: photo_category
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
								if (data.proj_type == 'proyek') {
									showPhoto(project_id, '', proj_name);
								} else {
									showPhoto(project_id, subproject_id, proj_name);
								}
							});		
						} else if (data.status == 'failed') {
							Swal.fire({
								icon: 'error',
								title: 'Gagal',
								text: `${data.message}`,
								showConfirmButton: false,
								timer: 2000,
							}).then((result) => {
								if (data.proj_type == 'proyek') {
									showPhoto(project_id, '', proj_name);
								} else {
									showPhoto(project_id, subproject_id, proj_name);
								}
							});
						}
					}
				});
     		}
     	});
	}
	
	function sendReview(project_id, ID_pm, ID_company) {
		Swal.fire({
			icon: 'warning',
			html: `
				<h4>Tinjau proyek?</h4>
				<p class="text-muted">Proyek otomatis akan segera ditinjau oleh direktur.</p>
				<p class="text-danger small">Pastikan periksa dokumentasi, Sub-proyek, maupun <br> list setiap tugas pekerjaan terlebih dahulu.</p>
			`,
			confirmButtonText: 'Ya, Tinjau sekarang!',
			confirmButtonColor: '#28a745',
			showCancelButton: true,
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: `<?= site_url('pm/proyek/tinjau_proyek') ?>`,
					dataType: 'json',
					method: 'POST',
					cache: false,
					data: {
						project_id: project_id,
						ID_pm: ID_pm,
						ID_company: ID_company
					},
					success: function(data) {
						console.log(data);
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
						} else if (data.status == 'failed'){
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

	function set_data_chat(from_user, to_user, project_id) {
		$.ajax({
			url: `<?= site_url('chat') ?>`,
			method: 'POST',
			dataType: 'json',
			cache: false,
			data: {
				from_user: from_user,
				to_user: to_user,
				project_id: project_id
			},
			success: function(data) {
				if (data.status == 'failed') {
					Swal.fire({
						icon: 'error',
						title: 'Pesan Gagal',
						text: `${data.message}`,
						showConfirmButton: false,
						timer: 2000
					});
				} else if (data.status == 'success') {
					window.location = data.redirect;
				}
			}
		});
	}

	// Submit Data
	formModal.on('submit', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: 'POST',
			dataType: 'json',
			processData: false,
			contentType: false,
			cache: false,
			data: new FormData(this),
			beforeSend: function() {
				btnSubmit.attr('disabled', true).text('Memproses...');
			},
			complete: function() {
				btnSubmit.attr('disabled', false).text('Simpan');
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

	modal.on('hidden.bs.modal', function() {
		title.empty();
		modalDialog.removeClass('modal-lg');
		modalDialog.removeClass('modal-xl');
		modalBody.empty();
		modalFooter.removeClass('d-none');
		formModal.removeAttr('action');
		btnSubmit.text('Simpan');
	});
</script>