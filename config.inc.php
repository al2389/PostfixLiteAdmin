<?php

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	// absolute path of the directories
	$wwwdir = "E:\CDa\SQLDATA\PostfixLiteAdmin";
	$sitedir = "E:\CDa\SQLDATA\PostfixLiteAdmin";
	$sqlite_dir = "E:\CDa\SQLDATA\PostfixLiteAdmin";
} else {
	// absolute path of the directories
	$wwwdir = "/var/www/html/PostfixLiteAdmin";
	$sitedir = "/var/www/html/PostfixLiteAdmin";
	$sqlite_dir = "/etc/postfix/sqlite-db";
}
$sqlite_database = "vmail.sqlite3";

// The Below Options should be fine as defined.
$color1 = "#ABB2B7";
$color2 = "#C5D4E1";
$bin_site = "$sitedir/bin";
$ccs_site = "$sitedir/ccs";
$img_site = "$sitedir/images";

$bin_dir = "$wwwdir/bin";
$ccs_dir = "$wwwdir/ccs";
$img_dir = "$wwwdir/images";

?>
