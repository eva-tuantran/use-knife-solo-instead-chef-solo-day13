<?php
return array(
    'register'   => 'register',
    'auth/login' => 'auth/login',  // The default route
    '_404_'      => 'auth/404',    // The main 404 route
    '_root_'     => array('welcome/hello', 'name' => 'hello'),
);

