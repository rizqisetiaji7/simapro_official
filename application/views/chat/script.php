<script>
   const modal    = $('#chatModal');
   const form     = $('#form_modal_chat');
   const btnSend  = $('#btnModalSubmit-chat');
   const sendMessage = $('#sendMessageForm');

   function scrollDown() {
      const chatInner = $('#chatInner');
      chatInner.animate({
         scrollTop: chatInner.get(0).scrollHeight
      }, 200);
   }

   $(window).on('load', function() {
      scrollDown();
   });

   function editMessage() {
      modal.modal('show');
   }

   // Send Message
   sendMessage.on('submit', function(e) {
      e.preventDefault();
      $.ajax({
         url: $(this).attr('action'),
         method: 'POST',
         dataType: 'json',
         cache: false,
         data: new FormData(this),
         success: function(data) {
            console.log(data);
         }
      });
   });

   modal.on('hidden.bs.modal', function() {
      btnSend.text('kirim');
   });
</script>