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
    function tampilProyekManajer() {
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

    // Jalankan fungsi tampilProyekManajer()
    tampilProyekManajer()
    
    function addProjectManager() {
        title.text('Tambah Proyek Manajer');
        formModal.attr('action', `<?= site_url('direktur/kelola_pm/tambah') ?>`);
        $.ajax({
            url: `<?= site_url('direktur/kelola_pm/show_form_add') ?>`,
            dataType: 'html',
            cache: false,
            success: function(data) {
                modalBody.html(data);
                modal.modal('show');
            }
        });
    }

    function editProjectManager(user_unique_id, user_role) {
        title.text('Edit Proyek Manajer');
        formModal.attr('action', `<?= site_url('direktur/kelola_pm/edit') ?>`);
        $.ajax({
            url: `<?= site_url('direktur/kelola_pm/show_form_edit') ?>`,
            dataType: 'html',
            method: 'POST',
            cache: false,
            data: {
                user_unique_id: user_unique_id, 
                user_role: user_role
            },
            success: function(data) {
                modalBody.html(data);
                modal.modal('show');
            }
        });
    }

    function deleteProjectManajer(unique_id, user_role, user_profile) {
        Swal.fire({
            icon: 'warning',
            html: `
                <h4>Anda Yakin akan menghapus Proyek Manajer?</h4>
                <p class="text-muted mb-0 small">Hal ini mungkin akan berpengaruh pada informasi proyek.</p>  
            `,
            confirmButtonText: 'Ya, Hapus',
            showCancelButton: true,
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `<?= site_url('direktur/kelola_pm/hapus') ?>`,
                    method: 'POST',
                    dataType: 'json',
                    cache: false,
                    data: { 
                        unique_id: unique_id,
                        user_role: user_role,
                        user_profile: user_profile
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: `${data.message}`,
                            confirmButtonText: 'Oke, Sip!',
                         }).then((result) => {
                            window.location.reload();
                         });
                        } else if (data.status == 'failed') {
                            Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: `${data.message}`,
                            showConfirmButton: false,
                            timer: 2000,
                         }).then((result) => {
                            window.location.reload();
                         });
                        }
                    }
                });
            }
        });
    }

    function changePasswordPM(unique_id, user_role) {
        title.text('Ubah Password');
        formModal.attr('action', `<?= site_url('direktur/kelola_pm/ubah_password') ?>`);
        $.ajax({
            url: `<?= site_url('direktur/kelola_pm/show_form_password') ?>`,
            dataType: 'html',
            method: 'POST',
            cache: false,
            data: {
                unique_id: unique_id, 
                user_role: user_role
            },
            success: function(data) {
                modalBody.html(data);
                modal.modal('show');
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
                      text: `${data.message}`
                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location.reload();
                      } else {
                        window.location.reload();
                      }
                    });
                } else {
                    modal.modal('hide');
                    Swal.fire({
                      icon: 'error',
                      title: 'Gagal',
                      text: `${data.message}`
                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location.reload();
                      } else {
                        window.location.reload();
                      }
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