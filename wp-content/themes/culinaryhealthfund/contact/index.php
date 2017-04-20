<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/culinaryhealthfund/includes/init.inc.php');

$errors = false;

$whoArr = array("Participants", "Providers", "Employers");

if ($_REQUEST['action'] == "process") {
	
	die;
	
	/*
	
	Form emails... taking out email to go with show/hide divs
	
	if (!strlen($errorText)) {
		$contact = new Contact();
		
		$who          = $_POST['who_are_you'];
		$birthDate    = $_POST['birth_date'];
		$firstName    = $_POST['first_name'];
		$lastName     = $_POST['last_name'];
		$emailAddr    = $_POST['email'];
		$phone        = $_POST['phone'];
		$contactTime  = $_POST['best_time_to_contact'];
		$message      = $_POST['comment'];
		
		
		$validateFormErrors = $contact->validateContactForm($who, $birthDate, $firstName, $lastName, $emailAddr, $phone, $contactTime, $message);
		
		if ($validateFormErrors) {
			$errors = true;
		} else {
			echo 'Processing....';
			$contact->sendContactForm($who, $birthDate, $firstName, $lastName, $emailAddr, $phone, $contactTime, $message);
			echo("<script>location.href = '".SITE_URL."/thanks/';</script>");
		}
		
	}
	*/
}

if ($errors) {
	echo '<div class="alert alert-danger">';
	echo 'There were a few problems with the form below, please correct the following:<br><br>';
	echo '<ul>';
	foreach ($validateFormErrors as $e) {
		echo '<li>' . $e . '</li>';
	}
	echo '</ul>';
	echo '<br><br>';
	echo '</div>';
}


?>


<form action="<?php echo $_SERVER['REDIRECT_URL']; ?>" method="post" class="wpcf7-form" novalidate="novalidate">
    <div style="display: none;">
        <input type="hidden" name="action" value="process">
    </div>


    <p>
    
    </p>

	
	<div id="Participant-contact">
	<h3> Participants </h3>
	<p>
	<strong>If you are a Participant and you need help or you have questions click below:</strong><br>
	For help contact the Advocacy Department <br>
	<a href="mailto:advocacy@culinaryhealthfund.org">Advocacy@culinaryhealthfund.org</a><br>

	</p>
	</div>
	
	<div id="Provider-contact">
	<h3> Providers </h3>
	<p>
	<strong>If you are a Provider and you need help or you have questions click below:</strong><br>
	For help contact the Provider Services Department<br>
	<a href="mailto:healthcareservices@culinaryhealthfund.org">HealthcareServices@culinaryhealthfund.org</a>
	</p>
	</div>
	
	<div id="Employer-contact">
	<h3> Employers </h3>
	<p>
	<strong>If you are an Employer and you need help or you have questions click below:</strong><br>
	For help contact the Advocacy Department <br>
	<a href="mailto:advocacy@culinaryhealthfund.org">Advocacy@culinaryhealthfund.org</a><br>
	</p>
	</div>
	
	

	<!---
	
    <p>Birth Date<br>
    <span><input type="text" name="birth_date" value="<?php echo $birthDate;?>" size="40"></span>
    </p>
    
    <p>First Name<br>
    <span><input type="text" name="first_name" value="<?php echo $firstName;?>" size="40"></span>
    </p>
    
    <p>Last Name<br>
    <span><input type="text" name="last_name" value="<?php echo $lastName;?>" size="40"></span>
    </p>
    
    <p>Email<br>
    <span><input type="text" name="email" value="<?php echo $emailAddr;?>" size="40"></span>
    </p>
    
    <p>Phone<br>
    <span><input type="text" name="phone" value="<?php echo $phone;?>" size="40"></span>
    </p>
    
    <p>Best Time To Contact<br>
    <span><input type="text" name="best_time_to_contact" value="<?php echo $contactTime;?>" size="40"></span>
    </p>
    
    <p>Comment / Question<br>
    <span>
    <textarea name="comment" cols="40" rows="10"><?php echo $message;?></textarea>
    </span></p>

    <p><input type="submit" value="Send"></p>
    --->
    

</form>




