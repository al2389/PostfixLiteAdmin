<?php

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
    
    $valid = verifyAliasAddress($goto);
	if ($valid === false){
		echo "<h3>\"$goto\" contains invalid email address(es) !</h3>";
		$paused = ERROR_PAUSE;
	} else {
  		$active = 0;
  		if (isset($_POST['active']) and $_POST['active'] == 'on')  $active=1;
    	$insQuery = "INSERT INTO alias (email_id, goto, created, modified, active )VALUES
    				 ($email_id, '$goto', datetime('NOW', 'localtime'), datetime('NOW', 'localtime'), '$active')";
    	$dbHandle->exec($insQuery);
    	echo "<h2>Alias added.</h2>";
	}
}
$referer = $_SESSION['referer_alias'];
echo "<head><meta HTTP-EQUIV='REFRESH' content='$paused; url=$referer'></head>";

?>
