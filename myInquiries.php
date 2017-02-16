<?php include 'session.php';?>

<!DOCTYPE html>
<html lang="en">

<?php include 'head.php';?>

<body>
	<?php 
		if($_SESSION['type'] == 'Employees')
			include 'myInquiries_employee.php';
		else if($_SESSION['type'] == 'People')
			include 'myInquiries_user.php';
	?>
</body>
</html>
