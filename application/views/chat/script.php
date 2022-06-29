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
            $('#listMessages').html(data);
         },
         complete: function() {
            scrollDown();
         }
      });
   }

   let intValID = setInterval(function() {
      loadMessages();
      clearInterval(intValID);
   }, 200);

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
                  html: `
                     <div class="pt-4 pb-2 text-center">
                        <img src="${data.icon}" class="mb-4" width="80" alt="">
                        ${data.header}
                        <p class="mb-0 text-secondary small">${data.message}</p>
                     </div>
                  `,
                  confirmButtonText: 'Tutup'
               });
            } else if (data.status == 'error_message') {
               Swal.fire({
                  html: `
                     <div class="pt-4 pb-2 text-center">
                        <img src="${data.icon}" class="mb-4" width="80" alt="">
                        ${data.header}
                        <p class="mb-0 text-secondary small">${data.message}</p>
                     </div>
                  `,
                  confirmButtonText: 'Tutup'
               });
            } else {
               loadMessages();
               $('#chatBox').val('');
            }
         }
      });
   });

   modal.on('hidden.bs.modal', function() {
      btnSend.text('kirim');
   });
</script>