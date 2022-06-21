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
		formModal.attr('action', `<?= site_url('pm/manajemen_proyek/edit_proyek') ?>`);
		$.ajax({
			url: `<?= site_url('pm/proyek/tampil_form_edit_proyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {project_code_ID: project_code},
			beforeSend: function() {
				modalBody.html('<p>Memuat konten...</p>');
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
				modalBody.html(`<p class="text-secondary">Memuat konten...</p>`);
			},
			success: function(data) {
				modalBody.empty();
				modalBody.html(data);
			}
		});
		modal.modal('show');
	}

	// SHOW PHOTO DOCUMENTATION PROJECT
	function showDocProject(project_id, project_name) {
		title.html(`Dokumentasi Proyek: <span class="text-secondary small">${project_name}</span>`);
		modalDialog.addClass('modal-xl');
		modalFooter.addClass('d-none');
		$.ajax({
			url: `<?= site_url('pm/proyek/tampil_foto_proyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				project_id: project_id,
				proj_name: project_name
			},
			beforeSend: function() {
				modalBody.html('<p>Memuat konten...</p>');
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

	// SHOW PHOTO DOCUMENTATION SUB-PROJECT
	function showDocSubproject(project_id, subproject_id, subproject_name) {
		title.html(`Dokumentasi Proyek: <span class="text-secondary small">${subproject_name}</span>`);
		modalDialog.addClass('modal-xl');
		modalFooter.addClass('d-none');

		$.ajax({
			url: `<?= site_url('pm/proyek/tampil_foto_subproyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				project_id: project_id,
				subproject_id: subproject_id,
				proj_name: subproject_name
			},
			beforeSend: function() {
				modalBody.html('<p>Memuat konten...</p>');
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

	// ADD SUB-PROJECT
	function add_subProject(project_id) {
		title.text('Tambah Sub-Proyek');
		formModal.attr('action', `<?= site_url('pm/manajemen_proyek/tambah_subproyek') ?>`);
		$.ajax({
			url: `<?= site_url('pm/proyek/tampil_form_tambah_subproyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {project_id: project_id},
			beforeSend: function() {
				modalBody.html('<p>Memuat konten...</p>');
			},
			success: function(data) {
				modalBody.empty();
				modalBody.html(data);
			}
		});
		modal.modal('show');
	}

	// EDIT SUB-PROJECT
	function edit_subProject(project_id, subproject_id) {
		title.text('Edit data Sub-Proyek');
		formModal.attr('action', `<?= site_url('pm/manajemen_proyek/edit_subproyek') ?>`);
		$.ajax({
			url: `<?= site_url('pm/proyek/tampil_form_edit_subproyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				project_id: project_id,
				subproject_id: subproject_id
			},
			beforeSend: function() {
				modalBody.html('<p>Memuat konten...</p>');
			},
			success: function(data) {
				modalBody.empty();
				modalBody.html(data);
			}
		});
		modal.modal('show');
	}

	// ADD SUB-ELEMENT / Task Lists
	function add_subElemenProject(subproject_id) {
		title.text('Tambah List');
		formModal.attr('action', `<?= site_url('pm/manajemen_proyek/tambah_subelemen_proyek') ?>`);
		$.ajax({
			url: `<?= site_url('pm/proyek/form_tambah_subelemen_proyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				subproject_id: subproject_id
			},
			beforeSend: function() {
				modalBody.html('<p>Memuat konten...</p>');
			},
			success: function(data) {
				modalBody.empty();
				modalBody.html(data);
			}
		});
		modal.modal('show');
	}

	// EDIT SUB-ELEMENT / Task Lists
	function edit_subElemenProject(task_id, subproject_id) {
		title.text('Edit List');
		formModal.attr('action', `<?= site_url('pm/manajemen_proyek/edit_subelemen_proyek') ?>`);
		$.ajax({
			url: `<?= site_url('pm/proyek/form_edit_subelemen_proyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				task_id: task_id,
				subproject_id: subproject_id
			},
			beforeSend: function() {
				modalBody.html('<p>Memuat konten...</p>');
			},
			success: function(data) {
				modalBody.empty();
				modalBody.html(data);
			}
		});
		modal.modal('show');
	}

	// DELETE SUBPROYEK / SUB-ELEMENT PROJECT
	function delete_subElProject(task_type, subid, project_id) {
		let task_name = task_type == 'subproject' ? 'Sub-Proyek' : 'Sub-Elemen Proyek' ;
		let textFill = task_type == 'subproject' ? 'Data Subproyek akan terhapus beserta Sub-elemennya' : 'Anda akan menghapus Sub-elemen Proyek.' ;
		Swal.fire({
			icon: 'warning',
			title: `Hapus ${task_name}`,
			text: textFill,
			confirmButtonText: 'Ya, Hapus',
			showCancelButton: true,
			cancelButtonText: 'Batal'
     	}).then((result) => {
     		if (result.isConfirmed) {
     			$.ajax({
					url: `<?= site_url('pm/manajemen_proyek/hapus') ?>`,
					method: 'POST',
					dataType: 'json',
					cache: false,
					data: {
						task_type: task_type,
						id_sub: subid,
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

	function delete_photo_project(photo_id, project_id, photo_url, proj_name) {
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
					url: `<?= site_url('pm/manajemen_proyek/hapus_foto_proyek') ?>`,
					method: 'POST',
					dataType: 'json',
					cache: false,
					data: {
						photo_id: photo_id,
						photo_url: photo_url,
						project_id: project_id,
						proj_name: proj_name
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
								showDocProject(project_id, proj_name);
							});		
						} else if (data.status == 'failed') {
							Swal.fire({
								icon: 'error',
								title: 'Gagal',
								text: `${data.message}`,
								showConfirmButton: false,
								timer: 2000,
							}).then((result) => {
								showDocProject(project_id, proj_name);
							});
						}
					}
				});
     		}
     	});
	}

	function delete_photo_subproject(photo_id, project_id, subproject_id, photo_url, proj_name) {
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
					url: `<?= site_url('pm/manajemen_proyek/hapus_foto_subproyek') ?>`,
					method: 'POST',
					dataType: 'json',
					cache: false,
					data: {
						photo_id: photo_id,
						project_id: project_id,
						subproject_id: subproject_id,
						photo_url: photo_url,
						proj_name: proj_name
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
								showDocSubproject(project_id, subproject_id, proj_name);
							});		
						} else if (data.status == 'failed') {
							Swal.fire({
								icon: 'error',
								title: 'Gagal',
								text: `${data.message}`,
								showConfirmButton: false,
								timer: 2000,
							}).then((result) => {
								showDocSubproject(project_id, subproject_id, proj_name);
							});
						}
					}
				});
     		}
     	});
	}

	// function finishProject(projectId) {
	// 	Swal.fire({
	// 		icon: 'warning',
	// 		html: `
	// 			<h4>Proyek telah selesai?</h4>
	// 			<p class="text-muted">Status proyek otomatis akan dinyatakan selesai.</p>
	// 			<p class="text-danger small">Pastikan periksa dokumentasi, Sub-proyek, maupun <br> list setiap tugas pekerjaan terlebih dahulu.</p>
	// 		`,
	// 		confirmButtonText: 'Proyek selesai',
	// 		confirmButtonColor: '#28a745',
	// 		showCancelButton: true,
	// 		cancelButtonText: 'Batal'
 //     	}).then((result) => {
 //     		if (result.isConfirmed) {
 //     			alert(`Action to : <?= site_url('pm/manajemen_proyek/proyek_selesai') ?>`);
 //     		}
 //     	});
	// }

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