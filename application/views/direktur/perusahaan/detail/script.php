<script>
	const modal = $('#modalDetailCompany');
	const modalTitle = $('#modalDetailCompanyTitle');
	const modalDialog = $('#modalDetailCompany .modal-dialog');
	const modalBody = $('#modalDetailCompany .modal-body');
	const formModal = $('#form_detail_company');
	const hiddenId = $('#formDetailCompany_id');
	const btnSubmit = $('#btnDetailCompany-submit');

	function addEmployee(company_id) {
		console.log(company_id);
		modalTitle.text('Tambah data mandor');
		modal.modal('show');
	}

	// $(document).on('keyup', '.form-control', function(e) {
 //      $(this).removeClass('is-invalid');
 //      $(this).next().html('');
 //   });

 //   $(document).on('change', '.formSelect', function(e) {
 //      $(this).removeClass('is-invalid');
 //      $(this).next().html('');
 //   });
    
  modal.on('hidden.bs.modal', function() {
        modalTitle.empty();
        modalDialog.removeClass('modal-lg');
        modalBody.empty();
        formModal.removeAttr('action');
        btnSubmit.text('Simpan');
        hiddenId.removeAttr('value');
    });
</script>