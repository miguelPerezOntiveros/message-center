<div style="background-color: #f0f0f0">		
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-4">
					<a href="index.php"><img src="img/base22.png" width="100em" alt="logo aquí" style="padding-top: 1em;"></a>
				</div>
				<div class="col-lg-4">
					<div class="menu">
						<%
							if(request.getSession().getAttribute("userName") != null) {
								out.print("Welcome <b>" + request.getSession().getAttribute("userName") + "</b>!" );
							}
						%>		
					</div>
				</div>
				<div class="col-lg-4">
					<div class="menu">
						<%!
							String fileName = this.getClass().getName().substring(
									this.getClass().getName().lastIndexOf(".") + 1,
									this.getClass().getName().lastIndexOf("_")
							);
							String hoverMenuLinkStyle = "style='color: #1173BD; border-bottom: #1173BD solid 4px;'";
						%>
						<%
							if(request.getSession().getAttribute("userName") != null && !fileName.equals("logIn")) {
						%>
							<a href="index.jsp" <% if(fileName == "index.jsp") out.print(hoverMenuLinkStyle); %> >Home</a>
							<a href="myInquiries.jsp" <% if(fileName.equals("myInquiries.jsp") || fileName.equals("single.jsp")) out.print(hoverMenuLinkStyle);%> >My Inquiries</a>
						<%
						} %>
							<a href="logIn.jsp" <% if(fileName.equals("logIn.jsp")) out.print(hoverMenuLinkStyle);%> > <%= (request.getSession().getAttribute("userName") != null? "Log Out": "Log In") %></a>
					</div>
				</div>
				<br><br><br>
			</div>
		</div>
	</div>

	<div style="border-top: #1173BD solid 0.1em;"></div>
</div>