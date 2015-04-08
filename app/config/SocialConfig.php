<?php
/**
 * Created by PhpStorm.
 * User: nazarenko
 * Date: 20.10.2014
 * Time: 12:20
 */
namespace samsoncms;

class SocialConfig extends \samsonphp\config\Entity
{
    public $__module = 'social';

    public $dbTable = '\samson\activerecord\user';

    public $hashAlgorithm = 'md5';

    public $hashLength = 32;
}