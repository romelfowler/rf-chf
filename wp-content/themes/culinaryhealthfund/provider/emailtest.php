<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/culinaryhealthfund/includes/init.inc.php');
include_once (PATH_CLASS . 'Email.class.php');

if ($_REQUEST['action'] == "run_test") {
	
	
	$email = new Email();
	
	$recipients = array($_POST['email_addr']);
	$replyEmail = $_POST['email_addr'];
	
	$body = "Testing email.. please disregard and let the appropriate parties know you received this message. - CHF Website";
	$subject = "CHF Website (Test)";
	$email->sendEmail($body, $subject, $recipients, $replyEmail);


echo '<font color = "red"><strong> We\'ve sent a test email to: ' . $_POST['email_addr'] . '.</font><br><br>';

	
}


?>


<div class="container">
	
	<form method="POST" action="<?php echo $_SERVER['REDIRECT_URL']; ?>">
		<input type="hidden" name="action" value="run_test">
	
	<div class="row provider-form-row">
		
		<div class="col-md-8">
				Email Address<br>
				<input type="text" name="email_addr" value="<?php echo $_REQUEST['email_addr'];?>">
			
		</div>
		
		<div class="col-md-4">
							
		</div>
	
	</div>
	
	<div class="row provider-form-row">
		<div class="col-md-9"></div>
		<div class="col-md-3">
			<button type="submit" class="btn btn-primary">Send Test</button>
		</div>
	</div>
	
	</form>
	
</div>