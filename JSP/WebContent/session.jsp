<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%
	if(	(request.getSession().getAttribute("type") == null ||
		request.getSession().getAttribute("type").toString().length() == 0 ||
		request.getSession().getAttribute("userName") == null || 
		request.getSession().getAttribute("userName").toString().length() == 0) &&
		!this.getClass().getName().substring(
				this.getClass().getName().lastIndexOf(".") + 1,
				this.getClass().getName().lastIndexOf("_")
		).equals("logIn") 
	){
		//out.print("" + request.getSession().getAttribute("userName"));
		response.sendRedirect("logIn.jsp");
	}
%>