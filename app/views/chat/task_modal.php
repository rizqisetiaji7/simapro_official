<!-- Modal -->
<div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <form class="modal-content" id="formLiveChat" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" id="IDProject" name="ID_project">
                <input type="hidden" id="IDSender" name="ID_sender">
                <input type="hidden" id="IDReceiver" name="ID_receiver">
                <div class="row">
                    <div class="col-12 py-3 px-4">
                        <div class="d-flex align-items-start mb-4">
                            <img src="<?= base_url('assets/img/list.png') ?>" class="mb-3" width="48">
                            <div class="ml-3">
                                <h4 class="mb-1">Jadikan pesan ini sebagai tugas?</h4>
                                <span class="d-block text-muted">Pesan otomatis akan menjadi list status pengingat terhadap proyek yang sedang ditinjau.</span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h5>Edit Pesan:</h5>
                            <textarea class="form-control" name="chat_message" id="chatMessageData" rows="4" placeholder="Tulis pesan" required></textarea>
                        </div>
                        <div class="d-flex align-items-center justify-content-end">
                            <button type="button" class="btn btn-light btn-sm mr-2" data-dismiss="modal">Batal</button>
                            <button type="submit" id="btnModalSubmit-chat" class="btn btn-success btn-sm">Kirim</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>