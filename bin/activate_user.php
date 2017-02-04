<?php

include_once('../functions.inc.php');
if (!isset($_REQUEST['email_id'])){
	die("email_id is not passed.");
}
$email_id = $_REQUEST['email_id'];

if (!isset($_REQUEST['switch_active'])){
	die("switch_active is not passed.");
}
$switch_active = $_REQUEST['switch_active'];

if ($switch_active == 'on') {
  	$updateQuery = "UPDATE mailbox SET active = 1 WHERE email_id = $email_id";
  	$dbHandle->exec($updateQuery);
} elseif ($switch_active == 'off') {
  	$updateQuery = "UPDATE mailbox SET active = 0 WHERE email_id = $email_id";
  	$dbHandle->exec($updateQuery);
} else {
}

$referer = $_SERVER['HTTP_REFERER'];
$paused = PAUSED;
echo "<head><meta HTTP-EQUIV='REFRESH' content='$paused; url=$referer'></head>";

?>
