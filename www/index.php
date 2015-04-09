<?php
/**
 * SamsonCMS Init script
 * @author Vitaly Iegorov <egorov@samsonos.com>
 */

/** Set current directory as project root */
if (!defined('__SAMSON_CWD__')) {
    define('__SAMSON_CWD__', dirname(__DIR__) . '/');
}

/** Set current directory url base */
if (!defined('__SAMSON_BASE__') && strlen(__DIR__) > strlen($_SERVER['DOCUMENT_ROOT'])) {
    define('__SAMSON_BASE__', '/'.basename(__SAMSON_CWD__) . '/');
}

/** Set default locale to - Russian */
if (!defined('DEFAULT_LOCALE')) {
    define('DEFAULT_LOCALE', 'ru');
}

/** Require composer autoloader */
if (!class_exists('samson\core\Core')) {
    require_once('../vendor/autoload.php');
}

/** Automatic parent web-application configuration read */
if (file_exists('../../../app/config')) {
    /** Special constant to disable local ActiveRecord configuration */
    define('EXTERNAL_CONFIG', true);
    // Signal core configure event
    \samsonphp\event\Event::signal('core.configure', array('../../../'.__SAMSON_CONFIG_PATH, __SAMSON_PUBLIC_PATH.__SAMSON_BASE__));
}

// Set supported locales
setlocales('en', 'ua', 'ru');

// Start SamsonPHP application
s()
    ->composer()
    ->subscribe('core.e404', 'default_e404')
    ->subscribe('core.routing', array(url(),'router'));

/** Automatic external SamsonCMS Application searching  */
if (file_exists('../../../src/')) {
    // Get reource map to find all modules in src folder
    foreach(\samson\core\ResourceMap::get('../../../src/')->modules as $module) {
        // We are only interested in SamsonCMS application ancestors
        if (in_array('samson\cms\App', class_parents($module[2])) !== false) {
            // Remove possible '/src/' path from module path
            if (($pos = strripos($module[1], '/src/')) !== false) {
                $module[1] = substr($module[1], 0, $pos);
            }
            // Load
            s()->load($module[1]);
        }
    }
}

/**
 * @deprecated Old styled main page rendering, must be build on events
 */
function oldMainRenderer(&$html)
{
    // Render application main page block
    foreach (\samson\cms\App::loaded() as $app) {
        // Show only visible apps
        if ($app->hide == false) {
            $html .= $app->main();
        }
    }
}

/**
 * @deprecated All application should draw menu block via events
 */
function oldMenuRenderer(&$html, &$subMenu)
{
    $html = '';

    // Iterate loaded samson\cms\application
    foreach (\samson\cms\App::loaded() as $app) {
        // Show only visible apps
        if ($app->hide == false) {
            // Render application menu item
            $html .= m()
                ->view('menu/item')
                ->active(url()->module == $app->id() ? 'active' : '')
                ->app($app)
                ->name(isset($app->name{0}) ? $app->name : (isset($app->app_name{0}) ? $app->app_name : ''))
                ->output();
        }
    }

    $subMenu = '';

    // Find current SamsonCMS application
    if (\samson\cms\App::find(url()->module, $app/*@var $app App*/)) {
        // Render main-menu application sub-menu
        $subMenu = $app->submenu();

        // If module has sub_menu view - render it
        if ($app->findView('sub_menu')) {
            $subMenu .= $app->view('sub_menu')->output();
        }
    }
}

// Old applications main page rendering
\samsonphp\event\Event::subscribe('template.main.rendered', 'oldMainRenderer');
// Old applications menu rendering
\samsonphp\event\Event::subscribe('template.menu.rendered', 'oldMenuRenderer');

s()->start('template');
