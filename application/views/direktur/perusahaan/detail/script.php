<script>
	const modal = $('#modalDetailCompany');
	const modalTitle = $('#modalDetailCompanyTitle');
	const modalDialog = $('#modalDetailCompany .modal-dialog');
	const modalBody = $('#modalDetailCompany .modal-body');
	const formModal = $('#form_detail_company');
	const hiddenId = $('#formDetailCompany_id');
	const btnSubmit = $('#btnDetailCompany-submit');

	function addDirector(handle_id, company_id, user_role) {
		modalTitle.text('Input data Direktur');
		formModal.attr('action', `<?= site_url('direktur/perusahaan/tambah_dir_process') ?>`);

		$.ajax({
			url: `<?= site_url('direktur/perusahaan/tambah_direktur') ?>`,
			dataType: 'html',
			method: 'POST',
			cache: false,
			data: {
				handle_id: handle_id,
				company_id: company_id,
				user_role: user_role
			},
			success: function(data) {
				modalBody.html(data);
				modal.modal('show');
			}
		})
	}

	function addEmployee(company_id) {
		console.log(company_id);
		modalTitle.text('Tambah data mandor');
		modal.modal('show');
	}

	$(document).on('keyup', '.form-control', function(e) {
    $(this).removeClass('is-invalid');
    $(this).next().html('');
  });

  $(document).on('change', '.formSelect', function(e) {
		$(this).removeClass('is-invalid');
		$(this).next().html('');
  });
 

 	// Submit Form Data
	formModal.on('submit', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: 'POST',
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      data: new FormData(this),
      beforeSend: function() {
        btnSubmit.attr('disabled', true).text('Menyimpan...')
      },
      complete: function() {
        btnSubmit.attr('disabled', false).text('Simpan')
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
            text: `${data.message}`
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.reload();
            } else {
              window.location.reload();
            }
          });
      	} else {
      		modal.modal('hide');
          Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: `${data.message}`
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.reload();
            } else {
              window.location.reload();
            }
          });
      	}
      }
		})
	});
 
    
  modal.on('hidden.bs.modal', function() {
		modalTitle.empty();
		modalDialog.removeClass('modal-lg');
		modalBody.empty();
		formModal.removeAttr('action');
		btnSubmit.text('Simpan');
		hiddenId.removeAttr('value');
	});
</script>