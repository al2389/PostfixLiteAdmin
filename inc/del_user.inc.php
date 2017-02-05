<?php
include_once(dirname(__FILE__).'/../functions.inc.php');

if (!isset($_REQUEST['email_id'])){
	die("email_id is not passed.");
}
$email_id = $_REQUEST['email_id'];
$email = getEmailFieldFromId($email_id, 'email');

$referer = $_SERVER['HTTP_REFERER'];
$paused = PAUSED;

if (checkUserAlias($dbHandle, $email_id, $email, 'delete', $referer)){
	$delQuery = "DELETE FROM mailbox WHERE email_id = $email_id";
	$dbHandle->exec($delQuery);
	echo "<h2>Deleted $email</h2>";
	echo "<head><meta HTTP-EQUIV='REFRESH' content='$paused; url=$referer'></head>";
}

?>
