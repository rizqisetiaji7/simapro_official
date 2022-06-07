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

    // Add Data Company
    // function addCompanyModal(maincompid=null) {
    //     title.text('Tambah anak perusahaan');
    //     modalDialog.addClass('modal-lg');
    //     formModal.attr('action','tambah');
    //     hiddenId.attr('value', maincompid);

    //     $.ajax({
    //         url: `<?= site_url('direktur/perusahaan/show_form') ?>`,
    //         method: 'POST',
    //         dataType: 'html',
    //         data: {modal_type: 'add'},
    //         success: function(data) {
    //             modalBody.html(data);
    //             modal.modal('show');
    //         },
    //         error: function(xhr) {
    //             alert('Oops! Terjadi kesalahan pada server! silahkan coba beberapa saat.');
    //             modal.modal('hide');
    //         }
    //     });
    // }

    // function editCompanyModal(company_id, comp_parent_id) {
    //     title.text('Ubah data anak perusahaan');
    //     modalDialog.addClass('modal-lg');
    //     formModal.attr('action','edit');
    //     btnSubmit.text('Update');
    //     hiddenId.attr('value', company_id);

    //     $.ajax({
    //         url: `<?= site_url('direktur/perusahaan/show_form') ?>`,
    //         method: 'POST',
    //         dataType: 'html',
    //         data: {
    //             modal_type: 'edit',
    //             company_id: company_id,
    //             parent_id: comp_parent_id
    //         },
    //         success: function(data) {
    //             modalBody.html(data);
    //             modal.modal('show');
    //         },
    //         error: function(xhr) {
    //             alert('Oops! Terjadi kesalahan pada server! silahkan coba beberapa saat.');
    //             modal.modal('hide');
    //         }
    //     });
    // }

    // Choose file from computer
    chooseFile('#chooseFileImage', '#inputProfile');

    $(document).on('change', '#inputProfile', function() {
        if (this.files && this.files[0]) {
            // Get and display filename
            $('#profileFileName').removeClass('d-none');
            $('#profileFileName').addClass('mb-3').html(`<p class="mb-0 small text-muted">Gambar: <strong class="text-dark">${this.files[0].name}</strong></p>`);
        }
    });
    
    function addProjectManager() {
        title.text('Tambah Proyek Manajer');
        formModal.attr('action', `<?= site_url('direktur/proyek_manajer/tambah') ?>`);
        $.ajax({
            url: `<?= site_url('direktur/proyek_manajer/show_form_add') ?>`,
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
        formModal.attr('action', `<?= site_url('direktur/proyek_manajer/edit') ?>`);
        $.ajax({
            url: `<?= site_url('direktur/proyek_manajer/show_form_edit') ?>`,
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

    function changePasswordPM(unique_id, user_role) {
        title.text('Ubah Password');
        formModal.attr('action', `<?= site_url('direktur/proyek_manajer/ubah_password') ?>`);
        $.ajax({
            url: `<?= site_url('direktur/proyek_manajer/show_form_password') ?>`,
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