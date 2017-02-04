<?php
	include_once(dirname(__FILE__).'/../functions.inc.php');

	if (!isset($_REQUEST['email_id'])){
		die("email_id is not passed.");
	}
	$email_id = $_REQUEST['email_id'];

	$delQuery = "DELETE FROM alias WHERE email_id = $email_id";
	$dbHandle->exec($delQuery);

	echo "<h2>Alias deleted</h2>";
	$referer = $_SERVER['HTTP_REFERER'];
  	$paused = PAUSED;
  	echo "<head><meta HTTP-EQUIV='REFRESH' content='$paused; url=$referer'></head>";
?>
