<?php include 'session.php';?>

<!DOCTYPE html>
<html lang="en">

<?php include 'head.php';?>

<body>
	<?php 
		if($_SESSION['type'] == 'csrs')
			include 'myInquiries_csrs.php';
		else if($_SESSION['type'] == 'hius')
			include 'myInquiries_hius.php';
		else if($_SESSION['type'] == 'supervisors')
			include 'myInquiries_supervisors.php';
	?>
</body>
</html>
