<?php
/**
 * Created by PhpStorm.
 * User: nazarenko
 * Date: 20.10.2014
 * Time: 12:21
 */
namespace samsoncms;

/** Конфигурация для SocialEmail */
class SocialEmailConfig extends \samsonphp\config\Entity
{
    public $__module = 'socialemail';

    public $hashAlgorithm = 'md5';

    public $hashLength = 32;

    public $dbHashEmailField = 'md5_email';

    public $dbHashPasswordField = 'md5_password';

    public $dbConfirmField = 'confirmed';

    public $initHandler = array('samsoncms\app\signin\Application', 'authorize');
}