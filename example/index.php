<?php

$array = ['ricardo@teste.com', 'teste@teste.com'];
header('Content-type: application/json');

$headers = apache_request_headers();

//if($headers['Authorization'] == "123"){

	echo json_encode($array);
//}
?>