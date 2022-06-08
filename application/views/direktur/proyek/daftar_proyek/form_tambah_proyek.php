<input type="hidden" name="project_code_ID" value="<?= $project_code_ID ?>">
<input type="file" name="profile_image" id="inputProfile" accept=".jpg,.png,.jpeg" class="d-none">
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
            <label for="project_name">Nama Proyek <span class="text-danger small">*</span></label>
            <input type="text" id="project_name" name="project_name" class="form-control" autocomplete="off" placeholder="Ketik nama proyek...">
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
            <label for="ID_pm">Manajer Proyek (Penanggung jawab)</label>
            <select name="ID_pm" class="custom-select formSelect">
                <option value="">-- Pilih --</option>
                <?php foreach ($project_man as $pm) { ?>
                <option value="<?= $pm->user_id ?>"><?= $pm->user_fullname ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="project_address">Alamat Proyek <span class="text-muted small">(Opsional)</span></label>
            <input type="text" id="project_address" name="project_address" class="form-control" autocomplete="off" placeholder="Ketik nama proyek...">
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
            <label for="project_description">Deskripsi Proyek <span class="text-muted small">(Opsional)</span></label>
            <textarea name="project_description" id="project_description" class="form-control" rows="4" placeholder="Deskripsi proyek..."></textarea>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="project_start">Mulai Pengerjaan <span class="text-danger small">*</span></label>
                <input type="date" class="form-control" name="project_start" id="project_start">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group col-6">
                <label for="project_deadline">Berakhir Pada <span class="text-danger small">*</span></label>
                <input type="date" class="form-control" name="project_deadline" id="project_deadline">
                <div class="invalid-feedback"></div>
            </div>
        </div>
    </div>
</div>