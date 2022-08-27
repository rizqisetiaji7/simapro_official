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

    $(document).on('change', '#inputProfile', function() {
		if (this.files && this.files[0]) {
			// Get and display filename
			$('#profileFileName').removeClass('d-none');
			$('#profileFileName').addClass('mb-3').html(`<p class="mb-0 small text-muted">Gambar: <strong class="text-dark">${this.files[0].name}</strong></p>`);
		}
	});

    // Choose file from computer
	chooseFile('#chooseFileImage', '#inputProfile');

    // Edit Proyek
    function editProyek(proyekID) {
    	title.text('Edit Detail Proyek');
    	formModal.attr('action', `<?= site_url('direktur/proyek/edit') ?>`);

    	$.ajax({
    		url: `<?= site_url('direktur/proyek/form_edit') ?>`,
    		method: 'POST',
    		dataType: 'html',
    		cache: false,
    		data: {
    			project_code_ID: proyekID
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

    // Edit Status Proyek
    function editProjectStatus(project_code) {
		title.text('Ubah Status Proyek');
		formModal.attr('action', `<?= site_url('direktur/proyek/edit_status') ?>`);
		$.ajax({
			url: `<?= site_url('direktur/proyek/form_edit_status') ?>`,
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
		modal.modal({
    		show: true,
    		backdrop: 'static'
    	});
	}

    // CRUD Sub Proyek
	function add_subProject(project_id) {
		title.text('Tambah Sub-Proyek');
		formModal.attr('action', `<?= site_url('direktur/subproyek/tambah') ?>`);
		$.ajax({
			url: `<?= site_url('direktur/subproyek/form_tambah_subproyek') ?>`,
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

	function edit_subProject(project_id, subproject_id) {
		title.text('Edit Sub-Proyek');
		formModal.attr('action', `<?= site_url('direktur/subproyek/edit') ?>`);
		$.ajax({
			url: `<?= site_url('direktur/subproyek/form_edit_subproyek') ?>`,
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
	// 				url: `<?= site_url('direktur/subproyek/hapus') ?>`,
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

	// CRUD Sub-Elemen Proyek
	function add_subElemenProject(project_id, subproject_id) {
		title.text('Tambah List');
		formModal.attr('action', `<?= site_url('direktur/subelemen/tambah') ?>`);
		$.ajax({
			url: `<?= site_url('direktur/subelemen/form_tambah_subelemen') ?>`,
			dataType: 'html',
			method: 'POST',
			cache: false,
			data: {
				project_id: project_id,
				subproject_id: subproject_id
			},
			beforeSend: function() {
				modalBody.html(`<p class="text-secondary mb-0">Memuat konten...</p>`);
			},
			success: function(data) {
				modalBody.empty()
				modalBody.html(data);
			}
		});
		modal.modal({
			show: true,
			backdrop: 'static'
		});
	}

	function edit_subElemenProject(se_task_id, subproject_id) {
		title.text('Edit List');
		formModal.attr('action', `<?= site_url('direktur/subelemen/edit') ?>`);
		$.ajax({
			url: `<?= site_url('direktur/subelemen/form_edit_subelemen') ?>`,
			dataType: 'html',
			method: 'POST',
			cache: false,
			data: {
				subelemen_id: se_task_id,
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
	// 				url: `<?= site_url('direktur/subelemen/hapus') ?>`,
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
	function showPhoto(project_id, subproject_id='', project_name='') {
		title.html(`Dokumentasi Proyek: <span class="text-secondary small">${project_name}</span>`);
		modalDialog.addClass('modal-xl');
		modalFooter.addClass('d-none');
		$.ajax({
			url: `<?= site_url('direktur/foto/tampil_foto') ?>`,
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
			backdrop: 'static',
			show: true,
		});
	}

	/**
	 * ===============================================
	 * SHOW DATA PROJECT DESIGN / PROJECT DESIGN PHOTO
	 * ===============================================
	 */ 
	function showDesignProject(project_id, project_name='', photo_category=null) {
		title.html(`Desain Proyek: <span class="text-secondary small">${project_name}</span>`);
		modalDialog.addClass('modal-xl');
		modalFooter.addClass('d-none');

		$.ajax({
			url: `<?= site_url('direktur/proyek/tampil_foto_desain') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				project_id: project_id,
				project_name: project_name,
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

	/**
	 * =================================================
	 * DELETE DATA PROJECT DESIGN / PROJECT DESIGN PHOTO
	 * =================================================
	 */ 
	function deleteProjectDesign(photo_id, project_id='', project_name='', photo_url='', photo_category=null) {
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
     				url: `<?= site_url('direktur/foto/hapus_desain') ?>`,
					method: 'POST',
					dataType: 'json',
					cache: false,
					data: {
						photo_id: photo_id, 
						project_id: project_id, 
						project_name: project_name, 
						photo_url: photo_url, 
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
								showDesignProject(data.project_id, data.project_name, data.photo_category);
							});
						} else if (data.status == 'failed') {
							Swal.fire({
								icon: 'error',
								title: 'Gagal',
								text: `${data.message}`,
								showConfirmButton: false,
								timer: 2000,
							}).then((result) => {
								showDesignProject(data.project_id, data.project_name, data.photo_category);
							});
						}
					}
     			});
     		}
     	})
	}

	function finishProject(project_id) {
		Swal.fire({
			icon: 'warning',
			html: `
				<h4>Proyek telah selesai?</h4>
				<p class="text-muted">Status proyek otomatis akan dinyatakan selesai.</p>
				<p class="text-danger small">Pastikan periksa dokumentasi, Sub-proyek, maupun <br> list setiap tugas pekerjaan terlebih dahulu.</p>
			`,
			confirmButtonText: 'Proyek selesai',
			confirmButtonColor: '#28a745',
			showCancelButton: true,
			cancelButtonText: 'Batal'
     	}).then((result) => {
     		if (result.isConfirmed) {
     			$.ajax({
				url: `<?= site_url('direktur/proyek/proyek_selesai') ?>`,
				method: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					project_id: project_id
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
							window.location = data.redirect;
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