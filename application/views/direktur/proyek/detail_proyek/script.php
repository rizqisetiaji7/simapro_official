<script>
	const modal = $('#manageProjectModal');
  	const title = $('#manageProjectModalLabel');
   	const modalDialog = $('#manageProjectModal .modal-dialog');
   	const modalBody = $('#manageProjectModal .modal-body');
   	const formModal = $('#form_modal_manageProject');
   	const btnSubmit = $('#btnSubmit-manageProject');

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

    // Edit Proyek
    function editProyek(proyekID) {
    	title.text('Edit Detail Proyek');
    	formModal.attr('action', `<?= site_url('direktur/proyek/edit_detail_proyek') ?>`);

    	$.ajax({
    		url: `<?= site_url('direktur/proyek/form_edit_proyek') ?>`,
    		method: 'POST',
    		dataType: 'html',
    		cache: false,
    		data: {
    			project_code_ID: proyekID
    		},
    		success: function(data) {
    			modalBody.html(data);
    			modal.modal('show');
    		}
    	});
    }

    // CRUD Sub Proyek
	function add_subProject(project_id) {
		title.text('Tambah Sub-Proyek');
		formModal.attr('action', `<?= site_url('direktur/manajemen_proyek/tambah_subproyek') ?>`);
		$.ajax({
			url: `<?= site_url('direktur/manajemen_proyek/form_tambah_subproyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				project_id: project_id
			},
			success: function(data) {
				modalBody.html(data);
				modal.modal('show');
			}
		});
	}

	function edit_subProject(project_id, subproject_id) {
		title.text('Edit Sub-Proyek');
		formModal.attr('action', `<?= site_url('direktur/manajemen_proyek/edit_subproyek') ?>`);
		$.ajax({
			url: `<?= site_url('direktur/manajemen_proyek/form_edit_subproyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				project_id: project_id,
				subproject_id: subproject_id
			},
			success: function(data) {
				modalBody.html(data);
				modal.modal('show');
			}
		});
	}

	// CRUD Sub-Elemen Proyek
	function add_subElemenProject(subproject_id) {
		title.text('Tambah Sub-Elemen Proyek');
		formModal.attr('action', `<?= site_url('direktur/manajemen_proyek/tambah_subelemen_proyek') ?>`);
		$.ajax({
			url: `<?= site_url('direktur/manajemen_proyek/form_tambah_subelemen_proyek') ?>`,
			dataType: 'html',
			method: 'POST',
			cache: false,
			data: {subproject_id: subproject_id},
			success: function(data) {
				modalBody.html(data);
				modal.modal('show');
			}
		});
	}

	function edit_subElemenProject(se_task_id, subproject_id) {
		title.text('Edit Sub-Elemen Proyek');
		formModal.attr('action', `<?= site_url('direktur/manajemen_proyek/edit_subelemen_proyek') ?>`);
		$.ajax({
			url: `<?= site_url('direktur/manajemen_proyek/form_edit_subelemen_proyek') ?>`,
			dataType: 'html',
			method: 'POST',
			cache: false,
			data: {
				subelemen_id: se_task_id,
				subproject_id: subproject_id
			},
			success: function(data) {
				modalBody.html(data);
				modal.modal('show');
			}
		});
	}

	// function hapus_subElProject(task_type) {

	// }

	function hapus_subElProject(task_type, id_sub = '') {
		let task_name = task_type == 'subproject' ? 'Sub-Proyek' : 'Sub-Elemen Proyek' ;
		Swal.fire({
			icon: 'warning',
			title: `Hapus ${task_name}`,
			text: `Yakin akan menghapus?`,
			confirmButtonText: 'Ya, Hapus',
			showCancelButton: true,
			cancelButtonText: 'Batal'
     	}).then((result) => {
      	if (result.isConfirmed) {
   			// $.ajax({
			// 	url: `<?= site_url('direktur/manajemen_proyek/hapus') ?>`,
			// 	method: 'POST',
			// 	dataType: 'json',
			// 	cache: false,
			// 	data: {
			// 		task_type: task_type,
			// 		id_sub: is_sub
			// 	},
			// 	success: function(data) {
			// 		if (data.status == 'success') {
			// 			window.location.reload();					
			// 		} else if (data.status == 'failed') {
			// 			Swal.fire({
			//             icon: 'error',
			//             title: 'Gagal',
			//             text: `${data.message}`,
			//             showConfirmButton: false,
			//             timer: 2000,
			//          }).then((result) => {
			//          	window.location.reload();
			//          });
			// 		}
			// 	}
			// });
			alert('Terhapus!');
      	}
      });
	}

	$(document).on('change', '#inputProfile', function() {
		if (this.files && this.files[0]) {
			// Get and display filename
			$('#profileFileName').removeClass('d-none');
			$('#profileFileName').addClass('mb-3').html(`<p class="mb-0 small text-muted">Gambar: <strong class="text-dark">${this.files[0].name}</strong></p>`);
		}
	});

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

	modal.on('hidden.bs.modal', function() {
		title.empty();
		modalDialog.removeClass('modal-lg');
		modalBody.empty();
		formModal.removeAttr('action');
		btnSubmit.text('Simpan');
	});
</script>