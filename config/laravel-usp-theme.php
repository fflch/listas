<?php

return [
    'title'=> 'Listas FFLCH',
    'dashboard_url' => '/',
    'logout_method' => 'GET',
    'logout_url' => '/logout',
    'login_url' => '/login',
    'menu' => [
        [
            'text' => 'Início',
            'url'  => '/',
        ],
        [
            'text' => 'Listas',
            'url'  => '/listas',
            'can'  => 'admin'
        ],

    ]
];
