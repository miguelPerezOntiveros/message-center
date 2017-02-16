<?php
	function checkPassword(){
		if($ldapconn = ldap_connect('127.0.0.1', '389') or die("Could not connect to LDAP server.")) {
			ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
	  		$ldapbind = ldap_bind($ldapconn, 'cn=root,dc=boomi-base22,dc=com', 'Bas3two2') or die ("Error trying to bind: ".ldap_error($ldapconn));
			
			$result = ldap_search($ldapconn,"DC=boomi-base22,DC=com", "(cn=".$_POST['userName'].")") or die ("Error in search query: ".ldap_error($ldapconn));
			$data = ldap_get_entries($ldapconn, $result);

			$ohash = base64_decode(substr($data[0]["userpassword"][0], 6));
			$osalt = substr($ohash, 20);
			$ohash = substr($ohash, 0, 20);
			$nhash = pack("H*", sha1($_POST['password'].$osalt));

			$res = '';
			foreach (explode(',', $data[0]["dn"]) as $entry) {
				if(substr($entry, 0, 3) == 'ou='){
					if(strlen($res) > 0)
						$res .= ',';
					$res .= substr($entry, 3);
				}
			}
			
			if($ohash == $nhash)
				return $res;
		}
		return '';
	}

	session_start();
	unset($_SESSION['userName']);
	unset($_SESSION['type']);
	session_destroy();

	if($_POST['userName']!="" && $_POST['password']!=""){ // got userName
		if ($_POST['remember'] == 1) // got remember
		{
			setcookie('userName', $_POST['userName'], time()+2592000);
			$_COOKIE['userName'] = $_POST['userName']; 
		}
		else
		{
			setcookie('userName', '',-3600);
			$_COOKIE['userName'] = '';
		}
		if(strlen($type = checkPassword()) == 0) { $incorrectPassword = true; }
		else //password is correct
		{
			session_start();
			$_SESSION['userName']=$_POST['userName'];		
			$_SESSION['type'] = $type;
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
				<form method="post" action=<?="'".basename($_SERVER['SCRIPT_NAME'])."'"?>>
					<p><input type="text" name="userName" placeholder="Username" required></p>
					<p><input type="password" name="password" placeholder="Password" required></p>
					<p><input type="submit" value="Log In"></p>
				</form>
			</div>
		</div> <!--id = "body"-->
		<?php include 'foot.php';?>
	</div>
</body>
</html>
