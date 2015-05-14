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
        public $name = 'samsonsos.com';
        public $login = 'samsonos';
        public $pwd = 'AzUzrcVe4LJJre9f';
    }
}
