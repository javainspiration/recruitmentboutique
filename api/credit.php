<?php
include_once('conf.php');

class Credits {

	private $con, $key;

	private $filteredFields = [
		'username'
	];

	function __construct($con, $key, $auth = '') {
		$this->con = $con;
		$this->key = $key;
		$this->auth = $auth;
	}

	function getAuth() {
		$con  = $this->con;
		$auth = $this->auth;
		$query = mysqli_query($con, "SELECT id, email, username, credits FROM users WHERE md5(concat(id, '".$this->key."')) = '".mysqli_real_escape_string($con, $auth)."' ");

		if (mysqli_num_rows($query) < 1) {
			return false;
		}

		return mysqli_fetch_all($query, MYSQLI_ASSOC);
	}

	function payCredit() {
		$con = $this->con;

		$filteredData = [];

		$users = $this->getAuth();
		if (!$users) {
			exit;
		}

		$users = $users[0];

		$username = $users['username'];
		$kredit = (int)$_POST['kredit'];
		$idtrx = $_POST['idtrx'];

		$res['error_code'] = 201;

		$query = mysqli_query($con, "UPDATE user SET credits = credit+'$kredit' where username = '$username'");
		$query1 = mysqli_query($con, "UPDATE credit_payment_temp SET payment_status = 'Completed' where id = '$idtrx'");

		if ($query) {
			$res['error_code'] = 0;
			$res['content'] = md5($users['id']);
		}

		echo json_encode($res);
	}

	function savePay() {
		$con = $this->con;

		$filteredData = [];

		$users = $this->getAuth();
		if (!$users) {
			exit;
		}

		/*$users = $users[0];
		$_POST['username'] = $users['username'];
		*/
		//$res['error_code'] = '';

		$query = mysqli_query($con, "INSERT INTO credit_payment_temp(total_credit, amount, submitdate, userid, promo_code, payment_status)
			VALUE('".mysqli_real_escape_string($con, $_POST['total_credit'])."', '".mysqli_real_escape_string($con, $_POST['amount'])."', now(), '".mysqli_real_escape_string($con, $_POST['userid'])."', '".mysqli_real_escape_string($con, $_POST['promo_code'])."', 'temp')");

		if ($query) {
		//if(mysqli_affected_rows($con) >0 ){
			while($row = mysqli_fetch_assoc($query)) {
			   	$res['error_code'] = 0;
				$res['id'] = $row['id'];
				$res['content'] = md5($users['id']);
			}
		}else{
			$res['error_code'] = 201;
		}

		echo json_encode($res);
	}

	function cekPromo() {
		$con = $this->con;

		$res['error_code'] = 201;
		$code = $_POST['promo_code'];

		$query = mysqli_query($con, "select value from promo where promo_code = '$code'");

		if ($query) {
			while($row = mysqli_fetch_assoc($query)) {
			   	$res['value'] = $row['value']; 
				$res['error_code'] = 0;
			}
		}else{
			$res['error_code'] = 201;
			$res['value'] = 0;
		}
		

		echo json_encode($res);
	}
}

$method = '';
$credit = new Credits($con, $key, $auth);

if (isset($_GET['path'])) {
	$method = $_GET['path'];
}

if ($method == '') {
	exit;
}

$credit->$method();