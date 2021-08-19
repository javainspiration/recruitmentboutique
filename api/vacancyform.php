<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ob_start();

include('conf.php');

if (isset($_POST['submit'])){
		$jobref = $_POST['jobref'];
		$id = $_POST['id'];
		$auth = $_POST['auth'];
		$clientref = $_POST['clientref'];
		$companyname = $_POST['companyname'];
		$companywebsite = $_POST['companywebsite'];
		$jobtitle = $_POST['jobtitle'];
		$permcontract  = $_POST['permcontract'];
		$location  = $_POST['location'];
		$contractlength  = $_POST['contractlength'];
		if (isset($_POST['salary2'])) {
			$_POST['salarytext'] = $_POST['salary']." - ".$_POST['salary2']." GBP/".$_POST['salary_periode'];
		}
		$salarytext  = $_POST['salarytext'];
		$benefit  = $_POST['benefit'];
		$numberreq  = $_POST['numberreq'];

		$pecah = explode('-',($_POST['startdate']));
		$sd0 = $pecah[0];
		$sd1 = $pecah[1];
		$sd2 = $pecah[2];
		$sd = strtotime($sd0.'-'.$sd1.'-'.$sd2);
		$startdate  = date('Y-m-d',$sd);

		$tasks  = $_POST['tasks'];
		$essentialqual  = $_POST['essentialqual'];
		$additionalqual  = $_POST['additionalqual'];
		$limitcv  = "";
		$priority  = 1;
		$submitdate  = date("Y-m-d");
		$status  = "Active";
		$includecv  = $_POST['includecv'];
		$relocationsupport  = $_POST['relocationsupport'];
		$equivalentvoc  = $_POST['equivalentvoc'];
		$comparablesectors  = $_POST['comparablesectors'];
		$comparablejob  = $_POST['comparablejob'];
		$limitdistance  = $_POST['limitdistance'];
		$oldcandidate  = $_POST['oldcandidate'];
		$tampil  = "tampil";

		//var_dump($_POST);
		$query = mysqli_query($con, "SELECT id, email, username, credits FROM users WHERE md5(concat(id, '".$key."')) = '".mysqli_real_escape_string($con, $auth)."' ");

		if (mysqli_num_rows($query) < 1) {
			return false;
		}

		$users = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];
		$username = $users['username'];

		/*if ($users['credits'] < 1) {
			return false;
		}*/

		$queryString = "";



		if (!isset($_POST['id']) || $_POST['id'] == '') {
			$queryString = "INSERT INTO vacancies
				(jobref,clientref, companyname, companywebsite, jobtitle, permcontract, location, contractlength, salarytext, benefit, numberreq, startdate, tasks, essentialqual, additionalqual, priority, submitdate, status, includecv, relocationsupport, equivalentvoc, comparablesectors, comparablejob, limitdistance, oldcandidate, tampil, username) 
				VALUES
				('$jobref','$clientref', '$companyname', '$companywebsite', '$jobtitle', '$permcontract', '$location', '$contractlength', '$salarytext', '$benefit', '$numberreq', '$startdate', '$tasks', '$essentialqual', '$additionalqual', '$priority', '$submitdate', '$status', '$includecv', '$relocationsupport', '$equivalentvoc', '$comparablesectors', '$comparablejob', '$limitdistance', '$oldcandidate', '$tampil', '$username')";
				
			$query = mysqli_query($con, $queryString);
			$sql = "update users set credits=credits-1 where username='$username'";
			$query1 = mysqli_query($con, $sql);
			/*$_SESSION['msg'] = "Thank you, your vacancy is uploaded.";*/
			header("Location: https://recruitment-boutique.com/vacancy-search.html");
			exit;
		}
		//var_dump($queryString);die();
			
}
ob_end_flush();