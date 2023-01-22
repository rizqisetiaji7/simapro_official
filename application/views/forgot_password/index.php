<div class="text-center mb-3">
    <h3 class="mb-1">Lupa password?</h3>
    <p class="text-muted mb-0">Masukkan email Anda untuk melakukan pergantian password.</p>
</div>

<div class="card mx-2 mb-0">
    <div class="card-body py-4 px-5">
        <form id="form-verif" action="<?= site_url('send_email_verify') ?>" method="POST">
            <div class="form-group">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Alamat email anda" autofocus autocomplete="off">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary submit-btn" name="reset_password">Kirim</button>
            </div>
        </form>

        <div class="text-center mt-4 remember-pass">
            <p class="mb-0">Ingat password? <a href="<?= site_url('login') ?>" class="text-primary">Login sekarang</a></p>
        </div>
    </div>
</div>

<script>
    $(document).on('keyup', '.form-control', function(e) {
        $(this).removeClass('is-invalid');
        $(this).next().html('');
    });
    
    $(document).on('submit', '#form-verif', function(e) {
        e.preventDefault();
        const url = $(this).attr('action');
        const method = $(this).attr('method');
        const btnSubmit = $('button[type="submit"]');

        $.ajax({
            url: url,
            method: method,
            dataType: 'json',
            cache: false,
            data: $(this).serialize(),
            beforeSend: function() {
                btnSubmit.attr('disabled', true).html(`<img src="<?= base_url('assets/img/gif/loading-white_bar.gif') ?>" width="28px" alt="loading">`);
            },
            complete: function() {
                btnSubmit.attr('disabled', false).text('Kirim');
            },
            success: function(response) {
                if (response.status == 'validation_error') {
                    if (response.message.error_message == '') {
                        $('#email').removeClass('is-invalid');
                        $('#email').next().html('');
                    } else {
                        $('#email').addClass('is-invalid');
                        $('#email').next().html(response.message.error_message);
                    }
                } else if (response.status == 'error') {
                    if (response.message == '') {
                        $('#email').removeClass('is-invalid');
                        $('#email').next().html('');
                    } else {
                        $('#email').addClass('is-invalid');
                        $('#email').next().html(response.message);
                    }
                } else if (response.status == 'failed') {
                    Swal.fire({
                        icon: 'error',
                        html: `
                            <div class="text-center">
                                <h3>Gagal mengirim!</h3>
                                <p class="mb-2">${response.message}</p>
                            </div>
                        `,
                        showCancelButton: false,
                        confirmButtonText: 'Coba lagi',
                        confirmButtonColor: '#3085d6'
                    });
                } else if (response.status == 'success'){
                    // If success
                    Swal.fire({
                        icon: 'success',
                        html: `
                            <div class="text-center">
                                <h3>${response.title}</h3>
                                <p class="mb-2 small">${response.message}</p>
                            </div>
                        `,
                        showCancelButton: false,
                        confirmButtonText: 'Kembali ke login',
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#email').val('');
                            window.location = response.redirect;
                        } else {
                            window.location = response.redirect;
                        }
                    });
                } else if (response.status == 'account_disable') {
                    Swal.fire({
                        icon: 'warning',
                        html: `
                            <div class="text-center">
                                <h3>Akun anda telah di Nonaktikan!</h3>
                                <p class="mb-2 small text-secondary">${response.message}</p>
                            </div>
                        `,
                        showCancelButton: false,
                        confirmButtonText: 'Tutup',
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