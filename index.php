<!DOCTYPE html>
<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- <link rel="stylesheet" href="/PostfixLiteAdmin/css/jumbotron-narrow.css"> -->
<link rel="stylesheet" href="css/jumbotron-narrow.css">
		
<title></title>
<script> 
$(function(){
	$("#header").load("inc/header.inc.php"); 
	$("#footer").load("inc/footer.inc.php"); 
});
</script>
</head>
<body> 
	<div class="container">
		<div id="header"></div>

		<?php
		define ('NO_CHANGE_PW', 'tr4vrFlR14d2U53K05UZAm5H1iE68p6t'); 		// This user password = no chnage in password
		define ("PAUSED", 1);                                               // seconds to pause after echo a normal message 
		define ("ERROR_PAUSE", 2);                                          // seconds to pause after echo an error message 
		
		session_start();
		include_once('config.inc.php');
		
        try{
			$dbHandle = new PDO("sqlite:$sqlite_dir/$sqlite_database");
		}catch( PDOException $exception ){
			echo "Can NOT connect to database : $sqlite_dir/$sqlite_database <br>";
			echo "Please check if :<br>";
			echo " 1. the path to the database is correct. <br>";
			echo " 2. the permission of $sqlite_database is accessible by php. <br>";
			echo " 3. the php module 'php7.0-sqlite3' or 'php5-sqlite3' has been installed. <br>";
			echo "<br>";
    		die("Error : ". $exception->getMessage());
		}
		
		include_once('inc/functions.inc.php');
		// check and create tables every time the page is accessed but not refered back by any inc file.
		if (count($_REQUEST) == 0 and !isset($_SERVER['HTTP_REFERER']))
			include_once('inc/database.inc.php');


		if (!empty($_GET)) {
			if ($_GET['page'] == 'create_user') {
		    	require_once('inc/user_create.inc.php');
		  	} elseif ($_GET['page'] == 'create_user_save'){
		  	  	require_once('inc/user_create_save.inc.php');
		  	} elseif ($_GET['page'] == 'del_user') {
		    	require_once('inc/del_user.inc.php');
		  	} elseif ($_GET['page'] == 'domain') {
		    	require_once('inc/domain.inc.php');
		  	} elseif ($_GET['page'] == 'edit_domain') {
		    	require_once('inc/domain_edit.inc.php');
		  	} elseif ($_GET['page'] == 'edit_domain_save') {
		    	require_once('inc/domain_edit_save.inc.php');
		  	} elseif ($_GET['page'] == 'edit_user') {
		    	require_once('inc/user_edit.inc.php');
		  	} elseif ($_GET['page'] == 'edit_user_save') {
		    	require_once('inc/user_edit_save.inc.php');
		  	} elseif ($_GET['page'] == 'edit_alias') {
		    	require_once('inc/alias_edit.inc.php');
		  	} elseif ($_GET['page'] == 'edit_alias_save') {
		    	require_once('inc/alias_edit_save.inc.php');
		  	} elseif ($_GET['page'] == 'del_alias') {
		    	require_once('inc/del_alias.inc.php');
		  	} elseif ($_GET['page'] == 'add_alias') {
		    	require_once('inc/alias_add.inc.php');
		  	} elseif ($_GET['page'] == 'add_alias_save') {
		    	require_once('inc/alias_add_save.inc.php');
			} elseif ($_GET['page'] == 'del_domain'){
				require_once('inc/del_domain.inc.php');
			}
		} else {
		  	echo "<h2>Domains</h2>";
		  	echo "<a href='index.php?page=edit_domain&domain_id=0'>Add Domain</a>";
		  	echo "<table class='table table-striped'>";
		  
		  	$line_count = "0";
		  	$sqlShowBlocked = 'SELECT * FROM domain;';
		  	$result = $dbHandle->query($sqlShowBlocked);
		  	if (!$result){
				echo $dbHandle->errorInfo();
		  	}
		  	while ($entry = $result->fetch()) {
		    	$domain = $entry['domain'];
		    	$domain_id = $entry['domain_id'];;
		    	$description = $entry['description'];
		    	$line_count++;
		    	echo "<tr>
		    			<td>$line_count</td>
		    			<td><a href='index.php?page=domain&domain_id=".$domain_id. "'>$domain</a></td>
		    			<td>$description</td><td><center></center></td>
		    			<td><a href='index.php?page=del_domain&domain_id=$domain_id'><img border=0 src='images/icon_del.png'><div id='del'></div></a></td>
		    	</tr>";
		  	}
		  	echo "</table>";
		}
		?>

		<div id="footer"></div>
	</div>
</body>
</html>
