<!DOCTYPE html>
<html>

    <head>
        <title><?php echo oldGetTitle() ?> - SamsonCMS</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="icon" type="image/png" href="favicon.png">
    </head>

    <body id="<?php v('id')?>" class="samsoncms">
        <?php m('template')->render('menu')?>

        <section id="template-container">
            <?php m()->render()?>
        </section>
    </body>

</html>
