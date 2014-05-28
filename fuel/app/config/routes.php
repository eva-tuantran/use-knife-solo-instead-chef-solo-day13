<?php
return array(
    'calender/kaijoichiran/kaijou'  => 'redirector/index',
    '_root_'    => 'top/index',
    'admin'     => 'admin/index/login',
    'signup'    => 'signup',
    'login'     => 'login',
    'location/(:num)' => 'location/detail/$1',
    'fleamarket/(:num)' => 'fleamarket/index/$1',
    'search/(:num)'     => 'search/index/$1',
    'detail/(:num)'     => 'search/detail/$1',
    'calendar/:year/:month' => 'calendar/index',
    'mypage'    => 'mypage',
    'errors'    => 'errors',
    '_404_'     => 'errors/notfound',    // The main 404 route
);
