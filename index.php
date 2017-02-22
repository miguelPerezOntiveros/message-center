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
					<div class="col-lg-12">
						<?php echo 'You are <b>'.$_SESSION['userName'].'</b>, from the <b>'.$_SESSION['type'].'</b> group. DN: <b>'.$_SESSION['dn'].'</b>'; ?>
					</div>
					<br><br>
					<div class="col-lg-10 col-lg-offset-1">
						<img src="diagram.png" width="100%">
					</div>
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
