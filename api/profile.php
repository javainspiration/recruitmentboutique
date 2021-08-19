<?php
include_once('conf.php');

class Profle {

	private $con, $key;

	function __construct($con, $key, $auth = '') {
		$this->con = $con;
		$this->key = $key;
		$this->auth = $auth;
	}

	function getProfile() {
		$con  = $this->con;
		$auth = $this->auth;
		$query = mysqli_query($con, "SELECT id, email, username, credits, concat(firstname, lastname) as name, firstname,lastname,organisation FROM users WHERE md5(concat(id, '".$this->key."')) = '".mysqli_real_escape_string($con, $auth)."' ");

		if (mysqli_num_rows($query) < 1) {
			return false;
		}

		$profile  = mysqli_fetch_all($query, MYSQLI_ASSOC);
		echo json_encode($profile);
	}
}

$method = '';
$profile = new Profle($con, $key, $auth);
$profile->getProfile();