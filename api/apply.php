<?php
ob_start();
include('conf.php');

if (isset($_POST['apply'])){
	$jobtitle = $_POST['jobtitle'];
	$candidatename = $_POST['candidatename'];
	$submitdate = date("Y-m-d H:i:s");
	$newadvice_id = $_POST['newadvice_id'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$source = "Applied";
	$linkedin = $_POST['linkedin'];
	$postcode = $_POST['postcode'];
	$location = $_POST['location'];
	$jobref = $_POST['jobref'];

	/*var_dump($_SERVER) ; die();*/
	if ($_POST['linkedin'] == '') {
		$filename = $_FILES['file']['name'];
		$file = $_FILES['file']['tmp_name'];
		
    	if(isset($filename) and !empty($filename)){
    		$destination = $_SERVER['DOCUMENT_ROOT'].'/upl_cv/'.$filename;
    		//$destination = $_SERVER['DOCUMENT_ROOT']."/upl_cv/".$filename;
			//var_dump($destination);die();
			$extension = pathinfo($filename, PATHINFO_EXTENSION);
		   	$size = $_FILES['file']['size'];
	    
	    	if (!in_array($extension, ['pdf', 'docx'])) {
		        echo "You file extension must be .pdf or .docx";
		    } elseif ($_FILES['file']['size'] > 5000000) { // file shouldn't be larger than 1Megabyte
		        echo "File too large!";
		    } else {
		    	//chmod("localhost/upl_cv/", 0777);
		        // move the uploaded (temporary) file to the specified destination
		        if (move_uploaded_file($file, $destination)) {
		            $sql = "INSERT INTO applied (jobtitle, candidatename, submitdate, newadvice_id, email, phone, filename, source, linkedin, postcode, location, jobref) 
		            	VALUES 
		            	('$jobtitle', '$candidatename', '$submitdate', '$newadvice_id', '$email', '$phone', '$filename', '$source', '', '$postcode', '$location', '$jobref')";
		            if (mysqli_query($con, $sql)) {
		                echo  "Thank you for submitted this vacancy. Our client will contact you if your profile suit with their criteria";
		            }
		        $_POST['filename'] = $filename;
		        $options = $_POST;
					
				include_once("email.php");
				$e = new Email();
				$e->jobSeekerSubmitWeb($options);

		        //chmod("localhost/upl_cv/", 0755);
		        $query = mysqli_query($con, $sql);
		        header("location: ../vacancy.html");
		        } else {
		            echo "Failed to upload file.";
		        }
		    }
		}
	}else{
		$sql = "INSERT INTO applied (jobtitle, candidatename, submitdate, newadvice_id, email, phone, filename, source, linkedin, postcode, location, jobref) VALUES ('$jobtitle', '$candidatename', '$submitdate', '$newadvice_id', '$email', '$phone', '', '$source', '$linkedin', '$postcode', '$location', '$jobref')";
		
		/*if (mysqli_query($conn, $sql)) {
	        header("location: ../vacancy.html");
	    }*/

	    $options = $_POST;
					
		include_once("email.php");
		$e = new Email();
		$e->jobSeekerSubmitLinkedin($options);

		$query = mysqli_query($con, $sql);

		//echo json_encode($data);
		header("location: ../vacancy.html");
	}
}
ob_end_flush();