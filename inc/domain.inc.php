<?php
	if (!isset($_REQUEST['domain_id'])){
		//$_REQUEST['domain'] = 'dead';
		die("domain_id is not POSTed !");
	}
	$domain_id = $_REQUEST['domain_id'];

	$sqlShowBlocked = "SELECT * FROM domain WHERE domain_id = $domain_id;";
	$result = $dbHandle->query($sqlShowBlocked);
	$entry = $result->fetch();

	$domain = $entry['domain'];
	$description = $entry['description'];
	$aliases = $entry['aliases'];
	$mailboxes = $entry['mailboxes'];
	$maxquota = $entry['maxquota'];
	//$quota = ByteSize($entry['quota']);
	$quota = $entry['quota'] . "MB";
	$transport = $entry['transport'];

	echo "<h2>Options and Users in Domain $domain</h2>";
?>

<strong>Domain Name: </strong><?php echo $domain; ?> <br />
<strong>Domain Description: </strong> <?php echo $description; ?>

<div>
	<div class="col-sm-5">
		Max Number of Aliases: <?php echo $aliases; ?><br />
		Default User Quota: <?php echo $quota; ?><br />
	</div>
	<div class="col-sm-offset-5">
		Max Number of Mailboxes: <?php echo $mailboxes; ?><br />
		Default Transport: <?php echo $transport; ?><br />
	</div>
</div>
<br />
<div class="col-sm-offset-0">
	<a href='index.php?page=edit_domain&domain_id=<?php echo $domain_id; ?>'>Edit Domain</a> | <a href='index.php'>Back to Domain List</a><br />
</div>
<br />


<!-- ###################################################################### -->
<!--  ## Users in the Domain -->
<h3>Users in Domain</h3>
<a href='index.php?page=create_user&domain_id=<?php echo $domain_id?>'>Add User</a><br />
<table class='table table-striped'>
	<tr><td></td><td>Name:</td><td>Email Address:</td><td>Quota:</td><td>Modified Last:</td><td>Active:</td><td></td></tr>
	<?php
		$line_count = 0; 	// added by me

		$sqlShowUsers = "SELECT * FROM mailbox WHERE domain_id = '$domain_id' order by email;";
		$result2 = $dbHandle->query($sqlShowUsers);
		while ($entry2 = $result2->fetch()) {
		  $row_color = ($line_count % 2) ? $color1 : $color2;
		  $name = $entry2['name'];
		  $email = $entry2['email'];
		  $email_id = $entry2['email_id'];
		  //$quota = ByteSize($entry2['quota']);
		  $quota = ($entry2['quota'] / 1024) ."MB";
		  $modified = $entry2['modified'];
		  $active = $entry2['active'];
		  if ($active == 1) {$active='glyphicon-ok';$active_color='green';$switch_active='off';} else {$active='glyphicon-remove';$active_color='red';$switch_active='on';}

		  $line_count++;
		  echo "<tr bgcolor='$row_color'><td>$line_count</td>
	  				<td><a href='index.php?page=edit_user&email_id=".$email_id."'>$name</a></td>
	  				<td>$email</td><td>$quota</td><td><small>$modified<small></td>
	  				<td>
	  					<center>
	  						<!-- <a href='bin/activate_user.php?switch_active=$switch_active&email=$email&domain=$domain'> -->
	  							<div style='color:$active_color;' class='glyphicon $active'></div>
	  						<!-- </a> -->
	  					</center>
	  				</td>
	  				<td>
	  					<center>
	  						<a href='index.php?page=del_user&email_id=$email_id'><img border=0 src='images/icon_del.png'></a>
	  					</center>
	  				</td>
	  	  </tr>";
		}
	?>
</table>



<!-- ######################################################################  -->
<!-- ## Aliases in the Domain -->
<br>
<h3>Aliases in Domain</h3>
<a href='index.php?page=add_alias&domain_id=<?php echo $domain_id?>&email_id='>Add Alias</a><br />
<table class='table table-striped'>
	<tr>
		<td></td>
		<td>Email Address:</td><td>Deliver Mail To:</td><td>Modified Last:</td>
		<td>Active:</td>
		<td></td>
	</tr>
    <?php
		$line_count2 = 0;		// added by me
		$sqlShowAlias = "SELECT a.*, m.email FROM alias a, mailbox m 
							WHERE m.domain_id = $domain_id
							and m.email_id = a.email_id
							order by m.email;";
		$result5 = $dbHandle->query($sqlShowAlias);
		while ($entry5 = $result5->fetch()) {
	  		$row_color = ($line_count2 % 2) ? $color1 : $color2;
	  		$email = $entry5['email'];
	  		$goto_post = $entry5['goto'];
	  		//$domain = $entry5['domain'];
	  		$modified = $entry5['modified'];
	  		$active = $entry5['active'];
	  		$goto = str_replace(",", "<br />", $goto_post);
	  		if ($active == 1) {$active='glyphicon-ok';$active_color='green';$switch_active='off';} else {$active='glyphicon-remove';$active_color='red';$switch_active='on';}

	  		$line_count2++;
	  		echo "<tr bgcolor='$row_color'>
	  				<td>$line_count2</td>
	  				<td>
	  					<a href='index.php?page=edit_alias&email_id=$email_id'>$email</a>
	  				</td>
	  				<td>$goto</td>
	  				<td><small>$modified<small></td>
  					<td>
  						<center>
  							<!-- <a href='bin/activate_alias.php?switch_active=$switch_active&email_id=$email_id'>  -->
  								<div style='color:$active_color;' class='glyphicon $active'></div>
  							<!-- </a>  -->
  						</center>
  					</td>
  					<td>
  						<a href='index.php?page=del_alias&email_id=$email_id'><img border=0 src='images/icon_del.png'></a>
  					</td>
  			</tr>";
		}
	?>
</table>
