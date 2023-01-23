<div class="text-center mb-3">
    <h3 class="mb-1">Selamat Datang</h3>
    <p class="text-muted mb-0">Silahkan login untuk mengakses dashboard</p>
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

<script>
    const loadingBar = 'assets/img/assets/img/gif/loading-white_bar.gif'
    const warningIcon = 'assets/img/warning.png'
    const btnSubmit = $('button[type="submit"]')

    const swAlert = (field, message) => {
        Swal.fire({
            html: `
                <div class="text-center">
                    <img src="${siteUrl()}/${warningIcon}" width="128px">
                    <h3>${field} Salah!</h3>
                    <p class="mb-2">${message}</p>
                </div>
            `,
            showCancelButton: false,
            confirmButtonText: 'Coba lagi!',
            confirmButtonColor: '#3085d6'
        });
    }

    const setAlertAccount = (message) => {
        Swal.fire({
            icon: 'warning',
            html: `
                <div class="text-center">
                    <h3>Akun anda telah di Nonaktikan!</h3>
                    <p class="mb-2 small text-secondary">${message}</p>
                </div>
            `,
            showCancelButton: false,
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#3085d6'
        })
    }


    /**
     * Set error message on form input validation
     * 
     * @params message | json
     */
    const setErrorMessages = (message) => {
        for (let i = 0; i < message.length; i++) {
            if (message[i].error_message == '') {
                $(`[name="${message[i].field}"]`).removeClass('is-invalid')
                $(`[name="${message[i].field}"]`).next().html('')
            } else {
                $(`[name="${message[i].field}"]`).addClass('is-invalid')
                $(`[name="${message[i].field}"]`).next().html(message[i].error_message)
            }
        }
    }


    /**
     * Set and show ajax response
     * 
     * @params response | json
     */
    const showResponse = (response) => {
        (response.status == 'validation_error') ? setErrorMessages(response.message) : 
        (response.status == 'account_disable') ? setAlertAccount(response.message) : 
        (response.status == 'success') ? window.location = response.data.redirect : 
        swAlert(response.data.form, response.message)
    }


    /**
     * Handle ajax login when form submited
     * 
     * @method POST
     * @params url|data
     * @return json 
     */
    const handleLoginSubmit = ({url, data}) => {
        // Show loading on button login
        btnSubmit.attr('disabled', true).html(`<img src="${siteUrl()}/${loadingBar}" width="28px" alt="loading">`)

        // Send ajax login request
        $.post(url, data).done(response => {
            btnSubmit.attr('disabled', false).text('Login')
            showResponse(response)
        })
        .fail(errors => console.log(errors))
    }


    /**
     * Remove validation message when user typing to input with on keyup event
     */
    $(document).on('keyup', '.form-control', function() {
        $(this).removeClass('is-invalid')
        $(this).next().html('')
    });


    /**
     * Run submit event and send the data to user login
     */
    $(document).on('submit', '#form-login', function(e) {
        e.preventDefault()
        handleLoginSubmit({url: $(this).attr('action'), data: $(this).serialize()})
    });
</script>