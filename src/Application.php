<?php
namespace samsoncms\cms;

use samson\core\CompressableExternalModule;
use samsonphp\event\Event;
use samsonphp\router\Module;

/**
 * SamsonCMS external compressible application for integrating
 * @author Vitaly Iegorov <egorov@samsonos.com>
 */
class Application extends CompressableExternalModule
{
    const EVENT_IS_CMS = 'samsonsms.is.cms';

    /** @var string Module identifier */
    public $id = 'cms';

    public $baseUrl = 'cms';

    /** @var bool Flag that currently we are woring in SamsonCMS */
    protected $isCMS = false;

    public function init(array $params = array())
    {
        //trace('cmsInit');
        // Old applications main page rendering
        Event::subscribe('template.main.rendered', array($this, 'oldMainRenderer'));
        // Old applications menu rendering
        Event::subscribe('template.menu.rendered', array($this, 'oldMenuRenderer'));

        Event::subscribe('samson.url.build', array($this, 'buildUrl'));

        Event::subscribe('samson.url.args.created', array($this, 'parseUrl'));

        Event::subscribe(Module::EVENT_ROUTE_FOUND, array($this, 'activeModuleHandler'));

        Event::subscribe('samsonphp.router.create.module.routes', array($this, 'updateCMSPrefix'));

        //[PHPCOMPRESSOR(remove,start)]
        $moduleList   = $this->system->module_stack;
        foreach ($this->system->module_stack as $id => $module) {
            if (!$this->isModuleDependent($module) && $id != 'core' && !$this->ifModuleRelated($module)) {
                unset($moduleList[$id]);
            }
        }

        // Generate resources for new module
        $this->system->module('resourcer')->generateResources($moduleList, $this->path() . 'app/view/index.php');
        //[PHPCOMPRESSOR(remove,end)]

        // Call parent initialization
        return parent::init($params);
    }

    /**
     * If module is dependent from current module through composer.json.
     *
     * @param $module Module for checking
     * @return bool True if module dependent
     */
    protected function isModuleDependent($module)
    {
        return isset($module->composerParameters['composerName']) && in_array($module->composerParameters['composerName'], $this->composerParameters['required']);
    }

    public function isCMS()
    {
        return $this->isCMS;
    }

    public function activeModuleHandler($module)
    {
        // Define if routed module is related to SamsonCMS
        if($this->isCMS = $this->ifModuleRelated($module)){
            // TODO: This should be removed - Reparse url
            url()->parse();

            // Switch template to SamsonCMS
            $this->system->template($this->path() . 'app/view/index.php', true);

            Event::fire(self::EVENT_IS_CMS, array(&$this));
        }
    }

    /**
     * Callback for adding SamsonCMS related modules prefix to routes.
     *
     * @param $module
     * @param $prefix
     */
    public function updateCMSPrefix($module, &$prefix)
    {
        if (($module->id != $this->id) && $this->ifModuleRelated($module)) {
            $prefix = '/' . $this->baseUrl . $prefix;
        }
    }

    public function buildUrl(&$urlObj, &$httpHost, &$urlParams)
    {
        if ($this->isCMS) {
            array_unshift($urlParams, $this->baseUrl);
        }
    }

    public function parseUrl(&$urlObj, &$urlArgs)
    {
        if ($this->isCMS) {
            array_shift($urlArgs);
        }
    }

    /**
     * Check if passed module is related to SamsonCMS.
     * Also method stores data to flag variable.
     *
     * @param $module
     *
     * @return bool True if module related to SamsonCMS
     */
    public function ifModuleRelated($module)
    {
        // Analyze if module class or one of its parents has samsoncms\ namespace pattern
        return sizeof(preg_grep('/samsoncms\\\\/i', array_merge(array(get_class($module)), class_parents($module))));
    }

    public function __base()
    {
        $templateModule = $this->system->module('template');

        // Switch system to SamsonCMS template module
        $this->system->active($templateModule);

        // Call template handler
        $templateModule->__handler();
    }

    public function oldMainRenderer(&$html)
    {
        // Render application main page block
        foreach (\samsoncms\Application::loaded() as $app) {
            // Show only visible apps
            if ($app->hide == false /*&& $app->findView('sub_menu')*/) {
                $html .= $app->main();
            }
        }
    }

    /**
     * @deprecated All application should draw menu block via events
     */
    public function oldMenuRenderer(&$html, &$subMenu)
    {
        // Iterate loaded samson\cms\application
        foreach (\samsoncms\Application::loaded() as $app) {
            // Show only visible apps
            if ($app->hide == false) {
                // Render application menu item
                $html .= m('template')
                    ->view('menu/item')
                    ->active(url()->module == $app->id() ? 'active' : '')
                    ->app($app)
                    ->icon($app->icon)
                    ->name(isset($app->name{0}) ? $app->name : '')
                    ->output();
            }
        }
        $subMenu = '';
        // Find current SamsonCMS application
        if (\samsoncms\Application::find(url()->module, $app/*@var $app App*/)) {
            // If module has sub_menu view - render it
            if ($app->findView('sub_menu')) {
                // Explode url by symbols '/'
                $url = explode('/', $_SERVER['REQUEST_URI']);
                // If isset url with params search and param page equal 0
                if (isset($url[4]) && $url[3] != 'form') {
                    // Default value for search field
                    $paramSearch = '';
                    // Default value for search field
                    $paramSearch = urldecode($url[4]);
                    // Set params search
                    $app->search($paramSearch);
                }
				
                $subMenu .= $app->view('sub_menu')->set(t($app->name, true), 'appName')->output();
            }
        }
    }

    /**
     * @deprecated
     * @return string Page title
     */
    public function oldGetTitle()
    {
        $local   = m('local');
        $current = m();

        return isset($current['title']) ? $current['title'] :
            (isset($local['title']) ? $local['title'] : '');
    }
}
