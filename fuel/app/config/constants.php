<?php

defined('VALID_RECORD')   || define('VALID_RECORD'  , 1);
defined('INVALID_RECORD') || define('INVALID_RECORD', 99);

defined('REGISTER_STATUS_INACTIVATED') || define('REGISTER_STATUS_INACTIVATED', 0);
defined('REGISTER_STATUS_ACTIVATED')   || define('REGISTER_STATUS_ACTIVATED'  , 1);
defined('REGISTER_STATUS_STOPPED')     || define('REGISTER_STATUS_STOPPED'    , 2);
defined('REGISTER_STATUS_BANNED')      || define('REGISTER_STATUS_BANNED'     , 3);

defined('DEFAULT_EMAIL')        || define('DEFAULT_EMAIL'     , 'info@rakuichi-rakuza.jp');
defined('DEFAULT_EMAIL_NAME')   || define('DEFAULT_EMAIL_NAME', '楽市楽座 運営事務局');
defined('ADMIN_EMAIL')          || define('ADMIN_EMAIL', 'h_kobayashi@aucfan.com'); // @TODO とりあえず

defined('LOCATION_REGISTER_TYPE_ADMIN') || define('LOCATION_REGISTER_TYPE_ADMIN',   1);
defined('LOCATION_REGISTER_TYPE_USER')  || define('LOCATION_REGISTER_TYPE_USER',    2);


defined('STATUS_LOGIN_SUCCESS')              || define('STATUS_LOGIN_SUCCESS',             0);
defined('STATUS_LOGIN_DENIED')               || define('STATUS_LOGIN_DENIED',              1);
defined('STATUS_SESSION_EXPIRED')            || define('STATUS_SESSION_EXPIRED',           2);
defined('STATUS_LOGOUT_SUCCESS')             || define('STATUS_LOGOUT_SUCCESS',            3);
defined('STATUS_PROFILE_CHANGE_SUCCESS')     || define('STATUS_PROFILE_CHANGE_SUCCESS',    4);
defined('STATUS_PROFILE_CHANGE_FAILED')      || define('STATUS_PROFILE_CHANGE_FAILED',     5);
defined('STATUS_FLEAMARKET_CANCEL_SUCCESS')  || define('STATUS_FLEAMARKET_CANCEL_SUCCESS', 6);
defined('STATUS_FLEAMARKET_CANCEL_FAILED')   || define('STATUS_FLEAMARKET_CANCEL_FAILED',  7);

defined('STATUS_PASSWORD_CHANGE_SUCCESS')     || define('STATUS_PASSWORD_CHANGE_SUCCESS',    8);
defined('STATUS_PASSWORD_CHANGE_FAILED')      || define('STATUS_PASSWORD_CHANGE_FAILED',     9);
defined('STATUS_PASSWORD_CHANGE_TIMEOUT')     || define('STATUS_PASSWORD_CHANGE_TIMEOUT',   10);

defined('STATUS_X')  || define('STATUS_X', 1);

return array();
