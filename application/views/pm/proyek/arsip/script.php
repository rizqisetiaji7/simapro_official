<script>
	const modal = $('#projectArchiveModal');
	const title = $('#projectArchiveModalLabel');
	const modalDialog = $('#projectArchiveModal .modal-dialog');
	const modalBody = $('#projectArchiveModal .modal-body');
	const formModal = $('#form_project_archive');
	const modalFooter = $('#projectArchiveModal .modal-footer');

	// Tampil Detail Proyek Arsip
	function viewDetailInfo(project_id, project_code_ID) {
		title.text('Detail Proyek');
		modalDialog.addClass('modal-xl');

		$.ajax({
			url: `<?= site_url('pm/arsip/detail_proyek_arsip') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				project_id: project_id,
				project_code: project_code_ID
			},
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

	// Tampil Detail Sub-Proyek
	function detail_subProject(project_id, subproject_id) {
      title.text('Detail Sub-Proyek');
      modalFooter.addClass('d-none');
      $.ajax({
         url: `<?= site_url('pm/arsip/info_detail_subproyek') ?>`,
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

	// Hapus Archive (Mengembalikan status proyek menjadi ke daftar proyek)
	function removeArchive(projectID) {
		Swal.fire({
         icon: 'info',
         html: `
				<h4>Anda akan mengembalikan proyek ini?</h4>
				<p class="mb-0 text-muted small">Data proyek akan kembali ke daftar proyek.</p>
				<p class="mb-0 text-muted small">Status proyek secara otomatis menjadi proyek berjalan.</p>
         `,
         confirmButtonText: 'Ya, Kembalikan',
         showCancelButton: true,
         cancelButtonText: 'Batal'
      }).then((result) => {
      	if (result.isConfirmed) {
      		$.ajax({
				url: `<?= site_url('pm/arsip/hapus_arsip') ?>`,
				method: 'POST',
				dataType: 'json',
				cache: false,
				data: { project_ID: projectID },
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

	// SHOW DOCUMENTATION SUB-PROJECT
	function showDocSubproject(project_id, subproject_id, subproject_name) {
		title.html(`Dokumentasi Proyek : <span class="text-secondary small">${subproject_name}</span>`);
		modalDialog.addClass('modal-lg');
		modalFooter.addClass('d-none');

		$.ajax({
			url: `<?= site_url('pm/arsip/tampil_dokumentasi') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				project_id: project_id,
				subproject_id: subproject_id
			},
			beforeSend: function() {
				modalBody.html(`Memuat data...`);
			},
			success: function(data) {
				modalBody.html(data);
			}
		});
		modal.modal('show');
	}

	modal.on('hidden.bs.modal', function() {
		title.empty();
		modalDialog.removeClass('modal-xl');
		modalDialog.removeClass('modal-lg');
		modalBody.empty();
		formModal.removeAttr('action');
		modalFooter.removeClass('d-none');
	});
</script>