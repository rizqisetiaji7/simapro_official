<script>
	const modal = $('#modalProfile');
	const title = $('#modalProfileTitle');
	const modalDialog = $('#modalProfile .modal-dialog');
	const modalBody = $('#modalProfile .modal-body');
	const formModal = $('#form_modal_profile');
	const btnSubmit = $('#btnProfile-submit');

	$(document).on('keyup', '.form-control', function(e) {
		$(this).removeClass('is-invalid');
		$(this).next().html('');
	});
	
	// Profile CRUD
	function uploadProfile(unique_id, user_role) {
		console.log(`Unique ID: ${unique_id}, User Role: ${user_role}`);
		title.text('Upload Foto Profile');
		modal.modal('show');
	}


	modal.on('hidden.bs.modal', function() {
		title.empty();
		modalDialog.removeClass('modal-lg');
		modalBody.empty();
		formModal.removeAttr('action');
		btnSubmit.text('Simpan');
   });
</script>