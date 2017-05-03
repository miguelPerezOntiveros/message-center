<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="session.jsp" %>

<!DOCTYPE html>
<html>
<%-- 	<%@include file="session.jsp" %> --%>
<%@include file="head.jsp" %>

<body>
	<div id = "container">
		<%@include file="menu.jsp" %>
		<div id ="body">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 bs-callout-left">
						<h2>Message Center</h2>
					</div>
					<br><br><br>
					<br><br><br>
					<div class="col-lg-12">
						<%= "You are <b>" + 
							request.getSession().getAttribute("userName") + 
							"</b>, from the <b>" + 
							request.getSession().getAttribute("type") + 
							"</b> group. uid: <b>" + 
							request.getSession().getAttribute("dn") + 
							"</b> sn: <b>" + 
							request.getSession().getAttribute("sn") + 
							"</b>" %>
					</div>
					<br><br>
					<div class="col-lg-10 col-lg-offset-1">
						<img src="img/diagram.png" width="100%">
					</div>
				</div>
			</div>
		</div> <!--id = "body"-->
		<%@include file="foot.jsp" %>
	</div>
</body>
</html>