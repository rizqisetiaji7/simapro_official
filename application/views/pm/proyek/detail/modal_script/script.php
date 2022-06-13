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
	function editProyek() {
		title.text('Edit Detail Proyek');
		formModal.attr('action', `<?= site_url('pm/manajemen_proyek/edit_proyek') ?>`);
		$.ajax({
			url: `<?= site_url('pm/proyek/tampil_form_edit_proyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			// data: {},
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
	function editProjectStatus() {
		title.text('Edit Status Proyek');
		formModal.attr('action', `<?= site_url('pm/manajemen_proyek/edit_status_proyek') ?>`);
		$.ajax({
			url: `<?= site_url('pm/proyek/tampil_form_edit_status_proyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			// data: {},
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

	// SHOW PHOTO DOCUMENTATION PROJECT
	function showDocProject() {
		title.html(`Dokumentasi Proyek: <span class="text-secondary small">Nama Proyek</span>`);
		modalDialog.addClass('modal-lg');
		modalFooter.addClass('d-none');
		$.ajax({
			url: `<?= site_url('pm/proyek/tampil_foto_proyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			// data: {},
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

	// SHOW PHOTO DOCUMENTATION SUB-PROJECT
	function showDocSubproject() {
		title.html(`Dokumentasi Proyek: <span class="text-secondary small">Nama Subproyek</span>`);
		modalDialog.addClass('modal-lg');
		modalFooter.addClass('d-none');
		$.ajax({
			url: `<?= site_url('pm/proyek/tampil_foto_subproyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			// data: {},
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

	// ADD SUB-PROJECT
	function add_subProject() {
		title.text('Tambah Sub-Proyek');
		formModal.attr('action', `<?= site_url('pm/manajemen_proyek/tambah_subproyek') ?>`);
		$.ajax({
			url: `<?= site_url('pm/proyek/tampil_form_tambah_subproyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			// data: {},
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
	function edit_subProject() {
		title.text('Edit data Sub-Proyek');
		formModal.attr('action', `<?= site_url('pm/manajemen_proyek/edit_subproyek') ?>`);
		$.ajax({
			url: `<?= site_url('pm/proyek/tampil_form_edit_subproyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			// data: {},
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
	function add_subElemenProject() {
		title.text('Tambah List');
		formModal.attr('action', `<?= site_url('pm/manajemen_proyek/tambah_subelemen_proyek') ?>`);
		$.ajax({
			url: `<?= site_url('pm/proyek/form_tambah_subelemen_proyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			// data: {},
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
	function edit_subElemenProject() {
		title.text('Edit List');
		formModal.attr('action', `<?= site_url('pm/manajemen_proyek/edit_subelemen_proyek') ?>`);
		$.ajax({
			url: `<?= site_url('pm/proyek/form_edit_subelemen_proyek') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			// data: {},
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
	function delete_subElProject(task_type) {
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
     			alert(`Action to : <?= site_url('pm/manajemen_proyek/hapus') ?>`);
     		}
     	});
	}

	function finishProject(projectId) {
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
     			alert(`Action to : <?= site_url('pm/manajemen_proyek/proyek_selesai') ?>`);
     		}
     	});
	}

	modal.on('hidden.bs.modal', function() {
		title.empty();
		modalDialog.removeClass('modal-lg');
		modalBody.empty();
		modalFooter.removeClass('d-none');
		formModal.removeAttr('action');
		btnSubmit.text('Simpan');
	});
</script>