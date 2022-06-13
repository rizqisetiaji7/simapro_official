<!-- Modal -->
<div class="modal fade" id="addProject-modal" tabindex="-1" role="dialog" aria-labelledby="addProject-modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <form class="modal-content" action="" method="post" accept-charset="utf-8">
        <div class="modal-header">
            <h4 class="modal-title" id="addProject-modalLabel">Tambah Proyek Baru</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 mb-3">
                    <div style="min-height: 200px; border-radius: 8px; background: #f7f7f7;" class="d-flex flex-column align-items-center justify-content-center py-4 px-3">
                        <img src="<?= base_url('assets/img/cloud-computing.png') ?>" width="64" class="mb-3" alt="cloud computing icon">
                        <div class="d-flex flex-column align-items-center mb-3 text-center">
                            <p class="text-secondary mb-0 mr-2">Unggah thumbnail atau foto. <strong class="text-primary" style="cursor: pointer;" id="chooseFileImage">Pilih file</strong></p>
                            <p class="text-muted small">Ukuran file maksimal <strong class="text-dark">4MB</strong>.</p>
                        </div>

                        <div id="profileFileName" class="text-center py-2 px-3 d-none" style="border-radius: 4px; position: relative; overflow: hidden; background: #f0f0f0;"></div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="judul-proyek">Judul Proyek:</label>
                        <input type="text" id="judul-proyek" name="proyek_name" class="form-control" required placeholder="Ketik judul proyek...">
                    </div>

                    <div class="form-group">
                        <label for="mandor">Penanggung Jawab Lapangan:</label>
                        <select name="mandor" class="custom-select" require>
                            <option value="">Proyek Manajer 1</option>
                            <option value="">Proyek Manajer 2</option>
                            <option value="">Proyek Manajer 3</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="mandor">Lokasi/Alamat Proyek:</label>
                        <textarea name="alamat_proyek" class="form-control" rows="4" placeholder="Alamat proyek..."></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="start-proyek">Mulai Pengerjaan:</label>
                            <input type="date" class="form-control" name="start_proyek" id="start-proyek">
                        </div>
                        <div class="form-group col-6">
                            <label for="finish-proyek">Berakhir Pada:</label>
                            <input type="date" class="form-control" name="finish_proyek" id="finish-proyek">
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" name="save_proyek" class="btn btn-primary">Simpan</button>
        </div>
    </form>
  </div>
</div>