<?php

$table_check_domain = $dbHandle->exec('SELECT domain FROM domain WHERE type = \'table\'');
if ( $table_check_domain === false ){
  	$sqlCreateTable = "CREATE TABLE domain (
  	domain_id INTEGER PRIMARY KEY,
  	domain TEXT NOT NULL UNIQUE,
  	description TEXT NOT NULL,
	aliases INTEGER NOT NULL default '0',
	mailboxes INTEGER NOT NULL default '0',
	maxquota INTEGER NOT NULL default '0',
	quota INTEGER NOT NULL default '0',
	transport TEXT NOT NULL,
	created INTEGER NOT NULL default '0000-00-00 00:00:00',
	modified INTEGER NOT NULL default '0000-00-00 00:00:00' );";
	$dbHandle->exec($sqlCreateTable);
}

$table_check_mailbox = $dbHandle->exec('SELECT email FROM mailbox WHERE type = \'table\'');
if ( $table_check_mailbox === false ){
  $sqlCreateTable = "CREATE TABLE mailbox (
  	email_id INTEGER PRIMARY KEY,
  	email TEXT NOT NULL UNIQUE,
  	domain_id INTEGER NOT NULL,
  	password TEXT NOT NULL,
  	name TEXT NOT NULL,
  	maildir TEXT NOT NULL,
  	local_part TEXT NOT NULL,
  	quota INTEGER NOT NULL default '0',
  	active INTEGER NOT NULL default '1',
  	created INTEGER NOT NULL default '0000-00-00 00:00:00',
  	modified INTEGER NOT NULL default '0000-00-00 00:00:00',
  	FOREIGN KEY(domain_id) REFERENCES domain(domain_id));";
  	$dbHandle->exec($sqlCreateTable);
}


// check if table/s needs to be created
$table_check_alias = $dbHandle->exec('SELECT email FROM alias WHERE type = \'table\'');
if ( $table_check_alias === false ){
  	$sqlCreateTable = "CREATE TABLE alias (
  	email_id INTEGER NOT NULL UNIQUE,
  	goto TEXT NOT NULL,
  	created INTEGER NOT NULL default '0000-00-00 00:00:00',
  	modified INTEGER NOT NULL default '0000-00-00 00:00:00',
  	active INTEGER NOT NULL default '1',
  	FOREIGN KEY(email_id) REFERENCES mailbox(email_id));";
  	$dbHandle->exec($sqlCreateTable);
}

$table_check_options = $dbHandle->exec('SELECT option FROM options WHERE type = \'table\'');
if ( $table_check_options === false ){
  $sqlCreateTable = "CREATE TABLE options (
  option TEXT NOT NULL PRIMARY KEY,
  value TEXT NOT NULL);";
  $dbHandle->exec($sqlCreateTable);
}
?>
