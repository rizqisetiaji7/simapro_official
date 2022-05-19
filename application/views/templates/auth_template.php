<!DOCTYPE html>
<html lang="ID">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="author" content="<?= $author ?>">
        <meta name="description" content="<?= $desc ?>">
        <meta name="robots" content="noindex, nofollow">
        <title><?= $title ?> | <?= $app_name ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="<?=base_url('assets/img/simapro/favicon.svg')?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

        <style type="text/css" media="screen">
            .submit-btn {
                background: #ff9b44;
                border: 0;
                border-radius: 4px;
                display: block;
                font-size: 17px;
                text-transform: capitalize;
                font-weight: 400;
                padding: 12px 24px;
                width: 100%;
                background: linear-gradient(to right, #ff9b44 0%, #fc6075 100%);
                background: -ms-linear-gradient(left, #ff9b44 0%, #fc6075 100%);
                background: -moz-linear-gradient(left, #ff9b44 0%, #fc6075 100%);
                background: -webkit-linear-gradient(left, #ff9b44 0%, #fc6075 100%);
                transition: all .3s ease;
            }

            .submit-btn:hover {
                border: 0;
                opacity: .9;
            }

            .remember-pass p a:hover {
                color: #ff9b44 !important;
            }
        </style>

        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/dist/sweetalert2.min.css') ?>">
        <script src="<?= base_url('assets/plugins/sweetalert2/dist/sweetalert2.min.js') ?>"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="assets/js/html5shiv.min.js"></script>
            <script src="assets/js/respond.min.js"></script>
        <![endif]-->

        <!-- JQuery -->
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    </head>
    <body>

        <?= $page_content; ?>

        <!-- Scripts -->
        <script src="<?= base_url('assets/js/popper.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/app.js') ?>"></script>
    </body>
</html>