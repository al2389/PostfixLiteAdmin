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
  	$goto = $_POST['goto'];
	if (! filter_var($goto, FILTER_VALIDATE_EMAIL)){
		echo "<h3>\"$goto\" is not a valid email address !</h3>";
		$paused = ERROR_PAUSE;
	} else {
	  	$active_post = $_POST['active'];
  		if ($active_post == 'on') {$active=1;} else {$active=0;}
  		$updQuery = "UPDATE alias SET goto = '$goto', modified = datetime('NOW', 'localtime'), active = '$active' WHERE email_id = $email_id;";
  		$dbHandle->exec($updQuery);
  		echo "<h2>Alias updated</h2>";
	}
}
$referer = $_SESSION['referer_alias'];
echo "<head><meta HTTP-EQUIV='REFRESH' content='$paused; url=$referer'></head>";

?>
