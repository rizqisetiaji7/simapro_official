<!-- Modal Upload Gambar -->
<div class="modal fade" id="modalUploadSubProyek" tabindex="-1" role="dialog" aria-labelledby="modalUploadSubProyekTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <div class="modal-header">
          <h4 class="modal-title" id="modalUploadSubProyekTitle">Unggah Foto Dokumentasi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Batal" data-toggle="tooltip" title="Tutup"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-10 mx-auto">
              <input type="file" name="upload_subproyekdoc" class="d-none" multiple class="d-none" id="uploadInputSubproyek">
              <div class="thumbnail-box">
                <div class="thumbnail-kanban d-flex flex-column align-items-center justify-content-center text-center">
                  <i class="fa fa-cloud-upload mb-2"></i>
                  <p class="mb-0 text-sm text-muted">Klik area ini untuk unggah gambar. <br/> Maksimal ukuran file <strong class="text-primary">25 Mb</strong>.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-10 mx-auto text-center">
              <button type="submit" name="submit_upload" class="btn btn-primary mt-4"><i class="fa fa-cloud-upload"></i> Unggah sekarang</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>