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

   function editMessage() {
      modal.modal('show');
   }

   function loadMessages() {
      $.ajax({
         url: `<?= site_url('chat/tampil_pesan') ?>`,
         dataType: 'html',
         cache: false,
         success: function(data) {
            $('#listMessages').html(data)
         }
      });
   }

   $(window).on('load', function() {
      loadMessages();
      scrollDown();
   });

   // Send Message
   sendMessage.on('submit', function(e) {
      e.preventDefault();
      $.ajax({
         url: $(this).attr('action'),
         method: $(this).attr('method'),
         dataType: 'json',
         cache: false,
         data: $(this).serialize(),
         success: function(data) {
            if (data.status == 'failed') {
               Swal.fire({
                  icon: 'error',
                  title: 'Kirim pesan gagal!',
                  html: `${data.message}`,
                  showConfirmButton: false,
                  timer: 2000
               });
            } else {
               console.log(data);
            }
         }
      });
   });

   modal.on('hidden.bs.modal', function() {
      btnSend.text('kirim');
   });
</script>