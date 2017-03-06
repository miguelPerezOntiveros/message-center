<?php include 'session.php';?>

<!DOCTYPE html>
<html lang="en">

<?php include 'head.php';?>

<body>
	<?php 
		if($_SESSION['type'] == 'employees')
			include 'myInquiries_employees.php';
		else if($_SESSION['type'] == 'customers')
			include 'myInquiries_customers.php';
		else if($_SESSION['type'] == 'supervisors')
			include 'myInquiries_supervisors.php';
	?>
</body>
</html>
