<?php
include_once('conf.php');

class CommentCandidates {

	private $con, $auth, $key;
	private $filteredFields = [
		'candidateid',
	];

	private $fields = [
		'commentid',
		'comments',
		'submitdate',
		'candidateid',
		'userid',
		'status'
	];

	function __construct($con, $auth, $key) {
		$this->con = $con;
		$this->auth = $auth;
		$this->key = $key;
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

	function newComment() {
		$con = $this->con;
		$insertedFields = [];
		$insertedDatas = [];
		$res = array('error_code'=> 0,
			'error_msg' => '');

		unset($_POST['commentid']);

		//get user id
		$auth = $this->getAuth();
		if (count($auth) > 0) {
			$_POST['userid'] = $auth[0]['id'];
		}

		$query = mysqli_query($con, "SELECT commentid+1 as commentid FROM commentcandidate ORDER BY commentid DESC LIMIT 1");
		$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

		$_POST['commentid'] = $result[0]['commentid'];

		foreach($_POST as $index => $value) {
			if (in_array($index, $this->fields)) {
				array_push($insertedFields, $index);
				array_push($insertedDatas, "'".mysqli_real_escape_string($con, $value)."'");
			}
		}

		try {

			$query = mysqli_query($con, "INSERT INTO commentcandidate(".implode(', ', $insertedFields).")
			VALUE (".implode(', ', $insertedDatas).")");

			if (!$query) {
				$res['error_code'] = 201;
				$res['error_msg'] = 201;
			}

		} catch (Exception $e){
			$res['error_code'] = 201;
			$res['error_msg'] = $e;
		}

		echo json_encode($res);
	}

	function getComments() {
		$con = $this->con;

		$filteredData = [];

		foreach($_POST as $index => $value) {
			if (in_array($index, $this->filteredFields)) {
				array_push($filteredData, $index.' = '.mysqli_real_escape_string($con, $value));
			}
		}

		$query = mysqli_query($con, "SELECT * FROM commentcandidate
		WHERE
		".implode(' AND ', $filteredData)."
		 ORDER BY submitdate DESC LIMIT 50 ");

		$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

		$res['data'] = $result;

		echo json_encode($res);
	}
}

$method = '';
$gm = new CommentCandidates($con, $auth, $key);

if (isset($_GET['path'])) {
	$method = $_GET['path'];
}

if ($method == '') {
	$gm->getComments();
	exit;
}

$gm->$method();