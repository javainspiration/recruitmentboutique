<?php
include_once('conf.php');

class GeneralComments {

	private $con;
	private $filteredFields = [
		'genid',
	];

	private $fields = [
		'genid',
		'comments',
		'submitdate',
		'addedby',
		'vacancyid'
	];

	function __construct($con) {
		$this->con = $con;
	}

	function newComment() {
		$con = $this->con;
		$insertedFields = [];
		$insertedDatas = [];
		$res = array('error_code'=> 0,
			'error_msg' => '');

		foreach($_POST as $index => $value) {
			if (in_array($index, $this->fields)) {
				array_push($insertedFields, $index);
				array_push($insertedDatas, mysqli_real_escape_string($con, $value));
			}
		}

		try {
			$query = mysqli_query($con, "INSERT INTNO generalcomment (".$insertedFields.join(', ').")
			VALUE (".implode(', ', $filteredData).")");

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
				array_push($filteredData, $index.' = '.mysqli_real_escape_string($con, $value);
			}
		}

		$query = mysqli_query($con, "SELECT * FROM generalcomment
		WHERE 1=1
		".implode(' AND ', $filteredData)."
		 ORDER BY genid DESC LIMIT 50 ");
		$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

		$res['data'] = $result;

		echo json_encode($res);
	}
}

$method = '';
$gm = new GeneralComments($con);

if (isset($_GET['path'])) {
	$method = $_GET['path'];
}

if ($method == '') {
	$gm->getComments();
	exit;
}

$gm->$method();