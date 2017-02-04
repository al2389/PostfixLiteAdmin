<?php
	if (!isset($_REQUEST['email_id'])){
		die("email_id is not passed.");
	}
	$email_id = $_REQUEST['email_id'];

	$_SESSION['referer_alias'] = $_SERVER['HTTP_REFERER'];

	$sqlShowAlias = "SELECT a.*, m.email FROM alias a, mailbox m 
						WHERE a.email_id = $email_id
						and m.email_id = a.email_id;";
	$result = $dbHandle->query($sqlShowAlias);
	$entry = $result->fetch();
	$email = $entry['email'];
	//$domain = $entry['domain'];
	$goto = $entry['goto'];
	$modified = $entry['modified'];
	$created = $entry['created'];
	$active = $entry['active'];
	if ($active == 1) {$active='checked';} else {$active='';}
?>
<form action='index.php?page=edit_alias_save&email_id=<?php echo $email_id ?>' method='post'>
	<table border='0'>
		<tr><td>Email Address: </td><td><strong><?php echo $email ?></strong></td></tr>
		<tr>
			<td>Send Mail To: </td>
			<td><input type="text"  value='<?php echo $goto ?>' name="goto" /></td>
			
			<?php
				//echo "<tr><td><input type='hidden' value='".$domain."' name='domain' /></td></tr>";
				//echo "<tr><td><input type='hidden' value='".$email."' name='email' /></td></tr>";
				
				echo "<tr><td>Alias Active?: </td><td><input type='checkbox' $active name='active' /></td></tr>";
				echo "<tr><td>Last Updated: </td><td>$modified</td></tr>";
				echo "<tr><td>Created on: </td><td>$created</td></tr>";
				//echo "<input type='submit' value='Update Alias' /></form>";
			?>
		</tr>
	</table>
    <input type='submit' value='Update Alias' />
</form>
