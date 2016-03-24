<!DOCTYPE html>
<html>

    <head>
        <title><?php echo m('cms')->oldGetTitle(); ?> - SamsonCMS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="icon" type="image/png" href="favicon.png">
    </head>

    <body id="<?php v('id')?>" class="samsoncms">
        <?php m('template')->render('menu')?>

        <section id="template-container">
            <?php m()->render()?>
        </section>
        <div id="loader-text" style="display: none"><?php t('Загрузка формы') ?></div>
    </body>

</html>
