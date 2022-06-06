<script>
	
	// Choose file from computer
	chooseFile('#chooseFileImage', '#inputProfile');

	$(document).on('change', '#inputProfile', function() {
		if (this.files && this.files[0]) {
			// Get and display filename
			$('#profileFileName').removeClass('d-none');
			$('#profileFileName').addClass('mb-3').html(`<p class="mb-0 small text-muted">Gambar: <strong class="text-dark">${this.files[0].name}</strong></p>`);
			$('#btnSubmitProfile').removeClass('btn-secondary').removeAttr('disabled');
			$('#btnSubmitProfile').addClass('btn-custom');
		}
	});

</script>