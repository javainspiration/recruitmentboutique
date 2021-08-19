<?php
//get route
$availablePages = array('vacancies', 'candidates','generalcomments', 'commentcandidates', 'dashboard', 'auth', 'profile', 'credit');

if (!isset($_SERVER['HTTP_PAGE'])) {
	exit;
}
$page = $_SERVER['HTTP_PAGE'];

if (!in_array($page, $availablePages)) {
	exit;
}

if (isset($_SERVER['HTTP_AUTH'])) {
	$auth = $_SERVER['HTTP_AUTH'];
}

include_once($page.'.php');