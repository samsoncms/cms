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

    public function init( array $params = array() ) {
        // Call parent initialization
        return parent::init( $params );
    }

    public function initUrl( & $urlObj, & $urlArgs ) {
        if(($urlArgs[0] == 'cms')&&(isset($urlArgs[1]))) {
            $urlArgs[1] = 'cms-'.$urlArgs[1];
            unset($urlArgs[0]);
        }
    }

    public function __base()
    {
        s()->template('app/view/index.php');
        s()->active(m('template'));
        m('template')->__handler();


    }
}