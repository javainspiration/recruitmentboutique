<?php

header('Content-Type: application/json');

$con = mysqli_connect('213.171.200.67', 'boutique', 'B0ut!Qu3', 'boutiquedb');
//$con = mysqli_connect('localhost', 'root', '', 'rb');

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit();
}

$res = array(
	'error_code' => 0,
	'error_msg' => ''
);

$key = 'r3cru!tmentboutique2021';