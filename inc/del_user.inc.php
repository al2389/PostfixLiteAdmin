<?php
	include_once(dirname(__FILE__).'/../functions.inc.php');

	if (!isset($_REQUEST['email_id'])){
		die("email_id is not passed.");
	}
	$email_id = $_REQUEST['email_id'];
	$email = getEmailFieldFromId($email_id, 'email');

	$referer = $_SERVER['HTTP_REFERER'];
	$paused = PAUSED;

	// check if the user is alias to another ?
	$q = "select goto from alias where email_id = $email_id";
	$result = $dbHandle->query($q);
	$entry = $result->fetch();
	if ( $entry === false ){
		$chkOk1 = true;
	} else {
		$chkOk1 = false;
		echo "<h3>Can't delete User when his/her alias exists !</h3>";
	  	echo "<head><meta HTTP-EQUIV='REFRESH' content='2; url=$referer'></head>";
	}
	
	// if the above condition is Ok, the check if other users is aliasing to he/her
	if ($chkOk1){
		$q = "select goto from alias where goto = '$email'";
		$result = $dbHandle->query($q);
		$entry = $result->fetch();
		if ( $entry === false ){
			$delQuery = "DELETE FROM mailbox WHERE email_id = $email_id";
			$dbHandle->exec($delQuery);
			echo "<h2>Deleted $email</h2>";
			echo "<head><meta HTTP-EQUIV='REFRESH' content='$paused; url=$referer'></head>";
		} else {
			echo "<h3>Can't delete User when other user is aliasing to he/her !</h3>";
	  		echo "<head><meta HTTP-EQUIV='REFRESH' content='2; url=$referer'></head>";
		}
	}
	
?>
