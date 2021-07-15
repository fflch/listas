<?php

$right_menu = [     
    [
        'text' => '<i class="fas fa-hard-hat"></i>',
        'title' => 'Logs',
        'target' => '_blank',
        'url' => config('app.url') . '/logs',
        'align' => 'right',
        'can' => 'admin',
    ],
];

return [
    'skin' => env('USP_THEME_SKIN', 'uspdev'),
    'title'=> config('app.name'),
    'app_url' => config('app.url'),
    'logout_method' => 'POST',
    'logout_url' => config('app.url') . '/logout',
    'login_url' => config('app.url') . '/login',
    'menu' => [
        [
            'text' => 'Listas',
            'url'  => '/listas',
            'can'  => 'admin'
        ],
        [
            'text' => 'Pessoas Autorizadas',
            'url'  => '/users',
            'can'  => 'authorized'
        ],
        [
            'text' => 'Consultas',
            'url'  => '/consultas',
            'can'  => 'admin'
        ],
        [
            'text' => 'Gerar Emails',
            'url'  => '/emails',
            'can'  => 'authorized'
        ],
        [
            'text' => 'Subscriptions',
            'url'  => '/subscriptions',
            'can'  => 'authorized'
        ],        
    ],
    'right_menu' => $right_menu,
];
