<?php

	//include_once('../functions.inc.php');
	include_once(dirname(__FILE__).'/../functions.inc.php');		// to fix Windows relative path

	if (!isset($_REQUEST['domain_id'])){
		die("domain_id is not passed.");
	}
	$domain_id = $_REQUEST['domain_id'];

	if (!isset($_REQUEST['email_id'])){
		die("email_id is not passed.");
	}
	$email_id = $_REQUEST['email_id'];
	$_SESSION['referer_alias'] = $_SERVER['HTTP_REFERER'];
?>

<form action='index.php?page=add_alias_save&email_id="<?php echo $email_id?>' method='post'>
<table border='0'>
	<tr>
		<td>Alias Email Address: </td>
		<td>
			<select name='email_id'>";
				<?php $sqlAllDomains = "SELECT * FROM mailbox where domain_id = $domain_id;";
					$result4 = $dbHandle->query($sqlAllDomains);
  					while ($entry4 = $result4->fetch()) {
    					$allemails = $entry4['email'];
    					$allemail_id = $entry4['email_id'];
    					if ($allemail_id == $email_id){
   							echo "<option value='".$allemail_id."' selected>".$allemails."</option>";
						} else {
							if ($email_id !== ''){
								echo "<option value='".$allemail_id."' disabled >".$allemails."</option>";
							} else {
								echo "<option value='".$allemail_id."' >".$allemails."</option>";
							}
						}
  					} 
  				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Send Mail To: </td>
		<td><input type="text" name="goto" /></td>
	</tr>

	<tr>
		<td>Active: </td>
		<td><input type="checkbox" checked name="active" /></td>
	</tr>
</table>
<input type="submit" value="Create Alias" /></form>
