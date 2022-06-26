<script>
	const modalUpGambar = $('#modalUploadDoc');
	const formUpload = $('#formUpload_doc');
	const btnUpload = $('#btnUploadDoc');
	const docFilename = $('#docFileName');
	
	// Upload Sub Proyek
	function uploadDocumentation(type_pro = 'proyek', project_id, subproject_id = null) {
		formUpload.attr('action', `<?= site_url('pm/foto/upload_foto') ?>`);
		if (type_pro == 'proyek') {
			$('#project_type_pro').attr('value', 'proyek');
		} else if (type_pro == 'subproyek') {
			$('#project_type_pro').attr('value', 'subproyek');
		}
		$('#projId').attr('value', project_id);
		$('#subProj_ID').attr('value', subproject_id);
		modalUpGambar.modal('show');
	}
	
	// Custom click to choose file upload Proyek & Subproyek Documentation
	chooseFile('#choosePhotoDoc', '#upPhotoProject');

	formUpload.on('submit', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: 'POST',
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			data: new FormData(this),
			beforeSend: function() {
				btnUpload.text('Mengupload...').attr('disabled', true);
			},
			complete: function() {
				btnUpload.text('Upload')
				btnUpload.removeClass('btn-custom');
				btnUpload.addClass('btn-secondary');
			},
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
				} else {
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
				modalUpGambar.modal('hide');
			}
		});
	});

	// Modal Upload input type file change event
	$(document).on('change', '#upPhotoProject', function() {
		if (this.files) {
			// Get and display filename
			docFilename.removeClass('d-none');
			let txt = '';
			for (let i = 0; i < this.files.length; i++) {
				txt += `<p class="mb-1 small text-muted">Gambar ${i+1}: <strong class="text-dark">${this.files[i].name}</strong></p>`;
			}
			docFilename.addClass('mb-3').html(txt);
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