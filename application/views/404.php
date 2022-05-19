<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="<?= $title ?>">
        <meta name="author" content="<?= $author ?>">
        <meta name="robots" content="noindex, nofollow">
        <title><?= $title .' | '. $author ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/simapro/favicon.svg') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
        
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="assets/js/html5shiv.min.js"></script>
            <script src="assets/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="error-page">
        <div class="main-wrapper">
            <div class="error-box">
                <h1>404</h1>
                <h3><?= $heading ?></h3>
                <p><?= $message ?></p>
                <a href="<?= $redirect_url ?>" class="btn btn-custom px-5">Back to Dashboard</a>
            </div>
        </div>
    </body>
</html>