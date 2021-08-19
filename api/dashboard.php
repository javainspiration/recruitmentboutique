<?php
include_once('conf.php');

class Dashboard {

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

	function getDashboard() {
		$con = $this->con;

		$filteredData = [];

		$users = $this->getAuth();
		
		if (!$users) {
			exit;
		}

		$users = $users[0];
		
		$_POST['username'] = $users['username'];

		foreach($_POST as $index => $value) {
			if (in_array($index, $this->filteredFields)) {
				array_push($filteredData, $index.' = "'.mysqli_real_escape_string($con, $value).'"');
			}
		}
		$query = mysqli_query($con, "select sum(x.totalCompleteVacancies) as totalCompleteVacancies, sum(x.totalProgressVacancies) as totalProgressVacancies, sum(x.totalCandidates) as totalCandidates 
			from 
				(SELECT COUNT(*) as totalCompleteVacancies, 0 as totalProgressVacancies, 0 as totalCandidates  FROM vacancies WHERE 1=1 AND status = 'Complete' AND ".$filteredData[0]."
				UNION ALL
				SELECT 0 as totalCompleteVacancies, COUNT(*) as totalProgressVacancies, 0 as totalCandidates FROM vacancies WHERE 1=1 AND status != 'Complete' AND ".$filteredData[0]."
				UNION ALL
				SELECT 0 as totalCompleteVacancies, 0 as totalProgressVacancies, COUNT(*) as totalCandidates FROM candidates c JOIN vacancies v ON c.vacancyid = v.id  WHERE 1=1 AND ".$filteredData[0]."
				) 
			as x");
		
		$result = mysqli_fetch_all($query, MYSQLI_ASSOC);
		
		$res['data'] = array (
			'totalCompleteVacancies' => $result[0]['totalCompleteVacancies'],
			'totalProgressVacancies' => $result[0]['totalProgressVacancies'],
			'totalCandidates' => $result[0]['totalCandidates'],
			'totalCredits' => $users['credits'],
		);
		
		//var_dump(json_encode($res));
		echo json_encode($res);
	}

	function updateVacancies() {
		$con = $this->con;
		$updatedData = [];
		$res = array('error_code'=> 0,
			'error_msg' => '');

		if (!isset($_POST['id'])) {
			echo json_encode(array('error_code' => 201));
			exit;
		}

		foreach($_POST as $index => $value) {
			if (in_array($index, $this->fields)) {
				array_push($updatedData, $index.' = '.mysqli_real_escape_string($con, $value));
			}
		}

		try {
			$query = mysqli_query($con, "UPDATE vacancies
			SET
			".implode(', ', $filteredData)."
			 WHERE id =  ".mysqli_real_escape_string($con, $_POST['id']));

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

	function newVacancy() {
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
			$query = mysqli_query($con, "INSERT INTNO vacancies (".$insertedFields.join(', ').")
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
}

$method = '';
$dashboard = new Dashboard($con, $key, $auth);

if (isset($_GET['path'])) {
	$method = $_GET['path'];
}

if ($method == '') {
	$dashboard->getDashboard();
	exit;
}

$dashboard->$method();