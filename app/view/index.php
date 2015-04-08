<!DOCTYPE html>
<html lang="<?php echo locale()?>">

    <head>
        <title><?php v('title'); ?> - SamsonCMS</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="icon" type="image/png" href="favicon.png">
        <?php m('i18n')->render('meta')?>
    </head>

    <body id="<?php v('id')?>">
        <?php m('template')->render('menu')?>
        <?php m('template')->render('container')?>
    </body>

</html>