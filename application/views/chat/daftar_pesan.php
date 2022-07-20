<?php if ($messages) { ?>
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
                     <p><?= stripslashes($msg['chat_message']) ?></p>
                     <span class="chat-time"><?= datetimeIDN($msg['chat_created'], FALSE, TRUE) ?></span>
                  </div>
                  <?php if ($sender['user_id'] == $msg['ID_sender'] && $sender['user_role'] == 'direktur') { ?>
                     <div class="chat-action-btns">
                        <ul>
                           <li>
                              <a href="javascript:void(0)" class="edit-msg" onclick="createTask(<?= "'".$msg['chat_message']."'" ?>, <?= $msg['ID_project'] ?>, <?= $msg['ID_sender'] ?>, <?= $msg['ID_receiver'] ?>)" data-toggle="tooltip" title="Jadikan tugas / memo">
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
                           <p class="mb-0"><?= stripslashes($msg['chat_message']) ?></p>
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
                              <a href="javascript:void(0)" onclick="deleteTask(<?= $msg['chat_id'] ?>)" class="edit-msg" data-toggle="tooltip" title="Hapus task">
                                 <i class="fa fa-trash"></i>
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
                           <p class="mb-2"><?= stripslashes($msg['chat_message']) ?></p>
                           <span class="chat-time"><?= datetimeIDN($msg['chat_created'], FALSE, TRUE) ?></span>

                           <span class="mt-3 mb-2 d-block small text-primary">Cek salah satu status (Tugas)</span>

                           <?php 
                              $checkStatusOk = '';
                              $checkStatusPnd = '';
                              if ($msg['chat_status'] != NULL) {
                                 if ($msg['chat_status'] == 'ok') {
                                    $checkStatusOk = 'checked="checked"';
                                    $checkStatusPnd = NULL;
                                 } else if ($msg['chat_status'] == 'pending') {
                                    $checkStatusOk = NULL;
                                    $checkStatusPnd = 'checked="checked"';
                                 }
                              } else {
                                 $checkStatusOk = NULL;
                                 $checkStatusPnd = NULL;
                              }
                           ?>
                           <!-- Status check -->
                           <form class="input-radio">
                              <input type="radio" id="<?= 'taskChatStatusOk'.$msg['chat_id'] ?>" name="chat_status" value="ok" <?= $checkStatusOk ?> class="d-none custom-radio-input">
                              <label for="<?= 'taskChatStatusOk'.$msg['chat_id'] ?>" onclick="updateStatusTask(<?= $msg['chat_id'] ?>, 'ok')" class="label-box bg-success">
                                <i class="fas fa-check text-white check-icon"></i>
                              </label> <p class="mb-0 mt-1 mr-4">Selesai</p>

                              <input type="radio" id="<?= 'taskChatStatusPending'.$msg['chat_id'] ?>" name="chat_status" value="pending" <?= $checkStatusPnd ?> class="d-none custom-radio-input">
                              <label for="<?= 'taskChatStatusPending'.$msg['chat_id'] ?>" onclick="updateStatusTask(<?= $msg['chat_id'] ?>, 'pending')" class="label-box bg-danger">
                                <i class="fas fa-times text-white check-icon"></i>
                              </label> <p class="mb-0 mt-1">Pending</p>
                           </form>
                           <!-- ./ Status check -->
                        </div>
                     </div>
                  </div>
               </div>
            <?php } ?>
         <?php } ?>
      </div>
   <?php } ?>
<?php } else { ?>
   <div class="row">
      <div class="col-12">
         <div class="d-flex flex-column align-items-center justify-content-center">
            <img class="mt-5 mb-2" src="<?= base_url('assets/img/chat.png') ?>" width="90" alt="">
            <h4 class="text-secondary">Belum ada pesan.</h4>
         </div>
      </div>
   </div>
<?php } ?>