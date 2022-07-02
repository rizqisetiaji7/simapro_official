<script>
   const modal    = $('#chatModal');
   const formChat  = $('#formLiveChat');
   const btnSend  = $('#btnModalSubmit-chat');
   const sendMessage = $('#sendMessageForm');
   const modalBody = $('#taskContent');

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

   function createTask(msg, ID_project, ID_sender, ID_receiver) {
      formChat.attr('action', `<?= site_url('chat/buat_task') ?>`);
      $('#IDProject').attr('value', ID_project);
      $('#IDSender').attr('value', ID_sender);
      $('#IDReceiver').attr('value', ID_receiver);
      $('#chatMessageData').val(msg);
      modal.modal({
         show: true,
         backdrop: 'static'
      });
   }

   function deleteTask(chat_id) {
      Swal.fire({
         icon: 'warning',
         title: 'Hapus Task?',
         text: 'Anda akan menghapus Penugasan/Task ini?.',
         confirmButtonText: 'Ya, Hapus',
         showCancelButton: true,
         cancelButtonText: 'Batal'
      }).then((res) => {
         if (res.isConfirmed) {
            $.ajax({
               url: `<?= site_url('chat/hapus_task') ?>`,
               method: 'POST',
               cache: false,
               data: {
                  chat_id: chat_id
               },
               success: function(data) {
                  Swal.fire({
                     icon: 'success',
                     title: 'Berhasil',
                     text: 'Task telah berhasil dihapus.',
                     showConfirmButton: false,
                     timer: 2000
                  });
               }
            })
         }
      });
   }

   function updateStatusTask(chat_id, chat_status) {
      $.ajax({
         url: `<?= site_url('chat/update_status_task') ?>`,
         method: 'POST',
         cache: false,
         data: {
            chat_id: chat_id,
            chat_status: chat_status
         },
         success: function(data) {
            Swal.fire({
               icon: 'success',
               title: 'Berhasil',
               text: 'Status Task telah berhasil diperbarui.',
               showConfirmButton: false,
               timer: 2000
            });
         }
      });
   }

   // Send Message
   sendMessage.on('submit', function(e) {
      e.preventDefault();
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

   formChat.on('submit', function(e) {
      e.preventDefault();
      $.ajax({
         url: $(this).attr('action'),
         method: 'POST',
         cache: false,
         contentType: false,
         processData: false,
         data: new FormData(this),
         beforeSend: function() {
            $('#btnModalSubmit-chat').attr('disabled', true).text('Mengirim...');
         },
         complete: function() {
            $('#btnModalSubmit-chat').attr('disabled', false).text('Kirim');
         },
         success: function(data) {
            modal.modal('hide');
         }
      })
   });

   modal.on('hidden.bs.modal', function() {
      btnSend.text('kirim');
      formChat.removeAttr('action');
      $('#IDProject').removeAttr('value');
      $('#IDSender').removeAttr('value');
      $('#IDReceiver').removeAttr('value');
      $('#chatMessageData').val('');
   });
</script>