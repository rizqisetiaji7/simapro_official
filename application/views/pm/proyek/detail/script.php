<script>
	const modalUpGambar = $('#modalUploadSubProyek');
	const inputFileUpload = $('#uploadInputSubproyek');
	
	// Show modal upload Sub-proyek Doc
	$(document).on('click', '.btn-uploadGambarProyek', function(e) {
		e.preventDefault();
		// Show modal
		modalUpGambar.modal({
			show: true,
			backdrop: 'static'
		});
		console.log($(this).data('title'));
	});

	// Custom click to choose file upload
	chooseFile('.thumbnail-box', inputFileUpload);

	modalUpGambar.on('hidden.bs.modal', function() {
		console.log('Modal Upload Closed');
	});
</script>