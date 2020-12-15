<?php

return [
    'title'=> config('app.name'),
    'dashboard_url' => config('app.url'),
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
    ]
];
