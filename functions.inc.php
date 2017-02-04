<?php

//include_once('inc/database.inc.php');

function ByteSize($bytes) {
  $size = $bytes / 1000;
  if($size < 1024) {
    $size = number_format($size, 2);
    $size .= ' KB';
  } else {
    if($size / 1000 < 1024) {
      $size = number_format($size / 1024, 2);
      $size .= ' MB';
    } else if ($size / 1000 / 1024 < 1024) {
      $size = number_format($size / 1000 / 1024, 2);
      $size .= ' GB';
    }
  }
  return $size;
}

function CheckAlias($email) {

}



function ssha512($password){
    $salt = substr(sha1(rand()), 0, 16);
  	$hashed = "{SSHA512}" . base64_encode(hash('sha512', $password . $salt, true) . $salt);
  	return $hashed;
}



function getDomainFieldFromId($domain_id, $field){
	$q = "SELECT $field as FVAL FROM domain WHERE domain_id = $domain_id;";
	$dbHandle = $GLOBALS['dbHandle'];
	$result = $dbHandle->query($q);
    $entry = $result->fetch();
	$ret = $entry['FVAL'];
	//echo "Domain Name is $domain";
	return $ret;
}


function getDomainFromEmailId($email_id, $field){
	$q = "SELECT d.$field as FVAL FROM domain d, mailbox m
			WHERE m.email_id = $email_id
			and d.domain_id = m.domain_id;";
	$dbHandle = $GLOBALS['dbHandle'];
	$result = $dbHandle->query($q);
    $entry = $result->fetch();
	$ret = $entry['FVAL'];
	return $ret;
}



function getEmailFieldFromId($email_id, $field){
	$q = "SELECT $field as FVAL FROM mailbox WHERE email_id = $email_id;";
	$dbHandle = $GLOBALS['dbHandle'];
	$result = $dbHandle->query($q);
    $entry = $result->fetch();
	$ret = $entry['FVAL'];
	//echo "Email is $email";
	return $ret;
}


function is_valid_domain_name($domain_name){
	$emailAddr = "test@".$domain_name;
    return filter_var($emailAddr, FILTER_VALIDATE_EMAIL);
}

?>
