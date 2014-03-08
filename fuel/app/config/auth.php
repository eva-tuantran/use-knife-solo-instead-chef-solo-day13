<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * NOTICE:
 *
 * If you need to make modifications to the default configuration, copy
 * this file to your app/config folder, and make them in there.
 *
 * This will allow you to upgrade fuel without losing your custom config.
 */

return array(
    'driver'                 => 'BaseAuth',
    'verify_multiple_logins' => false, //@TODO: マルチログインの許可の動作確認
    'salt'                   => 'QFtx!k9kuZWS?QB1vCWmsJ%6r2mHkaEH3XRG12&&',
    'iterations'             => 10000,
);
