<!DOCTYPE html>
<html lang="ID">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="site_url" content="<?= trim(site_url(), '/') ?>">
        <meta name="author" content="<?= $author ?>">
        <meta name="description" content="<?= $desc ?>">
        <meta name="robots" content="noindex, nofollow">
        <title><?= $title ?> | <?= $app_name ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="<?=base_url('assets/img/simapro/favicon.svg')?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/libs/fontawesome-6.1.1/css/all.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/libs/line-awesome-1.3.0/css/line-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/dataTables.bootstrap4.min.css') ?>">
        <!-- lightgallery -->
        <link rel="stylesheet" href="<?= base_url('assets/plugins/lightGallery/dist/css/lightgallery.css')?>"/>
        <link rel="stylesheet" href="<?= base_url('assets/plugins/lightGallery/dist/css/lg-zoom.css')?>"/>
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>" id="theme-style">
        <link rel="stylesheet" href="<?= base_url('assets/css/mycustom.css')?>">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="assets/js/html5shiv.min.js"></script>
            <script src="assets/js/respond.min.js"></script>
        <![endif]-->

        <!-- JS -->
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/dataTables.bootstrap4.min.js') ?>"></script>
        <script src="<?= base_url('assets/plugins/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
        <script src="<?= base_url('assets/plugins/lightGallery/dist/lightgallery.min.js') ?>"></script>
        <script src="<?= base_url('assets/plugins/lightGallery/dist/plugins/zoom/lg-zoom.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/MY_Functions.js') ?>"></script>
        <script src="https://js.pusher.com/7.1/pusher.min.js"></script>
        <script>
            const siteUrl = () => document.querySelector('meta[name=site_url]').getAttribute('content')
        </script>
    </head>
    <body>
        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <?php $this->view('templates/header'); ?>
            <?php 
                if (user_login()->user_role == 'direktur') {
                    $this->view('templates/sidebar/sidebar_direktur');
                } else if (user_login()->user_role == 'pm') {
                    $this->view('templates/sidebar/sidebar_pm');
                } 
            ?>
            
            <div class="page-wrapper">
                <?php if ($this->uri->segment(1) == 'chatbox') { ?>
                    <?= $page_content; ?>
                <?php } else { ?>
                    <div class="content container-fluid">
                        <?= $page_content; ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <?php $this->view('modal/modal_logout'); ?>
        
        <!-- Scripts -->
        <script src="<?= base_url('assets/js/popper.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/jquery.slimscroll.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/app.js') ?>"></script>
    </body>
</html>