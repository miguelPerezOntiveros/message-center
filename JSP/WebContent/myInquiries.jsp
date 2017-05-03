<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="session.jsp" %>

<!DOCTYPE html>
<html>

<%@include file="head.jsp" %>

<body>
	<%@include file="menu.jsp" %>

	<%	if(request.getSession().getAttribute("type").equals("csrs")) { %>
			<%@include file="myInquiries_csrs.jsp" %>
	<% 	} else if(request.getSession().getAttribute("type").equals("customers")) { %>
			<%@include file="myInquiries_customers.jsp" %>
	<% 	} else if(request.getSession().getAttribute("type").equals("supervisors")) { %>
			<%@include file="myInquiries_supervisors.jsp" %>
	<% 	} %>		
</body>
</html>