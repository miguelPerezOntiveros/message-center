<?php include 'session.php';?>

<!DOCTYPE html>
<html lang="en">

<?php include 'head.php';?>

<body>
	<div id = "container">
		<?php include 'menu.php';?>
		<div id ="body">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 bs-callout-left">
						<h2>Message Center</h2>
					</div>
					<br><br><br>
					<br><br><br>
					
					This is the Secure Messages Proof of Concept.<br>
					<?php echo 'You are '.$_SESSION['userName'].' from the group '.$_SESSION['type'].'. dn>'.$_SESSION['dn']; ?>
					<br><br><br>
					<img src="diagram.png">
				</div>
			</div>
		</div> <!--id = "body"-->
		<?php include 'foot.php'; ?>
	</div>

	<script>
		$(document).ready(function() {
		    $('#example').DataTable( {
		        "ajax": "service.txt"
		    } );
		} );
	</script>
</body>
</html>
