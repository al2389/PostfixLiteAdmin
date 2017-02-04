<?php

if (!isset($_REQUEST['email_id'])){
	die("email_id is not passed.");
}
$email_id = $_REQUEST['email_id'];
$domain = getDomainFromEmailId($email_id, 'domain');
$paused = PAUSED;

if (empty($_POST['local_part']) or empty($_POST['password'])) {
	echo "<h3>Username and Password should not be empty !</h3>";
	$paused = ERROR_PAUSE;
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
  	$active_post = $_POST['active'];
  	if ($active_post == 'on') {$active=1;} else {$active=0;}
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
}
$referer = $_SESSION['referer_user'];
echo "<head><meta HTTP-EQUIV='REFRESH' content='$paused; url=$referer'></head>";

?>
