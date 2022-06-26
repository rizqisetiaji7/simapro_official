<script>
	const modal = $('#projectArchiveModal');
	const title = $('#projectArchiveModalLabel');
	const modalDialog = $('#projectArchiveModal .modal-dialog');
	const modalBody = $('#projectArchiveModal .modal-body');
	const formModal = $('#form_project_archive');
	// const btnSubmit = $('#btnSubmit-project');

	// Tampil Detail Proyek Arsip
	function viewDetailInfo(project_id, project_code_ID) {
		title.text('Detail Proyek');
		modalDialog.addClass('modal-xl');

		$.ajax({
			url: `<?= site_url('direktur/proyek/detail_proyek_arsip') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				project_id: project_id,
				project_code: project_code_ID
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

	// Hapus Archive (Mengembalikan status proyek menjadi on progress)
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
					url: `<?= site_url('direktur/arsip/hapus_arsip') ?>`,
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
				            confirmButtonText: 'Oke, Sip!',
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

	modal.on('hidden.bs.modal', function() {
		title.empty();
		modalDialog.removeClass('modal-xl');
		modalBody.empty();
		formModal.removeAttr('action');
		// btnSubmit.text('Simpan');
	});
</script>