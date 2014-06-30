<?php
return array(
    'calender/kaijoichiran/kaijou'  => 'redirector/index',
    '_root_'    => 'top/index',
    '_404_'     => 'errors/notfound',
    'admin'     => 'admin/index/login',
    'signup'    => 'signup',
    'login'     => 'login',
    'inquiry'   => 'inquiry',
    'location/(:num)'   => 'location/detail/$1',
    'fleamarket/(:num)' => 'fleamarket/index/$1',
    'fleamarket' => 'fleamarket/index',
    'search'     => 'search/index',
    'detail/(:num)'     => 'search/detail/$1',
    'reservation'       => 'reservation',
    'calendar/:year/:month' => 'calendar/index',
    'mypage'    => 'mypage',
    'reminder'  => 'reminder',
    'info'      => 'info',
    'errors'    => 'errors',
    '([a-z]+|[a-z]+-[a-z]+)' =>  function ($request) {
        $area = $request->uri->segment(1);
        if (in_array($area, \Config::get('master.alphabet_regions'))
            || in_array($area, \Config::get('master.alphabet_prefectures'))
        ) {
            return \Request::forge('search/index/' . $area, false)->execute();
        } else {
            throw new HttpNotFoundException();
        }
    },
);
