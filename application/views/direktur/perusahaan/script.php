<script>
    const modal = $('#modalCompany');
    const title = $('#modalCompanyTitle');
    const modalDialog = $('#modalCompany .modal-dialog');
    const modalBody = $('#modalCompany .modal-body');
    const formModal = $('#form_modal_company');
    const btnSubmit = $('#btnCompany-submit');

    $(document).on('keyup', '.form-control', function(e) {
        $(this).removeClass('is-invalid');
        $(this).next().html('');
    });

    $(document).on('change', '.formSelect', function(e) {
        $(this).removeClass('is-invalid');
        $(this).next().html('');
    });

    // Choose file from computer
    chooseFile('#chooseFileImage', '#inputProfile');

    $(document).on('change', '#inputProfile', function() {
        if (this.files && this.files[0]) {
            // Get and display filename
            $('#profileFileName').removeClass('d-none');
            $('#profileFileName').addClass('mb-3').html(`<p class="mb-0 small text-muted">Gambar: <strong class="text-dark">${this.files[0].name}</strong></p>`);
        }
    });

    // Tampil Data Proyek Manajer
    function showProjectManager() {
        $.ajax({
            url: `<?=site_url('direktur/kelola_pm/tampil_pm') ?>`,
            method: 'POST',
            dataType: 'html',
            cache: false,
            success: function(data) {
                $('#dataProyekManajer').html(data);
            }
        });
    }

    // Jalankan fungsi showProjectManager()
    showProjectManager();
    
    function addProjectManager() {
        title.text('Tambah Proyek Manajer');
        formModal.attr('action', `<?= site_url('direktur/kelola_pm/tambah') ?>`);
        $.ajax({
            url: `<?= site_url('direktur/kelola_pm/form_tambah') ?>`,
            dataType: 'html',
            cache: false,
            beforeSend: function() {
                modalBody.html(`<p class="text-secondary mb-0">Memuat konten...</p>`);
            },
            success: function(data) {
                modalBody.empty();
                modalBody.html(data);
            }
        });
        modal.modal({
            show: true,
            backdrop: 'static'
        });
    }

    function editProjectManager(user_unique_id, user_role) {
        title.text('Edit Proyek Manajer');
        formModal.attr('action', `<?= site_url('direktur/kelola_pm/edit') ?>`);
        $.ajax({
            url: `<?= site_url('direktur/kelola_pm/form_edit') ?>`,
            dataType: 'html',
            method: 'POST',
            cache: false,
            data: {
                user_unique_id: user_unique_id, 
                user_role: user_role
            },
            beforeSend: function() {
                modalBody.html(`<p class="text-secondary mb-0">Memuat konten...</p>`);
            },
            success: function(data) {
                modalBody.empty();
                modalBody.html(data);
            }
        });
        modal.modal({
            show: true,
            backdrop: 'static'
        });
    }

    function disable_account(user_id, unique_id) {
        Swal.fire({
            icon: 'warning',
            html: `
                <h4>Nonaktifkan Proyek Manajer?</h4>
                <p class="text-muted mb-1 small">Anda akan Nonaktifkan akun proyek manajer.</p>
                <p class="text-danger small mb-0">Hal ini mungkin akan berpengaruh pada proyek yang sedang berjalan.</p>  
            `,
            confirmButtonText: 'Nonaktikan',
            showCancelButton: true,
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `<?= site_url('direktur/kelola_pm/disable_akun') ?>`,
                    method: 'POST',
                    dataType: 'json',
                    cache: false,
                    data: { 
                        user_id: user_id,
                        unique_id: unique_id,
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: `${data.message}`,
                            showConfirmButton: false,
                            timer: 2000
                         }).then((result) => {
                            showProjectManager();
                         });
                        } else if (data.status == 'failed') {
                            Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: `${data.message}`,
                            showConfirmButton: false,
                            timer: 2000
                         }).then((result) => {
                            showProjectManager();
                         });
                        }
                    }
                });
            }
        });
    }

    function enable_account(user_id, unique_id) {
        $.ajax({
            url: `<?= site_url('direktur/kelola_pm/enable_akun') ?>`,
            method: 'POST',
            dataType: 'json',
            cache: false,
            data: { 
                user_id: user_id,
                unique_id: unique_id,
            }, 
            success: function(data) {
                if (data.status == 'success') {
                    Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: `${data.message}`,
                    showConfirmButton: false,
                    timer: 2000
                 }).then((result) => {
                    showProjectManager();
                 });
                } else if (data.status == 'failed') {
                    Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: `${data.message}`,
                    showConfirmButton: false,
                    timer: 2000
                 }).then((result) => {
                    showProjectManager();
                 });
                }
            }
        });
    }

    formModal.on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: new FormData(this),
            beforeSend: function() {
                btnSubmit.attr('disabled', true).text('Menyimpan...')
            },
            complete: function() {
                btnSubmit.attr('disabled', false).text('Simpan')
            },
            success: function(data) {
                if (data.status == 'validation_error') {
                    for (let i = 0; i < data.message.length; i++) {
                        if (data.message[i].err_message == '') {
                            $(`[name="${data.message[i].field}"]`).removeClass('is-invalid');
                            $(`[name="${data.message[i].field}"]`).next().html('');
                        } else {
                            $(`[name="${data.message[i].field}"]`).addClass('is-invalid');
                            $(`[name="${data.message[i].field}"]`).next().html(data.message[i].err_message);
                        }
                    }
                } else if (data.status == 'success') {
                    modal.modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: `${data.message}`,
                        showConfirmButton: false,
                        timer: 2000
                    }).then((result) => {
                        showProjectManager();
                    });
                } else {
                    modal.modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: `${data.message}`,
                        showConfirmButton: false,
                        timer: 2000
                    }).then((result) => {
                        showProjectManager();
                    });
                }
            }
        })
    });

    modal.on('hidden.bs.modal', function() {
        title.empty();
        modalDialog.removeClass('modal-lg');
        modalBody.empty();
        formModal.removeAttr('action');
        btnSubmit.text('Simpan');
    });
</script>