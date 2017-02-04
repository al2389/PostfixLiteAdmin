<?php

if (!isset($_REQUEST['domain_id'])){
	die("domain_id is not passed !");
}
$domain_id = $_REQUEST['domain_id'];

$paused = PAUSED;
if (empty($_POST['domain'])) {
	echo "<h3>Domain name should not be empty !</h3>";
} else {
	// generate INSERT query
    $domain = $_POST['domain'];
    $description = $_POST['description'];
    $aliases = $_POST['aliases'];
    $mailboxes = $_POST['mailboxes'];
    $maxquota = $_POST['maxquota'];
    $quota = $_POST['quota'];
    $transport = $_POST['transport'];
	if ($domain_id == 0){
		if (is_valid_domain_name($domain)){
			$query = "INSERT INTO domain (domain, description, aliases, mailboxes, maxquota, quota, transport, created, modified) VALUES
						 ('$domain', '$description', '$aliases', '$mailboxes', '$maxquota', '$quota', '$transport', 
        				 datetime('NOW', 'localtime'), datetime('NOW', 'localtime'))";
        	$dbHandle->exec($query);
			echo "<h2>Domain created.</h2>";
		} else {
			echo "<h3>Domain name is not valid !</h3>";
			$paused = ERROR_PAUSE;
		}
	} else {
    	$query = "UPDATE domain SET domain = '$domain', description = '$description', aliases = '$aliases', mailboxes = '$mailboxes',
    					 maxquota = '$maxquota', quota = '$quota', transport = '$transport', modified = datetime('NOW', 'localtime') 
    					 WHERE domain_id= $domain_id;";
    	$dbHandle->exec($query);
		echo "<h2>Domain updated.</h2>";
	}
}
$referer = $_SESSION['referer_domain'];
echo "<head><meta HTTP-EQUIV='REFRESH' content='$paused; url=$referer'></head>";


?>
