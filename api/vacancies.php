<?php
include_once('conf.php');

class Vacancies {

	private $con;
	private $filteredFields = [
		'username',
		'id',
		'vacancy_id'
	];
	private $fields = [
		'id',
		'clientref',
		'companyname',
		'consultant',
		'jobtitle',
		'permcontract',
		'location',
		'contractlength',
		'salary',
		'benefit',
		'numberreq',
		'startdate',
		'tasks',
		'essentialqual',
		'additionalqual',
		'healthrisk',
		'limitcv',
		'email',
		'username',
		'priority',
		'submitdate',
		'status',
		'completedate',
		'filename',
		'salarytext',
		'companywebsite',
		'includecv',
		'relocationsupport',
		'equivalentvoc',
		'comparablesectors',
		'comparablejob',
		'limitdistance',
		'postcode',
		'updt',
		'notevac',
		'oldcandidate',
		'special_req',
		'jobref',
		'notejas',
		'name_ads',
		'name_email',
		'tampil'
	];

	function __construct($con) {
		$this->con = $con;
	}

	function getVacanciesAll() {
		$con = $this->con;

		$query = mysqli_query($con, "SELECT  n.id, n.title, n.date, n.location, n.description, left(md5(id), 8) as vacancy_id
		FROM news_advice n
		ORDER BY id DESC LIMIT 40 ");

		$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

		$res['data'] = $result;

		echo json_encode($res);
	}

	function getVacanciesByID() {
		$con = $this->con;

		$filteredData = [];
		$additional_field = "";

		foreach($_POST as $index => $value) {
			if (in_array($index, $this->filteredFields)) {
				array_push($filteredData, ' left(md5(id), 8) = "'.mysqli_real_escape_string($con, $value).'"');
				$additional_field = ", detail";
			}
		}

		$query = mysqli_query($con, "SELECT  n.id, n.title, n.date, n.location, n.description, left(md5(id), 8) as vacancy_id ".$additional_field.", n.jobref
		FROM news_advice n
		WHERE 1=1 AND
			".implode(' OR ', $filteredData)."
			");

		$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

		$res['data'] = $result;

		echo json_encode($res);
	}

        function getVacanciesByID2() {
		$con = $this->con;
		$username = $_POST['username'];

		$query = mysqli_query($con, "SELECT v.id, v.jobtitle, v.clientref, v.location, v.submitdate, count(c.id) as totalcv 
		FROM vacancies v
		LEFT JOIN candidates c ON c.vacancyid = v.id
		WHERE v.username = '$username'
		GROUP BY v.id, v.jobtitle, v.clientref, v.location, v.submitdate 
		ORDER BY id DESC LIMIT 20 ");

		$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

		$res['data'] = $result;

		echo json_encode($res);
	}
          

	function getVacancies() {
		$con = $this->con;

		$filteredData = [];

		foreach($_POST as $index => $value) {
			if (in_array($index, $this->filteredFields)) {
				array_push($filteredData, 'v.'.$index.' = "'.mysqli_real_escape_string($con, $value).'"');
			}
		}

		$query = mysqli_query($con, "SELECT v.id, v.jobtitle, v.clientref, v.location, v.submitdate, count(c.id) as totalcv, c.candidatename
		FROM vacancies v
		LEFT JOIN candidates c ON c.vacancyid = v.id
		WHERE 1=1 AND
			".implode(' AND ', $filteredData)."
		GROUP BY v.id, v.jobtitle, v.clientref, v.location, v.submitdate, c.candidatename
		ORDER BY id DESC LIMIT 20 ");

		$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

		$res['data'] = $result;

		echo json_encode($res);
	}

	function getDetailVacancy() {
		$con = $this->con;

		$filteredData = [];

		foreach($_POST as $index => $value) {
			if (in_array($index, $this->filteredFields)) {
				array_push($filteredData, 'v.'.$index.' = "'.mysqli_real_escape_string($con, $value).'"');
			}
		}

		$query = mysqli_query($con, "SELECT *
		FROM vacancies v
		WHERE 1=1 AND
			".implode(' AND ', $filteredData)."
		");

		$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

		$res['data'] = $result;

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
			$query = mysqli_query($con, "INSERT INTO vacancies (".$insertedFields.join(', ').")
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
$vacancies = new Vacancies($con);

if (isset($_GET['path'])) {
	$method = $_GET['path'];
}

if ($method == '') {
	$vacancies->getVacancies();
	exit;
}

$vacancies->$method();	