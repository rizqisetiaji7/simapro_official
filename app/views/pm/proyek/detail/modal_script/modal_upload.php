<!-- Modal Upload -->
<div class="modal fade" id="modalUploadDoc" tabindex="-1" role="dialog" aria-labelledby="modalUploadDocTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <form class="modal-content" id="formUpload_doc" method="post" accept-charset="utf-8" enctype="multipart/form-data">
      <div class="modal-body">
        <input type="hidden" name="type_pro" id="project_type_pro">
        <input type="hidden" name="proj_id" id="projId">
        <input type="hidden" name="subproj_id" id="subProj_ID">
        <input type="file" name="project_photo[]" id="upPhotoProject" multiple="multiple" accept=".jpg,.png,.jpeg" class="d-none">
        <div style="min-height: 200px; border-radius: 8px; background: #f7f7f7;" class="d-flex flex-column align-items-center justify-content-center py-4 px-3">
          <img src="<?= base_url('assets/img/cloud-computing.png') ?>" width="64" class="mb-3" alt="cloud computing icon">
          <div class="d-flex flex-column align-items-center mb-3 text-center">
            <p class="text-muted mb-0 mr-2">Unggah foto atau gambar dari komputer. <strong class="text-primary" style="cursor: pointer;" id="choosePhotoDoc">Pilih file</strong></p>
            <p class="small text-muted mb-0">Ukuran file maksimal <strong class="text-dark">4MB</strong></p>
          </div>

          <div id="docFileName" class="py-2 px-3 d-none" style="border-radius: 4px; position: relative; overflow: hidden; background: #f0f0f0;"></div>

          <button type="submit" class="btn btn-secondary px-5" id="btnUploadDoc" disabled="disabled">Upload</button>
        </div>
      </div>
    </form>
  </div>
</div>