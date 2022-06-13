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
                        <a class="avatar" href="profile.html" title="Azhar Gunawan">
                           <img src="<?= base_url('assets/img/default-avatar.jpg') ?>" alt="" class="rounded-circle">
                           <span class="status online"></span>
                        </a>
                     </div>
                     <div class="user-info float-left">
                        <span>Om Zay</span> <i class="typing-text text-muted">(Direktur)</i>
                        <small class="text-muted d-block">Pada: <strong class="text-dark">Perbaikan Jembatan Cirahong</strong></small>
                     </div>
                  </div>
               </div>
            </div>
            <div class="chat-contents">
               <div class="chat-content-wrap">
                  <div class="chat-wrap-inner">
                     <div class="chat-box">
                        <div class="chats">

                           <div class="chat chat-left">
                              <div class="chat-body">
                                 <div class="chat-bubble">
                                    <div class="chat-content">
                                       <p>Halo, apakah bersedia untuk memperbaiki proyek?</p>
                                       <span class="chat-time">23:30 am</span>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="chat chat-right">
                              <div class="chat-body">
                                 <div class="chat-bubble">
                                    <div class="chat-content">
                                       <p>Baik pak, saya selalu siap</p>
                                       <span class="chat-time">8:35 am</span>
                                    </div>
                                    <div class="chat-action-btns">
                                       <ul>
                                          <li>
                                             <a href="#" class="edit-msg" data-toggle="tooltip" title="Edit pesan">
                                                <i class="fa fa-pencil"></i>
                                             </a>
                                          </li>
                                          <!-- <li>
                                             <a href="#" class="del-msg" data-toggle="tooltip" title="Hapus pesan">
                                                <i class="fa fa-trash"></i>
                                             </a>
                                          </li> -->
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="chat-line">
                              <span class="chat-date">10 Juni, 2022</span>
                           </div>

                           <div class="chat chat-left">
                              <div class="chat-avatar">
                                 <a href="profile.html" class="avatar">
                                    <img alt="" src="<?= base_url('assets/img/default-avatar.jpg') ?>">
                                 </a>
                              </div>
                              <div class="chat-body">
                                 <div class="chat-bubble">
                                    <div class="chat-content d-flex align-items-start">
                                       <img src="<?= base_url('assets/img/bookmark.png') ?>" width="38">
                                       <div class="ml-3">
                                          <h5 class="text-info">Penugasan Proyek <span class="text-success"></h5>
                                          <p class="mb-0">Baiklah, silahkan periksa kembali bagian Subproyek</p>
                                          <p class="mb-0">dan cek kembali foto dokumentasinya.</p>
                                          <span class="chat-time">9:00 am</span>
                                          <!-- Status check -->
                                          <div class="d-flex align-items-center my-3">
                                             <div class="d-flex align-items-center mr-4">
                                                <button class="circle-btn-msg data_status_success active mr-2" data-status="success" data-msg_id="">
                                                   <i class="fas fa-check"></i>
                                                </button>
                                                <span>Sukses</span>
                                             </div>
                                             <div class="d-flex align-items-center">
                                                <button class="circle-btn-msg data_status_pending mr-2" data-status="pending" data-msg_id="">
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
                           </div> 

                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="chat-footer">
               <div class="message-bar">
                  <div class="message-inner">
                     <div class="message-area">
                        <div class="input-group">
                           <textarea class="form-control" placeholder="Tulis pesan..."></textarea>
                           <span class="input-group-append">
                              <button class="btn btn-custom" type="button"><i class="fa fa-paper-plane"></i></button>
                           </span>
                        </div>
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