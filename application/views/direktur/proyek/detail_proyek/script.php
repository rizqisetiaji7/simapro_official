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

    // CRUD Sub Proyek
	
	function add_subProject() {
		title.text('Tambah Sub-Proyek');
		formModal.attr('action', `<?= site_url('direktur/manajemen_proyek/tambah_subproyek') ?>`);
		$.ajax({
			url: `<?= site_url('direktur/manajemen_proyek/form_tambah_subproyek') ?>`,
			dataType: 'html',
			cache: false,
			success: function(data) {
				modalBody.html(data);
				modal.modal('show');
			}
		});
	}

	function edit_subProject() {
		title.text('Edit Sub-Proyek');
		formModal.attr('action', `<?= site_url('direktur/manajemen_proyek/edit_subproyek') ?>`);
		$.ajax({
			url: `<?= site_url('direktur/manajemen_proyek/form_edit_subproyek') ?>`,
			dataType: 'html',
			cache: false,
			success: function(data) {
				modalBody.html(data);
				modal.modal('show');
			}
		});
	}

	// CRUD Sub-Elemen Proyek
	function add_subElemenProject() {
		title.text('Tambah Sub-Elemen Proyek');
		formModal.attr('action', `<?= site_url('direktur/manajemen_proyek/tambah_subelemen_proyek') ?>`);
		$.ajax({
			url: `<?= site_url('direktur/manajemen_proyek/form_tambah_subelemen_proyek') ?>`,
			dataType: 'html',
			cache: false,
			success: function(data) {
				modalBody.html(data);
				modal.modal('show');
			}
		});
	}

	function edit_subElemenProject() {
		title.text('Edit Sub-Elemen Proyek');
		formModal.attr('action', `<?= site_url('direktur/manajemen_proyek/edit_subelemen_proyek') ?>`);
		$.ajax({
			url: `<?= site_url('direktur/manajemen_proyek/form_edit_subelemen_proyek') ?>`,
			dataType: 'html',
			cache: false,
			success: function(data) {
				modalBody.html(data);
				modal.modal('show');
			}
		});
	}

	function hapus_subElProject(task_type) {

	}

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

	modal.on('hidden.bs.modal', function() {
		title.empty();
		modalDialog.removeClass('modal-lg');
		modalBody.empty();
		formModal.removeAttr('action');
		btnSubmit.text('Simpan');
		hiddenId.removeAttr('value');
	});
</script>