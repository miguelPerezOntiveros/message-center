<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>

<%@ page import="java.util.Hashtable" %>
<%@ page import="javax.naming.*" %>
<%@ page import="javax.naming.ldap.*" %>
<%@ page import="javax.naming.directory.*" %>

<!DOCTYPE html>
<html>

<%@include file="head.jsp" %>

<body>
	<div id = "container">
		<%@include file="menu.jsp" %>
		<%!
			boolean incorrectPassword = false;
			
			private String[] getUserAttributes(String userName) {
				StringBuilder sb = new StringBuilder();
				/*
				Hashtable env = new Hashtable();
				env.put(Context.INITIAL_CONTEXT_FACTORY, "com.sun.jndi.ldap.LdapCtxFactory");
				env.put(Context.PROVIDER_URL, "ldap://172.16.0.118:389/");
				
				try {
					LdapContext ldap = new InitialLdapContext(env, null);
					NamingEnumeration results = ldap.search("ou=users,DC=boomi-base22,DC=com", "(uid=" + userName + ")", null);
				
					if (!results.hasMoreElements()) 
						sb.append("No results found.");
					
					while (results.hasMore()) {
						SearchResult sr = (SearchResult) results.next();
						Attributes attrs = sr.getAttributes();
						sb.append("Uid: " + attrs.get("uid"));
					}
					ldap.close();
				} catch (NamingException e) {
					e.printStackTrace();
				}
				
				
				----------- PHP version from https://github.com/miguelPerezOntiveros/message-center/blob/master/logIn.php:
				if($ldapconn = ldap_connect('127.0.0.1', '389') or die("Could not connect to LDAP server.")) {
					ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
			  		$ldapbind = ldap_bind($ldapconn, 'cn=root,dc=boomi-base22,dc=com', 'Bas3two2') or die ("Error trying to bind: ".ldap_error($ldapconn));
					
					$result = ldap_search($ldapconn, "ou=users,DC=boomi-base22,DC=com", "(uid=".$_POST['userName'].")") or die ("Error in search query: ".ldap_error($ldapconn));
					$data = ldap_get_entries($ldapconn, $result);
					$ohash = base64_decode(substr($data[0]["userpassword"][0], 6));
					$osalt = substr($ohash, 20);
					$ohash = substr($ohash, 0, 20);
					$nhash = pack("H*", sha1($_POST['password'].$osalt));
					$result = ldap_search($ldapconn, "ou=users,DC=boomi-base22,DC=com", "(member=uid=".$data[0]["uid"][0].",ou=users,dc=boomi-base22,dc=com)") or die ("Error in search query: ".ldap_error($ldapconn));
					$groupData = ldap_get_entries($ldapconn, $result);
					$type = $groupData[0]['cn'][0];
					
					if($ohash == $nhash)
						return array($type, $data[0]["uid"][0], $data[0]["sn"][0], $data[0]["cn"][0]);
				}
				return array();
				*/
				String type = userName;
				return new String[] { type, "jose.perez", "Perez Ontiveros", "Jose Miguel", sb.toString()}; //type, uid, sn, cn, log
			}
		%>
		<%
			//log out
			request.getSession().removeAttribute("userName");
			request.getSession().removeAttribute("type");
			request.getSession().removeAttribute("dn");
			request.getSession().removeAttribute("sn");
			
			//log in if user has submited
			if(request.getParameter("userName") != null && 
			request.getParameter("userName").length() > 0 && 
			request.getParameter("password") != null && 
			request.getParameter("password").length() > 0 ) {
				String[] userInfo = getUserAttributes(request.getParameter("userName").toString());
				
				if(userInfo[0] == "") { incorrectPassword = true; }
				else 
				{	
					//password is correct
					request.getSession().setAttribute("userName", userInfo[3]);
					request.getSession().setAttribute("type", userInfo[0]);
					request.getSession().setAttribute("dn", userInfo[1]);
					request.getSession().setAttribute("sn", userInfo[2]);

					if(true){
						response.sendRedirect("index.jsp");
					}
				}
			}
		%>
		
		<div id ="body">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 bs-callout-left">
						<h2>Secure Messages</h2>
					</div>
					<br><br><br>
				</div>
				<br>
				<%
					if(incorrectPassword) {  
				%>
						<div class="alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only">Error:</span> Invalid Credentials
						</div>';
				<%
					}
				%>
				<div class="row">
					<div class="col-lg-4 bs-callout-left col-lg-offset-4" style='background-color: #DDD'>
						<br/><br/>
						<form method="post" id='loginForm'>
							<div class="form-group">
								<label for="userName">User name</label>
								<input type="text" id="userName" name="userName" class="form-control" placeholder="User name">
							</div>

							<div class="form-group">
								<label for="exampleInputFile">Password</label>
								<input type="password" id="password" name="password" class="form-control" placeholder="Password">
							</div>
							<br>
							<p>	
								<button style="width: 100%" type="button" class="btn btn-success" id='submitBtn' onclick="$('#loginForm').submit();">Log In</button>
								<br><br>
								<button style="width: 100%" type="button" class="btn btn-warning">Create Account</button>
							</p>
							<br>
						</form>
					</div>
				</div>
				<script type="text/javascript">
					$('.form-control').keypress(function(event) {
					    if (event.keyCode == 13 || event.which == 13) {
					        $('#loginForm').submit();
					    }
					});
					var conn = new WebSocket('ws://172.16.0.118:8082');
					conn.onopen = function(e) {
					    console.log("Connection established!");
					};
					conn.onmessage = function(e) {
					    console.log(e.data);
					};
				</script>
			</div>
		</div> <!--id = "body"-->
		<%@include file="foot.jsp" %>
	</div>
</body>
</html>