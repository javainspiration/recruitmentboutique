<?php
include_once('conf.php');

class Candidates {

	private $con;
	private $filteredFields = [
		'vacancyid',
	];

	private $fields = [
		'id',
		'clientref',
		'jobtitle',
		'candidatename',
		'iscontacted',
		'isavailable',
		'fromdate',
		'conditions',
		'addedby',
		'submitdate',
		'vacancyid',
		'email',
		'phone',
		'mobile',
		'filename',
		'additional_documentation',
		'contacteddate',
		'rate',
		'comments',
		'feedbackdate',
		'source',
		'showhide',
		'notes',
		'headhunt',
		'filename_temp',
		'read_status',
		'application_form',
		'date_sendcv',
		'cv_from'
	];

	function __construct($con) {
		$this->con = $con;
	}

	function getCandidates() {
		$con = $this->con;

		$filteredData = [];

		foreach($_POST as $index => $value) {
			if (in_array($index, $this->filteredFields)) {
				array_push($filteredData, $index.' = '.mysqli_real_escape_string($con, $value));
			}
		}

		$query = mysqli_query($con, "SELECT id, candidatename, submitdate, phone, email, filename FROM candidates
		WHERE 1=1 AND
		".implode(' AND ', $filteredData)."
		 ORDER BY id DESC ");
		$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

		$res['data'] = $result;

		echo json_encode($res);
	}
}

$method = '';
$candidate = new Candidates($con);

if (isset($_GET['path'])) {
	$method = $_GET['path'];
}

if ($method == '') {
	$candidate->getCandidates();
	exit;
}

$vacancies->$method();