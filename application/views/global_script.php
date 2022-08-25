<script>
    // Toggle Switch Light/Dark Mode
    $(document).on('click', '#theme_mode', function(e) {
        if (this.checked) {
            $(this).attr('checked', true);
            switchTheme($(this).data('userid'), 1);
        } else {
            $(this).attr('checked', false);
            switchTheme($(this).data('userid'), 0);
        }
    });

    function switchTheme(id, themeMode) {
        $.ajax({
            url: `<?= site_url('mytheme/switch_theme') ?>`,
            method: 'POST',
            dataType: 'json',
            data: {
                userid: id,
                theme: themeMode
            },
            success: function(data) {
                if (data.status == 'OK') {
                    get_theme();
                }
            }
        });
    }

    function get_theme() {
        $.ajax({
            url: `<?= site_url('mytheme/get_theme') ?>`,
            dataType: 'json',
            cache: false,
            success: function(data) {
                $('#theme-style').attr('href', data.theme_style);
                if (data.theme_mode == 1) {
                    $('#theme_mode').attr('checked', true);
                } else {
                    $('#theme_mode').attr('checked', false);
                }
            }
        });
    }

    get_theme();

    function showConfirm() {
        $('#modalConfirmation').modal('show');
    }
</script>