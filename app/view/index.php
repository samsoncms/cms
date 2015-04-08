<!DOCTYPE html>
<html>

    <head>
        <title><?php v('title'); ?> - SamsonCMS</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="content-language" content="<?php echo locale()?>" />
        <link rel="icon" type="image/png" href="favicon.png">
        <?php m('i18n')->render('meta')?>
    </head>

    <body id="<?php v('id')?>">
        <?php m('template')->render('menu')?>
        <?php m('template')->render('container')?>
    </body>

</html>