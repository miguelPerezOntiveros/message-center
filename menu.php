<div style="background-color: #f0f0f0">		
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-4">
					<a href="index.php"><img src="img/base22.png" width="100em" alt="logo aquí" style="padding-top: 1em;"></a>
				</div>
				<div class="col-lg-4">
					<div class="menu">
						<?php
							if(isset($_SESSION['userName']))
								echo 'Welcome <b>'.$_SESSION['userName'].'</b>!';
						?>		
					</div>
				</div>
				<div class="col-lg-4">
					<div class="menu">
						<?php $hoverMenuLinkStyle = 'style="color: #1173BD; border-bottom: #1173BD solid 4px;"';
						if(isset($_SESSION['userName'])){  ?>
							<a href="index.php" <?php if(basename($_SERVER["PHP_SELF"]) == 'index.php') echo $hoverMenuLinkStyle;?> >Home</a>
							<a href="myInquiries.php" <?php if(basename($_SERVER["PHP_SELF"]) == 'myInquiries.php' || basename($_SERVER["PHP_SELF"]) == 'single.php') echo $hoverMenuLinkStyle;?> >My Inquiries</a>
						<?php
						} ?>
							<a href="logIn.php" <?php if(basename($_SERVER["PHP_SELF"]) == 'logIn.php') echo $hoverMenuLinkStyle;?> > <?php echo (isset($_SESSION['userName'])? 'Log Out': 'Log In'); ?></a>
					</div>
				</div>
				<br><br><br>
			</div>
		</div>
	</div>

	<div style="border-top: #1173BD solid 0.1em;"></div>
</div>
