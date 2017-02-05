<?php

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	// absolute path of the directories
	$sqlite_dir = "E:\CDa\SQLDATA\PostfixLiteAdmin";
} else {
	// absolute path of the directories
	// # The $sqlite_dir should be writable by the web server/php process.
	// # I used : chown -R www-data:www-data /etc/postfix/sqlite-db
	// #         chmod 777 /etc/postfix/sqlite-db
	// #         chmod 644 /etc/postfix/sqlite-db/vmail.sqlite3
	$sqlite_dir = "/etc/postfix/sqlite-db";
}
$sqlite_database = "vmail.sqlite3";

// The Below Options should be fine as defined.
$color1 = "#ABB2B7";
$color2 = "#C5D4E1";

?>
