<?php
	if (!isset($_REQUEST['domain_id'])){
		die("domain_id is not passed.");
	}
	$domain_id = $_REQUEST['domain_id'];
	$domain = getDomainFieldFromId($domain_id, 'domain');
	$defaQuota = getDomainFieldFromId($domain_id, 'quota');
	
	$_SESSION['referer_user'] = $_SERVER['HTTP_REFERER'];
?>

<form action='index.php?page=create_user_save&domain_id=<?php echo $domain_id ?>' method='post'>
<table border='0'>
	<tr>
		<td>Username: </td><td><input type="text" name="local_part" />@
		<td><select name='domain'>";
			<?php
				$sqlAllDomains = "SELECT * FROM domain;";
				$result3 = $dbHandle->query($sqlAllDomains);
				while ($entry3 = $result3->fetch()) {
    				$alldomain = $entry3['domain'];
    				if ($domain == $alldomain){
    					 $selected = 'selected'; 
    					 $disabled = '';
    				} else {
    					 $selected = '';
    					 $disabled = 'disabled';
    				}
    				echo "<option value='".$alldomain."' $selected $disabled >".$alldomain."</option>";
  				}
  			?>
		</select></td>
	</tr>
	<tr><td>Password: </td><td><input type="password" name="password" /></td></tr>
	<tr><td>Full Name: </td><td><input type="text" name="name" /></td></tr>
	<tr><td>Quota: </td><td><input type="text" size="5" value="<?php echo $defaQuota?>" name="quota" />MB</td></tr>
	<tr><td>Active: </td><td><input type="checkbox" checked name="active" /></td></tr>
</table>
<input type="submit" value="Create User" />
</form>
