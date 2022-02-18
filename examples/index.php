<?php

$array = ['teste1@teste.com', 'teste2@teste.com'];
header('Content-type: application/json');

$headers = apache_request_headers();

if($headers['Authorization'] == "123"){

	echo json_encode($array);
}
?>