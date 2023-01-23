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
    const loadingBar = 'assets/img/gif/loading-white_bar.gif'
    const btnSubmit = $('button[type="submit"]')


    // Show alert when email failed to send
    const showAlertFailed = ({title, message}) => {
        Swal.fire({
            icon: 'error',
            html: `
                <div class="text-center">
                    <h3>${title}</h3>
                    <p class="mb-2">${message}</p>
                </div>
            `,
            showCancelButton: false,
            confirmButtonText: 'Coba lagi',
            confirmButtonColor: '#3085d6'
        })
    }


    /**
     * Set & show error message on form input validation
     * 
     * @params response | json
     */
    const showErrorMessages = (response) => {
        if (response.message.error_message == '') {
            $(`#${response.message.field}`).removeClass('is-invalid')
            $(`#${response.message.field}`).next().html('')
        } else {
            $(`#${response.message.field}`).addClass('is-invalid')
            $(`#${response.message.field}`).next().html(response.message.error_message)
        }
    }


    /**
     * Set & show error message when request failed or success
     * 
     * @params {title, message, redirect} | json
     * @params icon, btnText | string
     */
    const showAlertMessage = ({title, message, redirect}, icon, btnText) => {
        Swal.fire({
            icon: icon,
            html: `<div class="text-center"><h3>${title}</h3><p class="mb-2 small">${message}</p></div>`,
            showCancelButton: false,
            confirmButtonText: btnText,
            confirmButtonColor: '#3085d6'
        }).then(result => {
            $('#email').val('')
            (result.isConfirmed) ? window.location = redirect : window.location = redirect
        })
    }


    /**
     * Set and show ajax response
     * 
     * @params response | json
     */
    const setResponse = (response) => {
        (response.status == 'validation_error') ? showErrorMessages(response) : 
        (response.status == 'error') ? showErrorMessages(response) : 
        (response.status == 'failed') ? showAlertFailed(response) : 
        (response.status == 'account_disable') ? 
            showAlertMessage(response, 'error', 'Coba lagi') : 
            showAlertMessage(response, 'success', 'Kembali ke login') // status success
    }


    /**
     * Handle event to send verification to email on submit
     * 
     * @method POST
     * @params url, data
     * @return json 
     */
    const sendEmailVerify = ({url, data}) => {
         // Show loading on button
        btnSubmit.attr('disabled', true).html(`<img src="${siteUrl()}/${loadingBar}" width="28px" alt="loading">`)

        // Send ajax login request
        $.post(url, data).done(response => {
                btnSubmit.attr('disabled', false).text('Kirim')
                setResponse(response)
            })
            .fail(errors => console.log(errors))
    }


    /**
     * Remove validation message when user typing to input with on keyup event
     */
    $(document).on('keyup', '.form-control', () => {
        $(this).removeClass('is-invalid')
        $(this).next().html('')
    })
    
    
    /**
     * Run submit event and send email verification
     */
    $(document).on('submit', '#form-verif', function(e) {
        e.preventDefault()
        sendEmailVerify({ url: $(this).attr('action'), data: $(this).serialize() })
    })

</script>