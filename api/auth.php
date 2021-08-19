<?php
include_once('conf.php');

class Auth {
	private $token;
	private $con;
	private $contactusStructure = array("name","email","phone","message");
	private $registerStructure = array("firstname", "lastname", "username", "organisation", "email", "telp");

	function __construct($con, $key) {
		$this->con = $con;
		$this->key = $key;
	}

	public function setUsers(){
		if(isset($_POST)){
			$con = $this->con;

			$query = array();
			$is_false = false;

			foreach($this->registerStructure as $data_structure){
				if(isset($_POST[$data_structure])){
					array_push($query, "'".$_POST[$data_structure]."'");
				}else{
					$is_false = true;
				}
			}

			$queryCheck = mysqli_query($con, "select * from users where lower(username) = lower('".mysqli_real_escape_string($con, $_POST['username'])."') or lower(email) = lower('".$_POST['email']."')");
			
			if(mysqli_num_rows($queryCheck) >0){
				$data['error_code'] = 201;
				$data['error_msg'] = "Your username/email already exist. Please use other username/email.";
				$is_false  = true;
			}

			if($is_false === false){
				$password = substr(md5(rand()), 0, 8);
				$queryInsert = mysqli_query($con, "insert into users (".implode(",", $this->registerStructure).", password, agree, addedby, usertype, status,pass) value(".implode(",", $query).", md5('$password'), 'no', 'register', 'C', 'active','$password')" );
				if($queryInsert){
					$data['error_code'] = 0;
					$data['error_msg'] = "Thank you for registering with The Recruitment Boutique. Please check your email (Inc SPAM) for your login details.";	
					
					unset($_GET['loadData']);
					$_POST['password'] = $password;
					$options = $_POST;
					$options['uid'] = md5(md5($_POST['email']));
					include_once("email.php");
					$e = new Email();
					$e->registrationEmail($options);

				}else{
					$data['error_code'] = 201;
					$data['error_msg'] = "Sorry, register is failed. Please try again "."insert into users (".implode(",", $this->registerStructure).", password, agree, addedby) value(".implode(",", $query).", md5('$password'), 'no', 'register')" ." - ";	
				}
			}else{
				$data['error_code'] = 201;
			}
			header("Content-Type: application/json");
			echo json_encode($data);
		}
	}

	public function sendContact(){
		if(isset($_POST)){
			$con = $this->con;

			$query = array();
			$is_false = false;

			foreach($this->contactusStructure as $data_structure){
				if(isset($con, $_POST[$data_structure])){
					array_push($query, "'".$_POST[$data_structure]."'");
				}else{
					$is_false = true;
				}
			}
			
			if($is_false === false){
				$queryInsert = mysqli_query($con, "insert into message (".implode(",", $this->contactusStructure).") value(".implode(",", $query).")" );
				if($queryInsert){
					$data['error_code'] = 0;
					$data['error_msg'] = "Thank you";	

					unset($_GET['loadData']);
					$options = $_POST;
					
					include_once("email.php");
					$e = new Email();
					$e->sendcontact($options);
				}else{
					$data['error_code'] = 201;
					$data['error_msg'] = "Sorry, register is failed. Please try again "."insert into message (".implode(",", $this->contactusStructure).") value(".implode(",", $query).")" ." - ";	
				}
			}else{
				$data['error_code'] = 201;
			}
			header("Content-Type: application/json");
			echo json_encode($data);
		}
	}

	public function login() {
		// $_POST['username'] = 'cpaps';
		// $_POST['password'] = '7d3e28d1';
		$con = $this->con;

		$username = mysqli_real_escape_string($con, $_POST['email']);
		$password = mysqli_real_escape_string($con, $_POST['password']);
		$key = $this->key;

		try {
			$query = mysqli_query($con, "SELECT md5(concat(id, '$key')) as token FROM users WHERE (username = '$username' or email = '$username') and usertype = 'C' and password = md5('$password') ");
			$result = mysqli_fetch_assoc($query);

			if ((mysqli_num_rows($query)  == 0) || (mysqli_num_rows($query)  < 1)) {
			//if (count($result)  == 0) {
				$res['error_code'] = 202;
				echo json_encode($res);
				exit;
			}

			$res['error_code'] = 0;
			$res['token'] = $result['token'];

			echo json_encode($res);

		} catch(Exception $e) {
			exit;
		}
	}

	public function resetPassword(){
		if(isset($_POST['un'])){
			$con = $this->con;
			$un = mysqli_real_escape_string($con, $_POST['un']);		
			$query_users=mysqli_query($con, "select * from users where (username = '$un' or email = '$un')");	
			if(mysqli_num_rows($query_users)==1){
				$options = mysqli_fetch_assoc($query_users);
				$options['password'] = substr(md5(rand()), 0, 8);
				mysqli_query($con, "update users set password= md5('".$options['password']."') where id = '".$options['id']."' ");

				unset($_GET['loadData']);
				include_once("email.php");
				$e = new Email();
				if($e->forgotEmail($options) == true){
					$data['error_code']  = 0;
					$data['error_msg'] = "We have reseted your account. Please check it on your email/spam";	
				}else{
					$data['error_code']  = 201;
					$data['error_msg'] = "Sorry, reset password is failed. Please try again.";
				}
			}else{
				$data['error_code']  = 201;
				// $data['error_msg'] = "Sorry, We cannot found your username/email.";
				$data['error_msg'] = "Sorry, We cannot find your username/email address.";
			}
		}
		header("Content-Type: application/json");
		echo json_encode($data);
	}

	public function getData($token) {
		try {
			$key = $this->key;
			$con = $this->con;

			$query = mysqli_query($con, "SELECT username, email, fisrtname, credits  FROM users WHERE md5(concat(id, '$key')) = '$token' ");
			$result = mysqli_fetch_assoc($query);

			if (count($result)  == 0) {
				$res['error_code'] = 202;
				echo json_encode($res);
				exit;
			}

			$res['error_code'] = 0;
			$res['token'] = $result['token'];

			echo json_encode($res);

		} catch(Exception $e) {
			exit;
		}
	}

	public function getUser() {
		$token = $_POST['token'];
		try {
			$key = $this->key;
			$con = $this->con;

			$query = mysqli_query($con, "SELECT id, email, username, credits, firstname, lastname, organisation, telp FROM users WHERE md5(concat(id, '".$key."')) = '".mysqli_real_escape_string($con, $token)."' ");

			if (mysqli_num_rows($query) < 1) {
				return false;
			}
			
			$users = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];

			if (count($users)  == 0) {
				$res['error_code'] = 202;
				echo json_encode($res);
				exit;
			}
			
			$res['error_code'] = 0;
			$res['token'] = $token;
			$res['data'] = $users;

			echo json_encode($res);

		} catch(Exception $e) {
			exit;
		}
	}
	
	public function changePassword(){
		if(isset($_POST['email'])){
			$con = $this->con;
			$un = mysqli_real_escape_string($con, $_POST['un']);		
			$email = mysqli_real_escape_string($con, $_POST['email']);		
			$pass = mysqli_real_escape_string($con, $_POST['pass']);
			$query_users=mysqli_query($con, "select * from users where (username = '$un' and email = '$email')");	
			if(mysqli_num_rows($query_users)==1){
				$options = mysqli_fetch_assoc($query_users);
				mysqli_query($con, "update users set password= md5('".$pass."') where id = '".$options['id']."' ");

				unset($_GET['loadData']);
				$data['error_code']  = 0;
				$data['error_msg'] = "Success change password.";	
			}else{
				$data['error_code']  = 201;
				$data['error_msg'] = "Sorry, We cannot find your username/email address.";
			}
		}
		header("Content-Type: application/json");
		echo json_encode($data);
	}
	
	public function updateUser(){
		if(isset($_POST['ids'])){
			$con = $this->con;
			$ids = mysqli_real_escape_string($con, $_POST['ids']);		
			$un = mysqli_real_escape_string($con, $_POST['username']);		
			$email = mysqli_real_escape_string($con, $_POST['email']);		
			$firstname = mysqli_real_escape_string($con, $_POST['firstname']);
			$lastname = mysqli_real_escape_string($con, $_POST['lastname']);
			$organisation = mysqli_real_escape_string($con, $_POST['organisation']);
			$telp = mysqli_real_escape_string($con, $_POST['telp']);
			$query_users=mysqli_query($con, "select * from users where (id = '$ids')");	
			if(mysqli_num_rows($query_users)==1){
				$options = mysqli_fetch_assoc($query_users);
				mysqli_query($con, "update users set username = '".$un."' ,email = '".$email."' ,firstname = '".$firstname."' ,lastname = '".$lastname."' ,organisation = '".$organisation."' ,telp = '".$telp."' where id = '".$options['id']."' ");

				unset($_GET['loadData']);
				$data['error_code']  = 0;
				$data['error_msg'] = "Success update user data.";	
			}else{
				$data['error_code']  = 201;
				$data['error_msg'] = "Sorry, We cannot find your id.";
			}
		}
		header("Content-Type: application/json");
		echo json_encode($data);
	}
}


$method = '';
$auth = new Auth($con, $key);

if (isset($_GET['path'])) {
	$method = $_GET['path'];
}

$auth->$method();