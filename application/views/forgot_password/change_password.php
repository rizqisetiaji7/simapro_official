<div class="text-center mb-3">
    <h3 class="mb-1">Buat password baru</h3>
    <p class="text-muted mb-0">Silahkan isi form berikut untuk mengganti password</p>
</div>

<div class="card mx-2 mb-0">
    <div class="card-body py-4 px-5">
        <form id="form-newPass" action="<?= site_url('save_password') ?>" method="POST">
            <input type="hidden" name="key_ID" value="<?= $key_id ?>">
            <div class="form-group mt-1">
                <label for="new_password">Password baru <span class="text-danger">*</span></label>
                <input type="password" id="new_password" name="new_password" class="form-control" autofocus>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Konfirmasi password <span class="text-danger">*</span></label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <button class="btn btn-primary submit-btn" type="submit" name="reset_pass">Reset password</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).on('keyup', '.form-control', function(e) {
        $(this).removeClass('is-invalid');
        $(this).next().empty();
    });
    
    $(document).on('submit', '#form-newPass', function(e) {
        e.preventDefault();
        const btnSubmit = $('.submit-btn');
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            cache: false,
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function() {
                btnSubmit.attr('disabled', true).html(`<img src="<?= base_url('assets/img/gif/loading-white_bar.gif') ?>" width="28px" alt="loading">`);
            },
            complete: function() {
                btnSubmit.attr('disabled', false).text('Reset password');
            },
            success: function(response) {
                if (response.status == 'validation_error') {
                    console.log(response);
                    for (let i = 0; i < response.message.length; i++) {
                        if (response.message[i].error_message == '') {
                            $(`[name="${response.message[i].field}"]`).removeClass('is-invalid');
                            $(`[name="${response.message[i].field}"]`).next().empty();
                        } else {
                            $(`[name="${response.message[i].field}"]`).addClass('is-invalid');
                            $(`[name="${response.message[i].field}"]`).next().html(response.message[i].error_message);
                        }
                    }
                } else if (response.status == 'success'){
                    Swal.fire({
                        icon: 'success',
                        html: `
                            <div class="text-center">
                                <h3>${response.title}</h3>
                                <p class="mb-2">${response.message}</p>
                            </div>
                        `,
                        showCancelButton: false,
                        confirmButtonText: 'Login sekarang',
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = response.redirect;
                        } else {
                            window.location = response.redirect;
                        }
                    });
                }
            }
        });
    });

</script>