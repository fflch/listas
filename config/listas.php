<?php
$footer = "
FFLCH | Faculdade de Filosofia, Letras e Ciências Humanas
";

return [
    'admins' => env('SENHAUNICA_ADMINS'),
    'mailman_domain' => env('MAILMAN_SUFFIX','@listas.usp.br'),
    'mailman_owner' => env('MAILMAN_OWNER','fflchsti@usp.br'),
    'mailman_footer' => mb_convert_encoding(env('MAILMAN_FOOTER',$footer), 'ISO-8859-1', 'UTF-8'),
];
