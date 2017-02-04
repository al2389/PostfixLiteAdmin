<?php

//include_once('../functions.inc.php');
include_once(dirname(__FILE__).'/../functions.inc.php');		// to fix Windows relative path

if (!isset($_REQUEST['email_id'])){
	die("email_id is not passed.");
}
$email_id = $_REQUEST['email_id'];
$paused = PAUSED;

if (empty($_POST['goto'])) {
	echo "<h3>\"Send Mail To:\" email should not be empty !</h3>";
	$paused = ERROR_PAUSE;
} else {
	$email = $_POST['email_id'];
    $goto = $_POST['goto'];
	if (! filter_var($goto, FILTER_VALIDATE_EMAIL)){
		echo "<h3>\"$goto\" is not a valid email address !</h3>";
		$paused = ERROR_PAUSE;
	} else {
	    $active = $_POST['active'];
    	$active = ($active == 'on' ? 1 : 0);
    	$insQuery = "INSERT INTO alias (email_id, goto, created, modified, active )VALUES
    				 ($email_id, '$goto', datetime('NOW', 'localtime'), datetime('NOW', 'localtime'), '$active')";
    	$dbHandle->exec($insQuery);
    	echo "<h2>Alias added.</h2>";
	}
}
$referer = $_SESSION['referer_alias'];
echo "<head><meta HTTP-EQUIV='REFRESH' content='$paused; url=$referer'></head>";

?>
