<?php
    use PHPMailer\PHPMailer\PHPMailer;
	
class Email{

	private $source = "http://127.0.0.1/web/rb/";
	
	#WARNING
	#this address will be used on all of email
	private $from = "enquiries@recruitment-boutique.com"; 
	private $name = "Recruitment Boutique";
	//private $url = "http://recruitment-boutique.com/#/activate";
        private $url = "https://recruitment-boutique.com/sign-in.html";
	function footer(){
		return '<span style="font-size: 12px">
								<img src="http://recruitment-boutique.com/images/signature_gmail.jpg"> </span></font></p>
								<p align="left">
									<span style="FONT-SIZE: 12px">
										<font face="Arial" color="#00007d">
											t +44 (0) 20 8123 9129 &nbsp;<br/>
										</font>
										<font color="#00007e" face="Arial">
											f +44 (0) 20 7900 6259<br/><br/>
											www.recruitment-boutique.com<br/><br/>
										</font>
										<font face="Arial" color="#00007e">
											Recruitment Boutique is registered in UK:  Kemp House, 152 City Road, London EC1V 2NX<br/><br/>
											Company no: 07686179<br/>
										</font>
									</span>
									<font color="#00007e" face="Arial">
										<span style="FONT-SIZE: 12px">
											<br/>
											The opinions expressed within this email represent solely those of the author. 
											The information in this Internet email is confidential and may be legally 
											privileged. It is intended solely for the addressee. Access to this internet 
											email by anyone else is unauthorised. If you are not the intended recipient, any 
											disclosure, copying, distribution or any action taken or omitted to be taken in 
											reliance on it, is prohibited and may be unlawful.<br/>
											&nbsp;<br/>
											This message has been scanned for viruses.<br/>
											&nbsp;
										</span>
									</font>
								</p>
							</span>';
	}

	
	function registrationEmail($options){
		// if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == $this->source ){
			require_once "vendor/autoload.php";

			$mail = new PHPMailer;

			$mail->isSMTP();            
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPAuth = true;                               
			$mail->Username = "enquiries@recruitment-boutique.com";                 
			$mail->Password = "jj159BUTIK";                           
			$mail->SMTPSecure = "tls";                           
			$mail->Port = 587;       

			$mail->From = $this->from;
			$mail->FromName = $this->name;

			$mail->addAddress($options['email'], $options['firstname'].' '.$options['lastname']);

			// $mail->addReplyTo("jason@recruitment-boutique.com", "Jason");

			$mail->addBCC("jason@recruitment-boutique.com");
			//$mail->addCC("aang@javainspiration.com");
			// $mail->addCC("cc@example.com");
			// $mail->addBCC("bcc@example.com");

			$mail->isHTML(true);

			$mail->Subject = "Information Account";
			$mail->Body = "<font size='2'>Hi ".$options['firstname'].",<br>
							Thank you for opening an account with the Recruitment Boutique.<br>
							Your log in details are :  <br><br>

							Email: ".$options['email']."<br>
							Username: ".$options['username']."<br>
							Password: ".$options['password']."<br><br>


							You can now log in to your acount:<br>
							".$this->url."<br><br>
							Once activated, your account can be used to login.<br>						
							If you have any questions please contact us and we will be happy to help 
							Thanks</font><br>
							<br>".
							$this->footer()
							;

			if(!$mail->send()) 
			{
			    return false;
			} 
			else 
			{
			    return true;
			}
		// }else{
			// echo $_SERVER['HTTP_REFERER'];
		// }
	}
	/*Send Contact*/
	function sendcontact($options){
			require_once "vendor/autoload.php";
			$mail = new PHPMailer;
			$mail->isSMTP();            
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPAuth = true;                               
			$mail->Username = "enquiries@recruitment-boutique.com";                 
			$mail->Password = "jj159BUTIK";               
			$mail->SMTPSecure = "tls";                           
			$mail->Port = 587;       
			//$mail->From = $options['email'];
			$mail->From = $this->from;
			$mail->FromName = $this->name;
			//$mail->FromName = $this->name;

			$mail->addAddress("jason@recruitment-boutique.com");

			// $mail->addReplyTo("jason@recruitment-boutique.com", "Jason");

			//$mail->addCC("aang@javainspiration.com");

			// $mail->addCC("cc@example.com");
			// $mail->addBCC("bcc@example.com");

			$mail->isHTML(true);

			$mail->Subject = "New Enquiry";
			$mail->Body = "<font size='2'>".$options['name']."<br>
										  <a href='mailto:'".$options['email'].">".$options['email']."<a/><br>
							Send Your New Enquiry :
							<hr><br>
							".$options['message']."
							</font><br>
							<br>".
							$this->footer()
							;

			if(!$mail->send()) 
			{
			    return false;
			} 
			else 
			{
			    return true;
			}
		// }else{
			// echo $_SERVER['HTTP_REFERER'];
		// }
	}
	/*End Send Contact*/

	/*Send sendlandingpage*/
	function sendlandingpage($options){
			require_once "vendor/autoload.php";
			$mail = new PHPMailer;
			$mail->isSMTP();            
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPAuth = true;                               
			$mail->Username = "enquiries@recruitment-boutique.com";                 
			$mail->Password = "jj159BUTIK";                           
			$mail->SMTPSecure = "tls";                           
			$mail->Port = 587;       
			//$mail->From = $options['email'];
			$mail->From = $this->from;
			$mail->FromName = $this->name;
			//$mail->FromName = $this->name;

			$mail->addAddress("jason@recruitment-boutique.com");
			// $mail->addAddress("aang@javainspiration.com");

			$mail->isHTML(true);

			$mail->Subject = "New Enquiry Landing Page";
			$mail->Body = "	Send Your New Enquiry Landingpage:
							<hr><br>
							Name  : ".$options['name']." <br>
							Email : ".$options['email']." <br>
							Company : ".$options['email']." <br>
							telp : ".$options['telp']." <br>
							Call Back : ".$options['call_back']." <br>
							</font><br>
							<br>".
							$this->footer()
							;

			if(!$mail->send()) 
			{
			    return false;
			} 
			else 
			{
			    return true;
			}
		// }else{
			// echo $_SERVER['HTTP_REFERER'];
		// }
	}
	/*End Send sendlandingpage*/

	function forgotEmail($options){
		require_once "vendor/autoload.php";

			$mail = new PHPMailer;

			$mail->isSMTP();            
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPAuth = true;                               
			$mail->Username = "enquiries@recruitment-boutique.com";                 
			$mail->Password = "jj159BUTIK";                           
			$mail->SMTPSecure = "tls";                           
			$mail->Port = 587;       

			$mail->From = $this->from;
			$mail->FromName = $this->name;

			$mail->addAddress($options['email'], $options['firstname'].' '.$options['lastname']);

			$mail->addReplyTo("jason@recruitment-boutique.com", "Jason");

			$mail->addBCC("raden.sofian.bahri@gmail.com"); 
			// $mail->addBCC("aang@javainpiration.com");

			$mail->isHTML(true);

			$mail->Subject = "Information Account";
			$mail->Body = "<font size='2'>Hi ".$options['firstname'].",<br>
							We have reset your password.<br>
							Your account details are below.<br><br>

							Email: ".$options['email']."<br>
							Username: ".$options['username']."<br>
							Password: ".$options['password']."<br><br>

							You can use your information account above to login to Recruitment Boutique site.<br>
							Thanks</font><br>
							<br>".
							$this->footer()
							;

			if(!$mail->send()) 
			{
			    return false;
			} 
			else 
			{
			    return true;
			}
	}

	function sendTestOnTheNet(){
		require_once "vendor/autoload.php";

			$mail = new PHPMailer;

			$mail->isSMTP();            
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPAuth = true;                               
			$mail->Username = "enquiries@recruitment-boutique.com";                 
			$mail->Password = "jj159BUTIK";                           
			$mail->SMTPSecure = "tls";                           
			$mail->Port = 587;       

			$mail->From = $this->from;
			$mail->FromName = $this->name;

			$mail->addAddress($_POST['email'], $_POST['firstname'].' '.$_POST['lastname']);

			$mail->addReplyTo("jason@recruitment-boutique.com", "Jason");

			$mail->addBCC("sofian@recruitment-boutique.com"); 
			// $mail->addBCC("aang@javainpiration.com");

			$mail->isHTML(true);

			$mail->Subject = "TestonTheNet Payment";
			$mail->Body = "<font size='2'>Hi ".$_POST['firstname'].",<br>
							Thank you for purchasing a DISC test.<br/>
							Here the details:<br/><br/>

							Name: ".$_POST['name']."<br>
							Email: ".$_POST['email']."<br>
							Amount: ".$_POST['amount']."<br><br>

							You will be sent a link for the test shortly. <br/>
							Thanks</font><br>
							<br>".
							$this->footer()
							;

			if(!$mail->send()) 
			{
			    return false;
			} 
			else 
			{
			    return true;
			}
	}

	function jobSeekerSubmitWeb($options){
		// if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == $this->source ){
			require_once "vendor/autoload.php";

			$mail = new PHPMailer;

			$mail->isSMTP();            
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPAuth = true;                               
			$mail->Username = "enquiries@recruitment-boutique.com";                 
			$mail->Password = "jj159BUTIK";                           
			$mail->SMTPSecure = "tls";                           
			$mail->Port = 587;       

			$mail->From = $this->from;
			$mail->FromName = $this->name;

			//$mail->addAddress($options['email'], $options['firstname'].' '.$options['lastname']);
			$mail->addAddress("jason@recruitment-boutique.com");
			// $mail->addReplyTo("jason@recruitment-boutique.com", "Jason");

			//$mail->addBCC("jason@recruitment-boutique.com");
			//$mail->addCC("aang@javainspiration.com");
			// $mail->addCC("cc@example.com");
			// $mail->addBCC("bcc@example.com");

			$mail->isHTML(true);

			$mail->Subject = "New application for ".$options['jobtitle']." (Jobref: ".$options['jobref']." - ".$options['location'].")";
			$mail->Body = "<font size='2'>You have received an application for (Jobref: ".$options['jobref']." - ".$options['location'].")<br>
							Candidate Details :<br><br>

							Candidate Name : ".$options['candidatename']."<br>
							Candidate Email: ".$options['email']."<br>
							Candidate Phone Number: ".$options['phone']."<br>
							Candidate Phone Postcode: ".$options['postcode']."<br>

							Download CV: http://recruitment-boutique.com/upl_cv/".$options['filename']."
							<br><br>
							".$this->footer()
							;

			if(!$mail->send()) 
			{
			    return false;
			} 
			else 
			{
			    return true;
			}
		// }else{
			// echo $_SERVER['HTTP_REFERER'];
		// }
	}

	function jobSeekerSubmitLinkedin($options){
		// if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == $this->source ){
			require_once "vendor/autoload.php";

			$mail = new PHPMailer;

			$mail->isSMTP();            
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPAuth = true;                               
			$mail->Username = "enquiries@recruitment-boutique.com";                 
			$mail->Password = "jj159BUTIK";                           
			$mail->SMTPSecure = "tls";                           
			$mail->Port = 587;       

			$mail->From = $this->from;
			$mail->FromName = $this->name;

			//$mail->addAddress($options['email'], $options['firstname'].' '.$options['lastname']);
			$mail->addAddress("jason@recruitment-boutique.com");
			// $mail->addReplyTo("jason@recruitment-boutique.com", "Jason");

			//$mail->addBCC("jason@recruitment-boutique.com");
			//$mail->addCC("aang@javainspiration.com");
			// $mail->addCC("cc@example.com");
			// $mail->addBCC("bcc@example.com");

			$mail->isHTML(true);

			$mail->Subject = "New Linkedin profile for ".$options['jobtitle']." (Jobref: ".$options['jobref']." - ".$options['location'].")";
			$mail->Body = "<font size='2'>You have received an application for (Jobref: ".$options['jobref']." - ".$options['location'].")<br>
							Candidate Details :<br><br>

							Candidate Name : ".$options['candidatename']."<br>
							Candidate Email: ".$options['email']."<br>
							Candidate Phone Number: ".$options['phone']."<br>
							Candidate Phone Postcode: ".$options['postcode']."<br>

							Download CV: ".$options['linkedin']."
							<br><br>
							".$this->footer()
							;

			if(!$mail->send()) 
			{
			    return false;
			} 
			else 
			{
			    return true;
			}
		// }else{
			// echo $_SERVER['HTTP_REFERER'];
		// }
	}
}

if(isset($_GET['loadData']) && $_GET['loadData']!==""){
	$v = new Email();
	$v->$_GET['loadData']();	
}
