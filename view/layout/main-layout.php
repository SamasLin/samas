<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="icon" href="<?=IMG_PATH?>/ico.ico">
        <title><?php echo $page_title; ?></title>
        <!-- head js lib -->
        <script src="<?=JS_PATH?>/jquery/jquery-1.9.1.js"></script>
        <script src="<?=JS_PATH?>/jquery-form/jquery.form.js"></script>
        <script src="<?=JS_PATH?>/jquery-ui/js/jquery-ui-1.10.2.custom.min.js"></script>
        <script src="<?=JS_PATH?>/konami/jquery.konami.js"></script>
        <script src="<?=JS_PATH?>/pjax/jquery.pjax.js"></script>
        <script src="<?=JS_PATH?>/masonry/jquery.masonry.min.js"></script>
        <!-- head css lib -->
        <link href="<?=CSS_PATH?>/bootstrap/css/bootstrap-responsive.min.css" type="text/css" rel="stylesheet"></link>
        <link href="<?=CSS_PATH?>/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet"></link>
        <link href="<?=JS_PATH?>/jquery-ui/css/dark-hive/jquery-ui-1.10.2.custom.min.css" type="text/css" rel="stylesheet"></link>
        <!-- site js -->
        <script src="<?=JS_PATH?>/main.js"></script>
        <!-- site css -->
        <link rel="stylesheet" href="<?=CSS_PATH?>/main.css"></link>
    </head>
    <body>
        <div id="system-message"></div>
        <h1>&nbsp;</h1>
        <h4>&nbsp;</h4>
        <div id="main-section">
            <?php
            WebService::renderNav($nav_config, $url);
            include $view_path;
            ?>
        </div>
        <footer class="footer" style="text-align:center">
            <h1>&nbsp;</h1>
            <div id="footer-signature">
                <div id="footer-signature-text">designed by Samas Lin</div>
            </div>
            <h1>&nbsp;</h1>
        </footer>
        <!-- foot js lib -->
        <script src="<?=CSS_PATH?>/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>