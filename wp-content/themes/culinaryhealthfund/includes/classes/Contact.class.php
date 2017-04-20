<?php

include_once (PATH_CLASS . 'Email.class.php');

class Contact
{
	
	public function __construct()
	{
		global $db;
		
		$this->db = $db;
	}
	
	public function validateContactForm($who, $birthDate, $firstName, $lastName, $emailAddr, $phone, $contactTime, $message)
	{
		
		$errorMsg = array();
		$error = "";
		
		if (!strlen(trim($who))) {
			$error = "Make a selection for who are you";
			array_push($errorMsg, $error);
		}
		
		if (!strlen(trim($firstName))) {
			$error = "First Name is required";
			array_push($errorMsg, $error);
		}
		
		if (!strlen(trim($lastName))) {
			$error = "Last Name is required";
			array_push($errorMsg, $error);
		}
		
		if (!strlen(trim($emailAddr))) {
			$error = "Email Address is required";
			array_push($errorMsg, $error);
		}
		
		if (!filter_var($emailAddr, FILTER_VALIDATE_EMAIL)) {
		    $error = "The email address you entered appears to be invalid";
			array_push($errorMsg, $error);
		}
		
		if (!strlen(trim($phone))) {
			$error = "Phone is required";
			array_push($errorMsg, $error);
		}
		
		if (!strlen(trim($message))) {
			$error = "Comment / Question is required";
			array_push($errorMsg, $error);
		}
		
		return $errorMsg;
		
		
		
	}
	
	public function sendContactForm($who, $birthDate, $firstName, $lastName, $emailAddr, $phone, $contactTime, $message)
	{
	
		$email = new Email();
		
		$emailInfo = $email->buildContactForm($who, $birthDate, $firstName, $lastName, $emailAddr, $phone, $contactTime, $message);
		
		$recipients = array($emailInfo['to_address']);
		$replyEmail = $emailAddr;
		
		#$email->sendEmail($emailInfo['body'], $emailInfo['subject'], $recipients, $replyEmail);
		$email->sendEmailSES($emailInfo['body'], $emailInfo['subject'], $recipients, $replyEmail);
		
		return true;
		
	}
	
}

?>