<?php
if (!isset($_REQUEST['domain_id'])){
	die("domain_id is not passed.");
}
$domain_id = $_REQUEST['domain_id'];
$referer = $_SERVER['HTTP_REFERER'];

$paused = PAUSED;

$q = "select email from mailbox where domain_id = $domain_id limit 1";
$result = $dbHandle->query($q);
$entry = $result->fetch();
if ( $entry === false ){
	$insQuery = "DELETE FROM domain WHERE domain_id = $domain_id";
	$dbHandle->exec($insQuery);
	echo "<h2>Domain Deleted.</h2>";
} else {
	$paused = ERROR_PAUSE;
	echo "<h3>Can't delete Domain when it is not empty !</h3>";
}
echo "<head><meta HTTP-EQUIV='REFRESH' content='$paused; url=$referer'></head>";

?>
