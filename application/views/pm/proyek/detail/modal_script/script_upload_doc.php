<script>
	const modalUpGambar = $('#modalUploadDoc');
	const formUpload = $('#formUpload_doc');
	const btnUpload = $('#btnUploadDoc');
	const docFilename = $('#docFileName');
	
	// Upload Sub Proyek
	function uploadDocumentation() {
		modalUpGambar.modal('show');
	}
	
	// Custom click to choose file upload Proyek & Subproyek Documentation
	chooseFile('#choosePhotoDoc', '#upPhotoProject');

	// Modal Upload input type file change event
	$(document).on('change', '#upPhotoProject', function() {
		if (this.files && this.files[0]) {
			// Get and display filename
			docFilename.removeClass('d-none');
			docFilename.addClass('mb-3').html(`<p class="mb-0 small text-muted">Gambar: <strong class="text-dark">${this.files[0].name}</strong></p>`);
			btnUpload.removeClass('btn-secondary').removeAttr('disabled');
			btnUpload.addClass('btn-custom');
		}
	});

	modalUpGambar.on('hidden.bs.modal', function() {
		formUpload.removeAttr('action');
		formUpload.trigger('reset');
		docFilename.addClass('d-none');
		docFilename.removeClass('mb-3');
		docFilename.empty();
		btnUpload.addClass('btn-secondary').attr('disabled', true);
		btnUpload.removeClass('btn-custom');
	});
</script>