<?php
namespace cms;

/**
 * Created by Vitaly Iegorov <egorov@samsonos.com>
 * on 19.08.14 at 16:05
 */
if (!defined('EXTERNAL_CONFIG')) {
    /** Test ActiveRecord configuration for development */
    class ActiveRecordConfig extends \samson\core\Config
    {
        public $name = 'samsonos.com';
        public $login = 'samsonos';
        public $pwd = 'AzUzrcVe4LJJre9f';

        public $relations = array(
            array('material', 'material', 'company_id', 0, 'MaterialID', 'productcompany')
        );
    }
}
