<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $config->getProjectName() ?></title>
    <base href="<?= $config->getBaseUrl() ?>">
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?= $assets->getLimitless() ?>css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?= $assets->getLimitless() ?>css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?= $assets->getLimitless() ?>css/core.css" rel="stylesheet" type="text/css">
    <link href="<?= $assets->getLimitless() ?>css/components.css" rel="stylesheet" type="text/css">
    <link href="<?= $assets->getLimitless() ?>css/colors.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?= $assets->getSweetAlert() ?>sweetalert.css"/>
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/loaders/blockui.min.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/notifications/bootbox.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/forms/styling/uniform.min.js"></script>

    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/core/app.js"></script>
    <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/pages/login.js"></script>
    <!-- /theme JS files -->
    <style>
        body .fr-box div:last-child a[href*="https://www.froala.com/wysiwyg-editor"]{
            display:none !important;
        }

        body a[href*="https://www.000webhost.com/"]{
            display:none !important;
        }
    </style>
</head>
<body class="login-container">


<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">

                <!-- Simple login form -->
                <form action="_action/adminHandler.php" method="post" data-onfinish="reload" id="loginForm">
                    <input type="hidden" name="action" value="login">
					
                    <div class="panel panel-body login-form">
                        <div class="text-center">
                            <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                            <h5 class="content-group">Login to your Admin account <small class="display-block">Enter your credentials below</small></h5>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input type="text" name="username" class="form-control" placeholder="Username">
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" data-plugin="submit" data-target="#loginForm" class="btn bg-pink-400 btn-block">Sign in</button>
                        </div>
                    </div>
                </form>
                <!-- /simple login form -->


                <!-- Footer -->
                <div class="footer text-muted text-center">
                    &copy; <?= date("Y") ?>. TravellerSumut . All right reserved
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
</body>
</html>