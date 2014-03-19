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


return array();
