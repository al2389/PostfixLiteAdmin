<?php

include_once(dirname(__FILE__).'/../functions.inc.php');

if (!isset($_REQUEST['email'])){
	$_REQUEST['email'] = 'dead';
}
$email = $_REQUEST['email'];

if (!isset($_REQUEST['domain'])){
	$_REQUEST['domain'] = 'dead';
}
$domain = $_REQUEST['domain'];

$delQuery = "DELETE FROM alias WHERE email = '$email'";
$dbHandle->exec($delQuery);

echo "<h2>Deleted $email</h2>";
echo "<head><meta HTTP-EQUIV='REFRESH' content='0; url=view_domain.php?domain=".$domain."'></head>";

?>
