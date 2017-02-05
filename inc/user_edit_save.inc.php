<?php

if (!isset($_REQUEST['email_id'])){
	die("email_id is not passed.");
}
$email_id = $_REQUEST['email_id'];
$domain = getDomainFromEmailId($email_id, 'domain');
$paused = PAUSED;
$referer = $_SESSION['referer_user'];

if (empty($_POST['local_part']) or empty($_POST['password']) or empty($_POST['name'])) {
	echo "<h3>Username, Full Name and Password should not be empty !</h3>";
	$paused = ERROR_PAUSE;
	echo "<head><meta HTTP-EQUIV='REFRESH' content='$paused; url=$referer'></head>";
} else {
  	$password = $_POST['password'];
  	if ($password !== NO_CHANGE_PW){
  		$hashed = ssha512($password);
  	}
  
    $name = $_POST['name'];
  	$maildir = $_POST['maildir'];
  	$local_part = $_POST['local_part'];
  	$modified = $_POST['modified'];
  	$quota = $_POST['quota'] * 1024;	// MB to KB
  	$active = 0;
  	if (isset($_POST['active']) and $_POST['active'] == 'on')  $active=1;
  	
  	$checkOk = true;
  	if ($active == 0){
  		$email = getEmailFieldFromId($email_id, 'email');
		if (! checkUserAlias($dbHandle, $email_id, $email, 'de-active', $referer)){
			$checkOk = false;
		}
  	}
  	
  	if ($checkOk){
  		if ($password == NO_CHANGE_PW){
  			$updQuery = "UPDATE mailbox SET email = '$local_part@$domain', name = '$name', 
  							local_part = '$local_part', quota = '$quota', modified = '$modified', 
  							modified = datetime('NOW', 'localtime'), active = $active WHERE email_id = $email_id;";
  		} else {
  			$updQuery = "UPDATE mailbox SET email = '$local_part@$domain', password = '$hashed', name = '$name', 
  							local_part = '$local_part', quota = '$quota', modified = '$modified', 
  							modified = datetime('NOW', 'localtime'), active = $active WHERE email_id = $email_id;";
  		}
  		$dbHandle->exec($updQuery);
  		echo "<h2>User updated.</h2>";
		echo "<head><meta HTTP-EQUIV='REFRESH' content='$paused; url=$referer'></head>";
	}
}


?>
