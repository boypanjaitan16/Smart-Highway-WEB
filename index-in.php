<?php
$userData       = null;
$displayPicture = null;

if (isset($_SESSION[$session]['token'])) {
    $userData       = (object) $_SESSION[$session];
    $displayPicture = file_exists("../_img/profile/img.jpg") ? "../_img/profile/img.jpg" : $assets->getLimitless()."images/placeholder.jpg";
}
else{
    session_destroy();
    die();
}

$tmg        = new helper\Timing();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - <?= $config->getProjectName() ?></title>
    <base href="<?= $config->getBaseUrl() ?>"/>
    <!-- Global stylesheets -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900">
    <link rel="stylesheet" type="text/css" href="<?= $assets->getLimitless() ?>css/icons/icomoon/styles.css">
    <link rel="stylesheet" type="text/css" href="<?= $assets->getLimitless() ?>css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= $assets->getLimitless() ?>css/core.css">
    <link rel="stylesheet" type="text/css" href="<?= $assets->getLimitless() ?>css/components.css">
    <link rel="stylesheet" type="text/css" href="<?= $assets->getLimitless() ?>css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?= $assets->getFontAwesome() ?>css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="_css/style.css"/>

    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/loaders/blockui.min.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/notifications/bootbox.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/visualization/d3/d3.min.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/visualization/d3/d3_tooltip.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/ui/headroom/headroom.min.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/ui/headroom/headroom_jquery.min.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/ui/nicescroll.min.js"></script>

    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/core/app.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/pages/layout_fixed_custom.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/pages/layout_navbar_hideable_sidebar.js"></script>

    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/media/fancybox.min.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/pages/gallery.js"></script>
    <!-- /theme JS files -->

</head>
<body class="navbar-top">

<!-- Main navbar -->
<div class="navbar navbar-inverse navbar-fixed-top bg-indigo">
    <div class="navbar-header">
        <a class="navbar-brand" href=""><b><?= $config->getProjectName() ?></b></a>

        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav">
            <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>

        <div class="navbar-right">
            <p class="navbar-text">Selamat <?= $tmg->greeting() ?>, <?= explode(' ',$userData->name)[0] ?>!</p>
            <p class="navbar-text"><span class="label bg-success-400">Online</span></p>
        </div>
    </div>
</div>
<!-- /main navbar -->


<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
        <div class="sidebar sidebar-main sidebar-fixed">
            <div class="sidebar-content">

                <!-- User menu -->
                <div class="sidebar-user-material">
                    <div class="category-content">
                        <div class="sidebar-user-material-content">
                            <a href="javascript:;"><img src="<?= $assets->getLimitless() ?>images/placeholder.jpg" class="img-circle img-responsive" alt=""></a>
                            <h6><?= $userData->name ?></h6>
                        </div>

                        <div class="sidebar-user-material-menu">
                            <a href="#user-nav" data-toggle="collapse"><span>My account</span> <i class="caret"></i></a>
                        </div>
                    </div>

                    <div class="navigation-wrapper collapse" id="user-nav">
                        <ul class="navigation">
                            <li><a href="javascript:;" data-plugin="action" data-url="_action/adminHandler.php" data-values="action=logout" data-warning="Apakah anda yakin ingin keluar sekarang?" data-onfinish="reload"><i class="icon-switch2"></i> <span>Logout</span></a></li>
                            <li><a href="profile"><i class="icon-user-tie"></i> <span>My Profile</span></a></li>
                        </ul>
                    </div>
                </div>
                <!-- /user menu -->


                <!-- Main navigation -->
                <div class="sidebar-category sidebar-category-visible">
                    <div class="category-content no-padding">
                        <ul class="navigation navigation-main navigation-accordion">

                            <!-- Main -->
                            <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main Menus"></i></li>
                            <li><a href=""><i class="icon-home"></i> <span>Dashboard</span></a></li>
                            <li><a href="member"><i class="icon-users"></i> <span>Member</span></a></li>
                            <li>
                                <a href=""><i class="icon-road"></i> <span>Jalan Tol</span></a>
                                <ul>
                                    <li><a href="jalan">Daftar Jalan</a> </li>
                                    <li><a href="jalan/tambah">Tambah Jalan</a> </li>
                                </ul>
                            </li>
                            <li><a href="aktivitas"><i class="icon-history"></i> <span>Catatan Aktivitas</span></a></li>
                            <li>
                                <a href="topup"><i class="icon-coins"></i> <span>Top-up Saldo</span></a>
                                <ul>
                                    <li><a href="topup/0">Status Menunggu</a></li>
                                    <li><a href="topup/1">Status disetujui</a> </li>
                                </ul>
                            </li>
                            <li><a href="message"><i class="icon-alert"></i> <span>Kirim Pesan</span></a></li>
                            <!--- /Main-->
                        </ul>
                    </div>
                </div>
                <!-- /main navigation -->

            </div>
        </div>
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Content area -->
            <div class="content">

                <?php
                if (empty($url->getByIndex(0))) {
                    echo '
                        <h3 class="text-semibold text-center">Selamat datang di panel Administrator, '.$userData->name.'</h3>
                    ';
                }
                else{
                    $file   = '_link/'.$url->getByIndex(0).'.php';
                    if (file_exists($file)){
                        include ($file);
                    }
                    else{
                        echo '
                            <div class="alert alert-danger">The page you\'re try to access is not exists !</div>
                        ';
                    }
                }
                ?>
                <!-- Footer -->
                <div class="footer text-muted">
                    &copy; <?= date("Y") ?>. Copyright by SMART HIGHWAY. All rights reserved
                </div>
                <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->
<script type="text/javascript" src="<?= $assets->getJQueryForm() ?>"></script>
<script type="text/javascript" src="<?= $assets->getSweetAlert() ?>sweetalert.min.js"></script>
<script type="text/javascript" src="../../cdn/js/_default.js"></script>
<script type="text/javascript" src="../../cdn/js/_action.js"></script>
<script type="text/javascript" src="_js/script.js"></script>
</body>
</html>