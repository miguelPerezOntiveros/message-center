<?php
	function checkPassword(){
		if($ldapconn = ldap_connect('127.0.0.1', '389') or die("Could not connect to LDAP server.")) {
			ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
	  		$ldapbind = ldap_bind($ldapconn, 'cn=root,dc=boomi-base22,dc=com', 'Bas3two2') or die ("Error trying to bind: ".ldap_error($ldapconn));
			
			$result = ldap_search($ldapconn, "ou=users,DC=boomi-base22,DC=com", "(cn=".$_POST['userName'].")") or die ("Error in search query: ".ldap_error($ldapconn));
			$data = ldap_get_entries($ldapconn, $result);

			$ohash = base64_decode(substr($data[0]["userpassword"][0], 6));
			$osalt = substr($ohash, 20);
			$ohash = substr($ohash, 0, 20);
			$nhash = pack("H*", sha1($_POST['password'].$osalt));

		
			$result = ldap_search($ldapconn, "ou=users,DC=boomi-base22,DC=com", "(member=uid=".$data[0]["uid"][0].",ou=users,dc=boomi-base22,dc=com)") or die ("Error in search query: ".ldap_error($ldapconn));
			$groupData = ldap_get_entries($ldapconn, $result);
			$type = $groupData[0]['cn'][0];
				
			if($ohash == $nhash)
				return array($type, $data[0]["dn"]);
		}
		return array();
	}

	session_start();
	unset($_SESSION['userName']);
	unset($_SESSION['type']);
	unset($_SESSION['dn']);
	session_destroy();

	if($_POST['userName']!="" && $_POST['password']!=""){ // got userName
		$typeAndDn = checkPassword();
		if(count($typeAndDn) == 0) { $incorrectPassword = true; }
		else //password is correct
		{
			session_start();
			$_SESSION['userName']=$_POST['userName'];		
			$_SESSION['type'] = $typeAndDn[0];
			$_SESSION['dn'] = $typeAndDn[1];
			if($redirect = true){
				header('Location: index.php');
				exit();
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'head.php';?>

<body>
	<div id = "container">
		<?php include 'menu.php';?>
		
		<div id ="body">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 bs-callout-left">
						<h2>Secure Messages</h2>
					</div>
					<br><br><br>
				</div>
				<br>
				<?php
					if($incorrectPassword){
						echo '<div class="alert alert-danger" role="alert">
						  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						  <span class="sr-only">Error:</span>
						  Invalid Credentials
						</div>';
					}
				?>
				<div class="row">
					<div class="col-lg-4 bs-callout-left col-lg-offset-4" style='background-color: #DDD'>
						</br></br>
						<form method="post" action=<?="'".basename($_SERVER['SCRIPT_NAME'])."'"?>>
							<!-- <div class="form-group">
								<label for="disabledTextInput">Disabled input</label>
								<input type="text" id="disabledTextInput" class="form-control" placeholder="Disabled input">
							</div>

							<div class="form-group">
								<label for="exampleInputFile">User Name</label>
								<input type="text" class="form-control-file" id="username">
								<small id="fileHelp" class="form-text text-muted">This is some placeholder block-level help text for the above input. It's a bit lighter and easily wraps to a new line.</small>
							</div>
 -->
							<p><input style="width: 100%" type="text" name="userName" placeholder="Username" required></p>
							<p><input style="width: 100%" type="password" name="password" placeholder="Password" required></p>
							<br><br>
							<p>	
							<input type="submit" name="submit">
								<button style="width: 100%" type="button" class="btn btn-success">Log In</button>
								<br><br>
								<button style="width: 100%" type="button" class="btn btn-warning">Create Account</button>
							</p>
							<br>
						</form>
					</div>
				</div>
			</div>
		</div> <!--id = "body"-->
		<?php include 'foot.php';?>
	</div>
</body>
</html>
