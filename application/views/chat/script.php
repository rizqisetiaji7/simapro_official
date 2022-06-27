<script>
   const modal    = $('#chatModal');
   const form     = $('#form_modal_chat');
   const btnSend  = $('#btnModalSubmit-chat');

   function editMessage() {
      modal.modal('show');
   }

   modal.on('hidden.bs.modal', function() {
      btnSend.text('kirim');
   });
</script>