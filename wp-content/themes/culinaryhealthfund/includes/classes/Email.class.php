<?php

class Email
{

  public function __construct()
  {
	
    $this->from_address         = "Culinary Health Fund <auto-confirm@culinaryhealthfund.org>";
	$this->access_key           = "AKIAIYRRLTNGFXY2KEGA";
	$this->secret_access_key    = "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";
    
  }
  
  
  public function getRecipientEmail($who) {
	  	  
	  switch ($who) 
	  {
		  case 'Participant':
		  	$emailTo = array("Culinary Health Fund <mgamboa@culinaryhealthfund.org>");
		  break;
		  
		  case 'Provider':
		  	$emailTo = array("Culinary Health Fund <mmendoza@culinaryhealthfund.org>");
		  break;
		  
		  case 'Employer':
		  	$emailTo = array("Culinary Health Fund <mmcgill@culinaryhealthfund.org>");
		  break;
		  
		  default:
		  	$emailTo = array("Culinary Health Fund <mgamboa@culinaryhealthfund.org>");
		  break;
	  }
	  
	  $emailTo = array("Culinary Health Fund <patrick@crowngrey.com>");
	  
	  return $emailTo;
  }
  
  public function buildContactForm($who, $birthDate, $firstName, $lastName, $emailAddr, $phone, $contactTime, $message) {
	  
	  $subject = "New Culinary Health Fund Contact Form";
	  
	  $body = "";
	  $body .= "A new contact form has just been filled out on the website.\n\n";
	  $body .= "Who Are They: " . $who . "\n";
	  $body .= "Birth Date: " . $birthDate . "\n";
	  $body .= "First Name: " . $firstName . "\n";
	  $body .= "Last Name: " . $lastName . "\n";
	  $body .= "Email: " . $emailAddr . "\n";
	  $body .= "Phone: " . $phone . "\n";
	  $body .= "Best Time To Contact: " . $contactTime . "\n";
	  $body .= "Message: " . $message . "\n";
	  
	  $emailInfo['subject'] = $subject;
	  $emailInfo['to_address'] = $this->getRecipientEmail($who);
	  $emailInfo['body'] = $body;
	  
	  return $emailInfo;
	  
	  
  }
  
  public function sendEmail($body, $subject, $recipients, $replyEmail)
  {
    	
    	foreach ($recipients as $r)
    	{
	    	$toEmail = $r;
			mail($toEmail,$subject,$body,"From: $this->from_address\n");
	    	
    	}
    	
    	if (strlen($replyEmail)) {
	    	$this->sendReplyEmail($replyEmail);	
    	}
		
        
    return true;

  }
  
  
  public function sendEmailSES($body, $subject, $recipients, $replyEmail)
  {
    
    $this->SES                  = new SimpleEmailService($this->access_key, $this->secret_access_key);
    $this->msg                  = new SimpleEmailServiceMessage();

    foreach ($recipients as $r) {
	$this->msg->addTo($r);    
    }
    
    $this->msg->setFrom($this->from_address);
    $this->msg->setSubject($subject);
	$this->msg->setMessageFromString('', $body);
    $response = $this->SES->sendEmail($this->msg);
   
    if (strlen($replyEmail)) {
	    	$this->sendReplyEmail($replyEmail);	
    }
    
    return true;

  }
  
  
  public function sendReplyEmail($toEmail)
  {
	  	
		$replySubject = "Culinary Health Fund - Contact Form";
		$replyBody = "Thank you for your message. We have received it, and someone will contact you shortly.";
		mail($toEmail, $replySubject, $replyBody,"From: " . $this->from_address . "\n");
		
		return true;
		
  }

  
}

?>