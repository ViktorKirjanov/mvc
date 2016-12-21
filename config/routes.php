<?php
return array(
//    '' => 'main/main',
    'help' => 'help/other/',
//    'offers/view/([0-9]+)' => 'offers/view/$1',                 //single offer
    'offers/view/[0-9]{1,2}' => 'offers/view/$1',                 //single offer



    'offers' => 'offers/index/',
//    '' => 'main/index',
    'signup' => 'user/signup',
    'login' => 'user/login',
//    'logout' => 'user/logout',
//        'offers/create'=> 'offers/create',

//    'offers/list/([0-9]+)'=> 'offers/list/$1',      //offers by page and quantity per page

//        'offers'=> 'offers/index',
);