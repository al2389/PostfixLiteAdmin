<?php
if (!isset($_REQUEST['domain_id'])){
	die("domain_id is not passed.");
}
$domain_id = $_REQUEST['domain_id'];
$domain = getDomainFieldFromId($domain_id, 'domain');
$paused = PAUSED;
$referer = $_SESSION['referer_user'];


if (userFieldsNotEmpty($dbHandle, $_POST['local_part'], $_POST['password'], $_POST['name'], $referer)){
	$local_part = $_POST['local_part'];
	$password = $_POST['password'];
  	$hashed = ssha512($password);
	
	$name = $_POST['name'];
	$quota = $_POST['quota'] * 1024;		// change MB to KB
	//$active = $_POST['active'];
	//if ($active == 'on') {$active='1';} else {$active='0';}
	$active = 0;
  	if (isset($_POST['active']) and $_POST['active'] == 'on')  $active=1;
  	
	$insmailQuery = "INSERT INTO mailbox (email, password, name, maildir, local_part, domain_id, quota, created, modified, active) VALUES 
	    				('$local_part@$domain', '$hashed', '$name', '$domain/$local_part@$domain/', '$local_part', '$domain_id',
	    				 '$quota', datetime('NOW', 'localtime'), datetime('NOW', 'localtime'), '$active')";
	$dbHandle->exec($insmailQuery);
	echo "<h2>User Added.</h2>";
	echo "<head><meta HTTP-EQUIV='REFRESH' content='$paused; url=$referer'></head>";
}


?>
