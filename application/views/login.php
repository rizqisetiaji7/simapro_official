<div class="container">
    <div class="row min-vh-100">
        <div class="col-sm-12 col-md-8 col-lg-5 m-auto">
            <div class="d-flex flex-column align-items-center justify-content-center mb-4">
                <img src="<?= base_url('assets/img/simapro/logo-text.svg') ?>" class="mt-4 mb-4" width="320" alt="">
                <div class="text-center">
                    <h3 class="mb-1">Selamat Datang</h3>
                    <p class="text-muted mb-0">Silahkan login untuk mengakses dashboard</p>
                </div>
            </div>
            
            <div class="card mx-2 mb-0">
                <div class="card-body py-4 px-5">
                    <form id="form-login" action="<?= site_url('login/login_process') ?>" method="POST">
                        <div class="form-group mt-1">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Alamat email" autofocus autocomplete="off">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <a class="text-muted" href="<?= site_url('forgot_password') ?>">Lupa password?</a>
                                </div>
                            </div>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password" autofocus>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary submit-btn" type="submit" name="login">Login</button>
                        </div>
                    </form>
                </div>
            </div>

            <?= $footer_copyright; ?>
        </div>
    </div>
</div>

<script>
    const swAlert = (field, message) => {
        Swal.fire({
            html: `
                <div class="text-center">
                    <img src="<?= base_url('assets/img/warning.png') ?>" width="128px">
                    <h3>${field} Salah!</h3>
                    <p class="mb-2">${message}</p>
                </div>
            `,
            showCancelButton: false,
            confirmButtonText: 'Coba lagi!',
            confirmButtonColor: '#3085d6'
        });
    }

    $(document).on('keyup', '.form-control', function(e) {
        $(this).removeClass('is-invalid');
        $(this).next().html('');
    });

    $(document).on('submit', '#form-login', function(e) {
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
                btnSubmit.attr('disabled', false).text('Login');
            },
            success: function(response) {
                if (response.status == 'validation_error') {
                    for (let i = 0; i < response.message.length; i++) {
                        if (response.message[i].error_message == '') {
                            $(`[name="${response.message[i].field}"]`).removeClass('is-invalid');
                            $(`[name="${response.message[i].field}"]`).next().html('');
                        } else {
                            $(`[name="${response.message[i].field}"]`).addClass('is-invalid');
                            $(`[name="${response.message[i].field}"]`).next().html(response.message[i].error_message);
                        }
                    }
                } else if (response.status == 'success') {
                    window.location = response.data.redirect;
                } else {
                    swAlert(response.data.form, response.message);
                }
            }
        });
    });

</script>