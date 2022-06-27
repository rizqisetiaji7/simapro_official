<script>
	const modal = $('#projectModal');
	const title = $('#projectModalLabel');
	const modalDialog = $('#projectModal .modal-dialog');
	const modalBody = $('#projectModal .modal-body');
	const formModal = $('#form_modal_project');
	const btnSubmit = $('#btnSubmit-project');

	// Choose file from computer
	chooseFile('#chooseFileImage', '#inputProfile');

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
			$('#btnSubmitProfile').removeClass('btn-secondary').removeAttr('disabled');
			$('#btnSubmitProfile').addClass('btn-custom');
		}
	});

	// Add Project
	function addNewProject() {
		title.text('Tambah Proyek Baru');
		formModal.attr('action', `<?= site_url('direktur/proyek/tambah_proyek') ?>`);
		$.ajax({
			url: `<?= site_url('direktur/proyek/form_tambah') ?>`,
			dataType: 'html',
			cache: false,
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

	function editProjectStatus(project_code) {
		title.text('Ubah Status Proyek');
		formModal.attr('action', `<?= site_url('direktur/proyek/edit_status_process') ?>`);
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

	// Arsipkan Proyek
	function archiveProject(project_code) {
		Swal.fire({
         icon: 'warning',
         title: 'Arsipkan proyek ini?',
         text: `Data akan disimpan sebagai arsip, dan tidak akan terhapus.`,
         confirmButtonText: 'Ya, Arsipkan',
         confirmButtonColor: '#f31a69',
         showCancelButton: true,
         cancelButtonText: 'Batal'
      }).then((result) => {
      	if (result.isConfirmed) {
      		$.ajax({
					url: `<?= site_url('direktur/arsip/arsip_proyek') ?>`,
					method: 'POST',
					dataType: 'json',
					cache: false,
					data: { project_code: project_code },
					success: function(data) {
						if (data.status == 'success') {
							Swal.fire({
				            icon: 'success',
				            title: 'Berhasil',
				            text: `${data.message}`,
				            showConfirmButton: false,
				            timer: 2000
				         }).then((result) => {
				         	window.location.reload();
				         });
						} else if (data.status == 'failed') {
							Swal.fire({
				            icon: 'error',
				            title: 'Gagal',
				            text: `${data.message}`,
				            showConfirmButton: false,
				            timer: 2000
				         }).then((result) => {
				         	window.location.reload();
				         });
						}
					}
				});
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
		            timer: 2000
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
		            timer: 2000
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