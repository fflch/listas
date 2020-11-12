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
        [
            'text' => 'Pessoas Autorizadas',
            'url'  => '/users',
            'can'  => 'authorized'
        ],
        [
            'text' => 'Consultas (Queries)',
            'url'  => '/consultas',
            'can'  => 'authorized'
        ],
        [
            'text' => 'Listas Dinâmicas',
            'url'  => '/listas_dinamicas',
            'can'  => 'authorized'
        ],
        [
            'text' => 'Gerar Emails',
            'url'  => '/emails',
            'can'  => 'authorized'
        ],
    ]
];
