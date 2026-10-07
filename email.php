<?php
	

	$name = "name";//$_POST['name']; 
	$email = "name";//$_POST['email']; 
	$phone = "name";//$_POST['phone'];
	$sub = "name";//$_POST['subject']; 
	$query = "name";//$_POST['message']; 
	//end of data collection from form


	//check whether user enter some data or not 
	

	$to = "pradeepdhakad543@gmail.com";
	$subject = "Inquiry from website";
	$txt  = "Name: $name". "\r\n";
	$txt .= "Email: $email" . "\r\n";
	$txt .= "Email: $phone" . "\r\n";
	$txt .= "Subject: $sub" . "\r\n";
	$txt .= "Query: $query" . "\r\n";
	$headers = "From: orderconfirm@pawarhandloom.com" . "\r\n";

 $success =  mail($to,$subject,$txt,$headers);
 
	if($success)
	{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
		window.alert('Succesfully Sent')
			window.location.href='index.html';
			</SCRIPT>");
		}
	else{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Your Mail Server Not Responding... Please try After Some Time')
			window.location.href='index.html';
			</SCRIPT>");
		}


?> 