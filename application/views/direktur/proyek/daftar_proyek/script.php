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
		formModal.attr('action', `<?= site_url('direktur/proyek/tambah') ?>`);
		$.ajax({
			url: `<?= site_url('direktur/proyek/form_tambah') ?>`,
			dataType: 'html',
			cache: false,
			success: function(data) {
				modalBody.html(data);
				modal.modal('show');
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