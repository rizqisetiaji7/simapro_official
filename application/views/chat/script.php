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

   function loadMessages() {
      $.ajax({
         url: `<?= site_url('chat/tampil_pesan') ?>`,
         dataType: 'html',
         cache: false,
         success: function(data) {
            $('#listMessages').html(data);
         },
         complete: function() {
            scrollDown();
         }
      });
   }

   loadMessages();

   // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;
   let pusher = new Pusher('051a295c0e08e48dd009', { cluster: 'ap1'});
   let channel = pusher.subscribe('simapro-chat');
   channel.bind('listen', function(data) {
      if (data.status == 'success') {
         loadMessages();
      } else {
         Swal.fire({
            html: `
               <div class="pt-4 pb-2 text-center">
                  <img src="${data.icon}" class="mb-4" width="80" alt="">
                  ${data.header}
                  <p class="mb-0 text-secondary small">${data.message}</p>
               </div>
            `,
            confirmButtonText: 'Tutup'
         }).then((result) => {
            loadMessages();
         });
      }
   });

   function editMessage() {
      modal.modal('show');
   }

   // Send Message
   sendMessage.on('submit', function(e) {
      e.preventDefault();
      let chatInterval;
      $.ajax({
         url: $(this).attr('action'),
         method: $(this).attr('method'),
         cache: false,
         contentType: false,
         processData: false,
         data: new FormData(this),
         success: function(data) {
            sendMessage.trigger('reset');
         }
      });
   });

   modal.on('hidden.bs.modal', function() {
      btnSend.text('kirim');
   });
</script>