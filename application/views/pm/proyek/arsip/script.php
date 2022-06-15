<script>
	const modal = $('#projectArchiveModal');
	const title = $('#projectArchiveModalLabel');
	const modalDialog = $('#projectArchiveModal .modal-dialog');
	const modalBody = $('#projectArchiveModal .modal-body');
	const formModal = $('#form_project_archive');

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
					url: `<?= site_url('pm/proyek/hapus_arsip') ?>`,
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
	});
</script>