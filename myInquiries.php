<?php include 'session.php';?>

<!DOCTYPE html>
<html lang="en">

<?php include 'head.php';?>

<body>
	<?php include 'menu.php';?>

	<?php 
		if($_SESSION['type'] == 'csrs')
			include 'myInquiries_csrs.php';
		else if($_SESSION['type'] == 'customers')
			include 'myInquiries_customers.php';
		else if($_SESSION['type'] == 'supervisors')
			include 'myInquiries_supervisors.php';
	?>
</body>
</html>
