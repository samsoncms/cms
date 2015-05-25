#[SamsonCMS](http://samsoncms.com)

[![Latest Stable Version](https://poser.pugx.org/samsoncms/cms/v/stable.svg)](https://packagist.org/packages/samsoncms/cms)
[![Build Status](https://scrutinizer-ci.com/g/samsoncms/cms/badges/build.png?b=master)](https://scrutinizer-ci.com/g/samsoncms/cms/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/samsoncms/cms/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/samsoncms/cms/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/samsoncms/cms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/samsoncms/cms/?branch=master) 
[![Total Downloads](https://poser.pugx.org/samsoncms/cms/downloads.svg)](https://packagist.org/packages/samsoncms/cms)
[![Stories in Ready](https://badge.waffle.io/samsoncms/cms.png?label=ready&title=Ready)](https://waffle.io/samsoncms/cms)

> Modular, event-driven content management system based on [SamsonPHP](http://samsonphp.com) framework.

##Installation 
* First of all you must get working [Composer](http://getcomposer.org).
* Use ```php composer.phar create-project --prefer-dist -s dev samsoncms/cms [your_path]``` for automatic installation of SamsonCMS and all of its dependencies.
* After you should configure your web-server document root to ```[your_path]/www``` 
* If see this errors: 
Предупреждение:/www/www.egorov/cms.local/vendor/samsonos/php_activerecord/src/dbMySQLConnector.php, стр. 617mkdir() mkdir(): Permission denied
Предупреждение:/www/www.egorov/cms.local/vendor/samsonos/php_activerecord/src/dbMySQLConnector.php, стр. 648file_put_contents() file_put_contents(/www/www.egorov/cms.local/www/cache/activerecord/metadata/classes_4da49c55b681b2c168b093f7a8d675cc.php): failed to open stream: No such file or directory
Предупреждение:/www/www.egorov/cms.local/vendor/samsonos/php_activerecord/src/dbMySQLConnector.php, стр. 649file_put_contents() file_put_contents(/www/www.egorov/cms.local/www/cache/activerecord/metadata/func_4da49c55b681b2c168b093f7a8d675cc.php): failed to open stream: No such file or directory
Предупреждение:/www/www.egorov/cms.local/vendor/samsonos/php_core/src/Module.php, стр. 541mkdir() mkdir(): Permission denied
Предупреждение:/www/www.egorov/cms.local/vendor/samsonos/php_resourcer/src/ResourceRouter.php, стр. 133file_put_contents() file_put_contents(/www/www.egorov/cms.local/www/cache/resourcer/3cbb19e2b29e1b1fd2496d11509be67b.map): failed to open stream: No such file or directory
Предупреждение:/www/www.egorov/cms.local/vendor/samsonos/php_core/src/Module.php, стр. 541mkdir() mkdir(): Permission denied
Предупреждение:/www/www.egorov/cms.local/vendor/samsonos/php_resourcer/src/ResourceRouter.php, стр. 195
* Create a folder ```[your_path]/www/cache``` with writing rights to web-server process


##Roadmap
* Give ability to easily change theme and design in SamsonCMS and its modules.
* Add symfony2 support
* Add internal help/docs system

Developed by [SamsonOS](http://samsonos.com/)
