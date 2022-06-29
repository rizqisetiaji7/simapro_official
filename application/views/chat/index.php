<div class="chat-main-row">  
   <!-- Chat Main Wrapper -->
   <div class="chat-main-wrapper">
      <!-- Chats View -->
      <div class="col-lg-9 message-view task-view">
         <div class="chat-window">
            <div class="fixed-header">
               <div class="navbar">
                  <div class="user-details mr-auto">
                     <div class="float-left user-img">
                        <a class="avatar" href="javascript:void(0)" title="<?= $receiver['user_fullname'] ?>">
                           <img src="<?= $receiver['user_profile'] == 'default-avatar.jpg' ? base_url('assets/img/default-avatar.jpg') : base_url('uploads/profile/'.$receiver['user_profile']) ?>" alt="<?= $receiver['user_fullname'] ?>" class="rounded-circle">
                           <span class="status <?= $receiver['login_status'] == 'on' ? 'online' : 'offline' ?>"></span>
                        </a>
                     </div>
                     <div class="user-info float-left">
                        <span><?= $receiver['user_fullname'] ?></span> <i class="typing-text text-muted">(<?= $receiver['user_role'] == 'pm' ? 'Proyek Manajer' : 'Direktur' ?>)</i>
                        <small class="text-muted d-block">Pada: <strong class="text-primary"><?= $project['project_name'] ?></strong></small>
                     </div>
                  </div>
               </div>
            </div>
            <div class="chat-contents">
               <div class="chat-content-wrap">
                  <div class="chat-wrap-inner" id="chatInner" style="scroll-behavior: smooth;">
                     <div class="chat-box">
                        <div class="chats" id="listMessages">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="chat-footer">
               <div class="message-bar">
                  <div class="message-inner">
                     <div class="message-area">
                        <form id="sendMessageForm" action="<?= site_url('chat/kirim_pesan') ?>" method="POST" class="input-group">
                           <input type="hidden" name="ID_project" value="<?= $project['project_id'] ?>">
                           <input type="hidden" name="ID_sender" value="<?= $data_msg['from_user'] ?>">
                           <input type="hidden" name="ID_receiver" value="<?= $data_msg['to_user'] ?>">
                           <textarea class="form-control" name="chat_message" placeholder="Tulis pesan..."></textarea>
                           <span class="input-group-append">
                              <button type="submit" class="btn btn-custom"><i class="fa fa-paper-plane"></i></button>
                           </span>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- /Chats View -->      
   </div>
   <!-- /Chat Main Wrapper -->
</div>

<?php $this->view('chat/task_modal'); ?>
<?php $this->view('chat/script'); ?>