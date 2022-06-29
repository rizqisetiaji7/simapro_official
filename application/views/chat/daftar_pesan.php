<!-- <div class="chat chat-left">
      <div class="chat-body">
         <div class="chat-content">
            <p><?php var_dump($project) ?></p>
            <span class="chat-time">23:30 am</span>
         </div>
      </div>
   </div>-->

   <div class="chat chat-left">
      <div class="chat-body">
         <div class="chat-bubble">
            <div class="chat-content">
               <p><?php var_dump($data_msg) ?></p>
               <span class="chat-time">23:30 am</span>
            </div>   
         </div>
      </div>
   </div>

<!-- <div class="chat chat-left">
      <div class="chat-body">
         <div class="chat-content">
            <p><?php var_dump($messages) ?></p>
            <span class="chat-time">23:30 am</span>
         </div>
      </div>
   </div> -->

<?php foreach($messages as $msg) { ?>
   <div class="chat <?= $msg['ID_sender'] == $sender['user_id'] ? 'chat-right' : 'chat-left' ?>">
      <?php if ($msg['ID_receiver'] != $receiver['user_id']) { ?>
      <div class="chat-avatar">
         <a href="javascript:void(0)" class="avatar">
            <img src="<?= $receiver['user_profile'] == 'default-avatar.jpg' ? base_url('assets/img/default-avatar.jpg') : base_url('uploads/profile/'.$receiver['user_profile']) ?>">
         </a>
      </div>
      <?php } ?>

      <?php if ($msg['chat_type'] == 'text') { ?>
         <div class="chat-body">
            <div class="chat-bubble">
               <div class="chat-content">
                  <p><?= $msg['chat_message'] ?></p>
                  <span class="chat-time"><?= datetimeIDN($msg['chat_created'], FALSE, TRUE) ?></span>
               </div>
               <?php if ($sender['user_id'] == $msg['ID_sender'] && $sender['user_role'] == 'direktur') { ?>
                  <div class="chat-action-btns">
                     <ul>
                        <li>
                           <a href="javascript:void(0)" class="edit-msg" onclick="editMessage()" data-toggle="tooltip" title="Edit pesan">
                              <i class="fa fa-pencil"></i>
                           </a>
                        </li>
                     </ul>
                  </div>
               <?php } ?>
            </div>
         </div>
      <?php } else { ?>
         <?php if ($sender['user_id'] == $msg['ID_sender'] && $sender['user_role'] == 'direktur') { ?>
            <div class="chat-body">
               <div class="chat-bubble">
                  <div class="chat-content d-flex align-items-start">
                     <img src="<?= base_url('assets/img/bookmark.png') ?>" width="38">
                     <div class="ml-3">
                        <h5 class="text-info">Penugasan Proyek</h5>
                        <p class="mb-0"><?= $msg['chat_message'] ?></p>
                        <span class="chat-time"><?= datetimeIDN($msg['chat_created'], FALSE, TRUE) ?></span>
                        <div class="pt-2">
                           <?php if ($msg['chat_status'] == NULL) { ?>
                              <span class="badge bg-inverse-light py-2 px-2"><span class="text-secondary">Belum dikerjakan</span></span>
                           <?php } else if ($msg['chat_status'] == 'ok') { ?>
                              <span class="badge bg-inverse-success py-2 px-2"><i class="fas fa-check mr-1"></i> Selesai</span>
                           <?php } else { ?>
                              <span class="badge bg-inverse-danger py-2 px-2"><i class="fas fa-times mr-1"></i> Pending</span>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
                  <div class="chat-action-btns">
                     <ul>
                        <li>
                           <a href="javascript:void(0)" onclick="editMessage()" class="edit-msg" data-toggle="tooltip" title="Edit pesan">
                              <i class="fa fa-pencil"></i>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         <?php } else { ?>
            <div class="chat-body">
               <div class="chat-bubble">
                  <div class="chat-content d-flex align-items-start">
                     <img src="<?= base_url('assets/img/bookmark.png') ?>" width="38">
                     <div class="ml-3">
                        <h5 class="text-info">Penugasan Proyek <span class="text-success"></h5>
                        <p class="mb-0"><?= $msg['chat_message'] ?></p>
                        <span class="chat-time"><?= datetimeIDN($msg['chat_created'], FALSE, TRUE) ?></span>
                        <!-- Status check -->
                        <div class="d-flex align-items-center my-3">
                           <div class="d-flex align-items-center mr-4">
                              <button class="circle-btn-msg data_status_success mr-2" data-status="success" data-msg_id="">
                                 <i class="fas fa-check"></i>
                              </button>
                              <span>Selesai</span>
                           </div>
                           <div class="d-flex align-items-center">
                              <button class="circle-btn-msg data_status_pending active mr-2" data-status="pending" data-msg_id="">
                                 <i class="fas fa-times"></i>
                              </button>
                              <span>Pending</span>
                           </div>
                        </div>
                        <!-- ./ Status check -->
                     </div>
                  </div>
               </div>
            </div>
         <?php } ?>
      <?php } ?>
   </div>
<?php } ?>