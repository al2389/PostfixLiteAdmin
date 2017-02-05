<?php
	if (!isset($_REQUEST['email_id'])){
		die("email_id is not passed.");
	}
	$email_id = $_REQUEST['email_id'];
	$domain = getDomainFromEmailId($email_id, 'domain');
	$domain_id = getDomainFromEmailId($email_id, 'domain_id');

	$_SESSION['referer_user'] = $_SERVER['HTTP_REFERER'];

	$q = "SELECT * FROM mailbox WHERE email_id = $email_id;";
	$result = $dbHandle->query($q);
	$entry = $result->fetch();

	$email = $entry['email'];
	$password = NO_CHANGE_PW;
	$name = $entry['name'];
	$maildir = $entry['maildir'];
	$local_part = $entry['local_part'];
	$created = $entry['created'];
	$modified = $entry['modified'];
	$quota = $entry['quota'] / 1024;		// KB to MB
	$active = $entry['active'];
	if ($active == 1) {$active='checked';} else {$active='';}
?>

<form action='index.php?page=edit_user_save&email_id=<?php echo $email_id?>' method='post'>
<table border='0'>
	<tr><td>Editing User: </td><td><strong><?php echo $name ?></strong></td></tr>
	<tr><td>Full Name: </td><td><input type='text' value='<?php echo $name ?>' name='name' /></td></tr>
	<tr><td>User Name: </td><td><input type='text' value='<?php echo $local_part ?>' name='local_part' /></td></tr>
	<tr><td>Domain: </td>
		<td>
			<select name='domain'>"
				<?php
					$sqlAllDomains = "SELECT * FROM domain;";
					$result3 = $dbHandle->query($sqlAllDomains);
					while ($entry3 = $result3->fetch()) {
  						$alldomain = $entry3['domain'];
  						if ($domain == $alldomain) {
  							$selected = 'selected'; 
  							$disabled = '';
  						} else {
  							$selected = '';
  							$disabled = 'disabled';
  						}
  						echo "<option value='".$alldomain."' $selected $disabled >".$alldomain."</option>";
					} 
				?>
			</select>
		</td>
	</tr>
	<tr><td>Email Address: </td><td><?php echo $email?></td></tr>
	<tr><td>Password: </td><td><input type='password' value='<?php echo $password?>' name='password' onClick='this.setSelectionRange(0, this.value.length)' /></td></tr>
	<tr>
		<td>Mail Directory: </td>
		<td><?php echo $maildir?><input type='hidden' value='.$maildir.' name='maildir' /></td>
	</tr>
	<tr>
		<td>Quota: </td>
		<td><input type='text' size='5' value='<?php echo $quota?>' name='quota' />MB</td>
	</tr>
	<tr>
		<td>User Active?: </td>
		<td><input type='checkbox' <?php echo $active?> name='active' /></td>
	</tr>
	<tr>
		<td>Last Updated: </td>
		<td><?php echo $modified?> <input type='hidden' value='<?php echo $modified?>' name='modified' /></td>
	</tr>
	<tr>
		<td>Created on: </td>
		<td><?php echo $created?> <input type='hidden' value='.$created.' name='created' /></td>
	</tr>
</table>
<input type='submit' value='Update User' /></form>


<br>
<h3>Aliases for <?php echo $name?></h3>
<?php
	$q = "select email_id from alias where email_id = $email_id";
	$chk = $dbHandle->query($q);
	$entry = $chk->fetch();
	if ( $entry === false ){
		echo "<a href='index.php?page=add_alias&domain_id=$domain_id&email_id=$email_id'>Add Alias</a><br />";
	}
?>
<table class='table table-striped'>
	<tr><td></td><td>Mails Alias To</td><td>Modified Last</td><td>Active</td><td></td><td></tr>
	
	<?php 
		$sqlShowAlias = "SELECT a.*, m.email FROM alias a, mailbox m 
							WHERE a.email_id = $email_id 
							and m.email_id = a.email_id;";
		$result5 = $dbHandle->query($sqlShowAlias);
		$row_count = 0;
		$line_count = 0;
		while ($entry5 = $result5->fetch()) {
			$row_color = ($row_count % 2) ? $color1 : $color2;
			$email = $entry5['email'];
			$goto_post = $entry5['goto'];
			$modified = $entry5['modified'];
			$active = $entry5['active'];
			if ($active == 1) {$active='check';} else {$active='del';}

			$line_count++;
  			echo "<tr bgcolor='$row_color'>
  					<td>$line_count</td>
  					<td>
  						<a href='index.php?page=edit_alias&email_id=".$email_id."'>$goto_post</a>
  					</td>
  					<td><small>$modified<small></td>
  					<td><center><div id=$active></div></center></td>
  					<td>
  						<a href='index.php?page=del_alias&email_id=$email_id'><img border=0 src='images/icon_del.png'></a>
  					</td>
  			</tr>";
		}
	?>
</table>
