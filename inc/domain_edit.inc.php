<?php

if (!isset($_REQUEST['domain_id'])){
	die("domain_id is not passed !");
}
$domain_id = $_REQUEST['domain_id'];
$_SESSION['referer_domain'] = $_SERVER['HTTP_REFERER'];


if ($domain_id == 0){		// 0 = means domain create
	$btnCaption = "Create Domain";
	$domain_ro = "";
	$entry = initNewDomainArray();
} else {
	$btnCaption = "Update Domain";
	$domain_ro = 'readonly="readonly"';

	$sqlShowDomain = "SELECT * FROM domain WHERE domain_id = $domain_id;";
	$result = $dbHandle->query($sqlShowDomain);
	$entry = $result->fetch();
}
	$domain = $entry['domain'];
  	$description = $entry['description'];
  	$aliases = $entry['aliases'];
  	$mailboxes = $entry['mailboxes'];
  	$maxquota = $entry['maxquota'];
  	$quota = $entry['quota'];
  	$transport = $entry['transport'];
  	$created = $entry['created'];
  	$modified = $entry['modified'];
  	$virtual = '';
  	$relay = '';
  	$local = '';
  	if ($transport == 'virtual') {$virtual='selected';} else if ($transport == 'local') {$local='selected';} else if ($transport == 'relay') {$relay = 'selected';}
?>

<form action='index.php?page=edit_domain_save&domain_id=<?php echo $domain_id?>' method='post'>
	<div class='col-sm-10'>
  		<table class='table'>
  			<tr>
  				<td>Domain Name: </td>
  				<td><input type='text' value='<?php echo $domain?>' name='domain' <?php echo $domain_ro?> /></td>
  			</tr>
  			<tr>
  				<td>Domain Description: </td>
  				<td><input type='text' value='<?php echo $description?>' name='description' /></td>
  			</tr>
  			<tr>
  				<td>Max Number of Aliases: </td>
  				<td><input type='text' size='3' value='<?php echo $aliases?>' name='aliases' /></td>
  			</tr>
  			<tr>
  				<td>Max Number of Mailboxs: </td>
  				<td><input type='text' size='3' value='<?php echo $mailboxes?>' name='mailboxes' /></td>
  			</tr>
  			<tr>
  				<td>Max Quota per Mailbox: </td>
  				<td><input type='text' size='5' value='<?php echo $maxquota?>' name='maxquota' /> MB</td>
  			</tr>
  			<tr>
  				<td>Default Mailbox Quota: </td>
  				<td><input type='text' size='5' value='<?php echo $quota?>' name='quota' /> MB</td>
  			</tr>
  			<tr>
  				<td>Transport Type: </td>
  				<td>
  					<select name='transport'>
      					<option value='virtual' <?php echo $virtual?> >Virtual</option>
      					<option value='relay' <?php echo $relay?> >Relay</option>
      					<option value='local' <?php echo $local?> >Local</option>
    				</select>
    			</td>
    		<tr>
    			<td>Date Last Updated: </td>
    			<td><?php echo $modified?> </td>
    		</tr>
    		<tr>
    			<td>Date Created: </td>
    			<td><?php echo $created?></td>
    		</tr>
    	</table>
  		<input type='submit' value='<?php echo $btnCaption?>' />
	</div>
</form>


<?php
function initNewDomainArray(){
	$entry = array();
	$entry['domain'] = '';
	$entry['description'] = '';
  	$entry['aliases'] = 25;
  	$entry['mailboxes'] = 25;
  	$entry['maxquota'] = 2048;
  	$entry['quota'] = 1024;
  	$entry['transport'] = 'virtual';
  	$entry['created'] = date('Y-m-d H:i:s');;
  	$entry['modified'] = date('Y-m-d H:i:s');;
  	$virtual = '';
  	$relay = '';
  	$local = '';
	return $entry;
}
 	
?>
