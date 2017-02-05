<?php

if (!sqlite_table_exists($dbHandle, 'domain')){
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

if (!sqlite_table_exists($dbHandle, 'mailbox')){
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


if (!sqlite_table_exists($dbHandle, 'alias')){
  	$sqlCreateTable = "CREATE TABLE alias (
  	email_id INTEGER NOT NULL UNIQUE,
  	goto TEXT NOT NULL,
  	created INTEGER NOT NULL default '0000-00-00 00:00:00',
  	modified INTEGER NOT NULL default '0000-00-00 00:00:00',
  	active INTEGER NOT NULL default '1',
  	FOREIGN KEY(email_id) REFERENCES mailbox(email_id));";
  	$dbHandle->exec($sqlCreateTable);
}




function sqlite_table_exists(&$dbHandle, $table){
	$ret = true;
	try {
    	$result = $dbHandle->query("select 1 from $table limit 1");
    	if ($result === false) $ret = false;
	} catch (Exception $e){
		die('Error : ' .$e->getMessage());
	}
    return $ret;
}

?>
