<?php
$footer = "
FFLCH | Faculdade de Filosofia, Letras e Ciências Humanas
";

return [
    'admins' => env('SENHAUNICA_ADMINS'),
    'mailman_domain' => env('MAILMAN_SUFFIX','@listas.usp.br'),
    'mailman_owner' => env('MAILMAN_OWNER','fflchsti@usp.br'),
    'mailman_footer' => utf8_decode(env('MAILMAN_FOOTER',$footer)),
];
