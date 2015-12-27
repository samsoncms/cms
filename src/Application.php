<?php 
namespace samsoncms\cms;

use samson\activerecord\dbQuery;
use samson\core\CompressableExternalModule;
use samson\pager\Pager;
use samsonphp\event\Event;

/**
 * SamsonCMS external compressible application for integrating
 * @author Vitaly Iegorov <egorov@samsonos.com>
 */
class Application extends CompressableExternalModule {
    /** @var string Module identifier */
    protected $id = 'cms';

    protected $isCMS = false;

    public function isCMS()
    {
        return $this->isCMS;
    }

    public function init( array $params = array() ) {
        Event::subscribe('core.security', array($this, 'updateTemplate'));
        // Old applications main page rendering
        Event::subscribe('template.main.rendered', array($this, 'oldMainRenderer'));
        // Old applications menu rendering
        Event::subscribe('template.menu.rendered', array($this, 'oldMenuRenderer'));

        Event::subscribe('samson.url.build', array($this, 'buildUrl'));
        // Call parent initialization
        return parent::init( $params );
    }

    public function buildUrl(& $urlObj, & $httpHost, & $urlParams)
    {
        $index = 0;
        if (isset($urlParams[$index]) && (\samson\core\SamsonLocale::current() == $urlParams[$index])) {
            $index = 1;
        }
        if ( isset( $urlParams[$index] ) && ( strpos($urlParams[$index], 'cms-') === 0 ) ) {
            $urlParams[$index] = str_replace('cms-', '', $urlParams[$index]);
            array_unshift($urlParams, 'cms');
        }
    }

    public function updateTemplate($core, $securityResult) {
        if ($this->isCMS) {
            $core->template($this->path().'app/view/index.php', true);
        }
    }

    public function initUrl( & $urlObj, & $urlArgs ) {
        if($urlArgs[0] == 'cms') {
            $this->isCMS = true;
            if (isset($urlArgs[1])) {
                if (strpos($urlArgs[1], 'samsoncms_') !== 0){
                    $urlArgs[1] = 'cms-'.$urlArgs[1];
                }
                unset($urlArgs[0]);
                $urlArgs = array_values($urlArgs);
            }
        }
    }

    public function initResources(& $resourceRouter, $moduleId, & $approve)
    {
        if ($moduleId == 'core') return true;
        if ($this->isCMS) {
            $approve = false;
            if (isset(m($moduleId)->composerParameters['composerName'])&&
                isset(m('cms')->composerParameters['required'])&&
                in_array(m($moduleId)->composerParameters['composerName'], m('cms')->composerParameters['required'])){
                $approve = true;
            }
        }

    }

    public function __base()
    {
        $this->active(m('template'));

        m('template')->__handler();
    }

    public function oldMainRenderer(&$html)
    {
        // Render application main page block
        foreach (\samsoncms\Application::loaded() as $app) {
            // Show only visible apps
            if ($app->hide == false && $app->findView('sub_menu')) {
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
                $subMenu .= $app->view('sub_menu')->output();
            }
        }
    }

    /**
     * @deprecated
     * @return string Page title
     */
    public function oldGetTitle()
    {
        $local = m('local');
        $current = m();
        return isset($current['title']) ? $current['title'] :
            (isset($local['title']) ? $local['title'] : '');
    }
}
