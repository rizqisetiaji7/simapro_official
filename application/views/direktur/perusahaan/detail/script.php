<script>
	const modal = $('#modalDetailCompany');
	const modalTitle = $('#modalDetailCompanyTitle');
	const modalDialog = $('#modalDetailCompany .modal-dialog');
	const modalBody = $('#modalDetailCompany .modal-body');
	const modalFooter = $('#modalDetailCompany .modal-footer');
	const formModal = $('#form_detail_company');
	const hiddenId = $('#formDetailCompany_id');
	const btnSubmit = $('#btnDetailCompany-submit');

	$(document).on('keyup', '.form-control', function(e) {
    $(this).removeClass('is-invalid');
    $(this).next().html('');
  });

  $(document).on('change', '.formSelect', function(e) {
		$(this).removeClass('is-invalid');
		$(this).next().html('');
  });

	// CRUD Direktur
	// Tambah Data Direktur
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
		});
	}

	// Detail Direktur
	function viewDetailDirector(director_id) {
		modalTitle.text('Detail Direktur');
		modalFooter.addClass('d-none');
		$.ajax({
			url: `<?= site_url('direktur/perusahaan/detail_director') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				director_id: director_id
			},
			success: function(data) {
				// console.log(data);
				modalBody.html(data);
				modal.modal('show');
			}
		});
	}

	// Edit Direktur
	function editDirector(director_id) {
		modalTitle.text('Edit Direktur');
		btnSubmit.text('Update');
		formModal.attr('action', `<?= site_url('direktur/perusahaan/edit_dir_process') ?>`);

		$.ajax({
			url: `<?= site_url('direktur/perusahaan/edit_direktur') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				director_id: director_id
			},
			success: function(data) {
				modalBody.html(data);
				modal.modal('show');
			}
		});
	}

	// Change Password
	function changePassword(unique_id, user_role) {
		let title = '';
		if (user_role == 'super_admin') {
			title = 'Ganti password direktur utama';
		} else if (user_role == 'admin') {
			title = 'Ganti password direktur';
		} else {
			title = 'Ganti password mandor';
		}

		modalTitle.text(title);
		formModal.attr('action', `<?= site_url('direktur/perusahaan/change_password_process') ?>`);

		$.ajax({
			url: `<?= site_url('direktur/perusahaan/change_password') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				unique_id: unique_id,
				user_role: user_role
			},
			success: function(data) {
				modalBody.html(data);
				modal.modal('show');
			}
		});
	}

	// Delete Director (coming soon)
	// function deleteDirector(director_id, user_id) {
		
	// }


	// CRUD Mandor
	// Tambah Data Mandor
	function addEmployee(company_id, handle_id, pageType='tambah') {
		modalTitle.text('Tambah data mandor');
		formModal.attr('action', `<?= site_url('direktur/perusahaan/mandor_process') ?>`);

		$.ajax({
			url: `<?= site_url('direktur/perusahaan/form_add_mandor') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				company_id: company_id,
				comp_handle_ID: handle_id,
				pageType: pageType
			},
			success: function(data) {
				modalBody.html(data);
				modal.modal('show');
			}
		});
	}

	// Edit Data Mandor
	function editEmployee(company_id, user_unique_id, pageType='edit') {
		modalTitle.text('Edit data mandor');
		formModal.attr('action', `<?= site_url('direktur/perusahaan/mandor_process') ?>`);

		$.ajax({
			url: `<?= site_url('direktur/perusahaan/form_edit_mandor') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				company_id: company_id,
				user_unique_id: user_unique_id,
				pageType: pageType
			},
			success: function(data) {
				modalBody.html(data);
				modal.modal('show');
			}
		});
	} 

	// View Detail Mandor
	function showDetailEmployee(unique_id, user_role) {
		modalTitle.text('Detail Data Mandor');
		modalFooter.addClass('d-none');
		$.ajax({
			url: `<?= site_url('direktur/perusahaan/detail_mandor') ?>`,
			method: 'POST',
			dataType: 'html',
			cache: false,
			data: {
				unique_id: unique_id,
				user_role: user_role
			},
			success: function(data) {
				// console.log(data);
				modalBody.html(data);
				modal.modal('show');
			}
		});
	}

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
      	// console.log(data);
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
		modalFooter.removeClass('d-none');
		formModal.removeAttr('action');
		btnSubmit.text('Simpan');
		hiddenId.removeAttr('value');
	});
</script>