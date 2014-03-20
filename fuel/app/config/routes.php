<?php
return array(
    '_root_'     => 'index',
    '_404_'      => 'error/404',
    'signup'     => 'signup',
    'login'      => 'login',
    'fleamarket' => 'fleamarket',
    'search/(:num)'   => 'search/index/$1',
    'detail/(:num)'   => 'search/detail/$1',
    'mypage'     => 'mypage',
    'errors'     => 'errors',
    '_404_'      => 'errors/notfound',    // The main 404 route
);
