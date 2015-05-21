<?php
/**
 * Created by Vitaly Iegorov <egorov@samsonos.com>
 * on 19.08.14 at 16:05
 */
namespace samsoncms\config;

// If this is single SamsonCMS web-application
if (!defined('EXTERNAL_CONFIG')) {
    /** Test ActiveRecord configuration for development */
    class ActiveRecordConfig extends \samsonphp\config\Entity
    {
        public $name = 'samsonos.com';
        public $login = 'root';
        public $pwd = 'Vovan2912';
    }
}
