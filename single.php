<!DOCTYPE html>
<html lang="en">

<?php include 'head.php';?>

<body>
	<!-- mWidget 0.1 -->
	<script src = "js/mWidget0.1.js"></script>

	<div id = "container">
		<?php include 'menu.php';?>
		<div id ="body">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 bs-callout-left">
						<h2>Message Center</h2>
					</div>
					<br><br><br>
					<div class="col-lg-2 newInquiry">
						<a href="myInquiries.php"><button style="width: 100%;" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;Return</button></a>
					</div>


					<div class="col-lg-2 newInquiry">
					</div>
					<div class="col-lg-2 newInquiry">
					</div>



					<div class="col-lg-2 newInquiry">
						<a id="changeOwner" class="hidden"><button style="width: 100%;" type="button" class="btn btn-primary">Change Delegate</button></a>
					</div>
					<div class="col-lg-2 newInquiry">
						<a id="changePriority" class="hidden"><button style="width: 100%;" type="button" class="btn btn-primary">Change Priority</button></a>
					</div>



					<div class="col-lg-2 newInquiry" align="right">
						<a id="assignToMe"><button style="width: 100%;" type="button" class="btn btn-primary">Assign to me</button></a>
					</div>
				</div>

				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
							</div>
							<div class="modal-body">
								<center id='humanModalMessage'></center> 
							</div>
							<div class="modal-footer">
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<div id="messages" style='border: 1px solid #DDD; background-color: #f8f8f8; padding: 1em;'></div>
					</div>
					<div class="col-lg-12 bs-callout">
						<form id="newMessageForm">
							<div class="form-group">
								<label for="InquiryBody">New message</label>
	    						<textarea class="form-control" id="InquiryBody" rows="3" placeholder="Type a message"></textarea>
	    					</div>
	    					<button style='float:right;' type="submit" class="btn btn-primary">Submit</button>
						</form>
					</div>
				</div>
			</div>
		</div> <!--id = "body"-->
		<?php include 'foot.php';?>
	</div>

	<script>
		<?php 
			if($_SESSION['type'] == 'Employees'){
				echo "
						$('#changeOwner').removeClass('hidden');
						$('#changePriority').removeClass('hidden');
						$('#changeOne').removeClass('hidden');
						$('#changeTwo').removeClass('hidden');
						";
			}
		?>

		var message = null;
		function getMessages(){
			$.get("singleMessage.txt", function( data ) {
				console.log('got messages.');
				message = $.parseJSON(data);

				$('#messages').html('');
				$.mWidget({
					data: message,
					tplAjax: {
						url: 'messageTpl.html'
					},
					target: '#messages',
					customHandler: function(data) {
						$.each(data, function(i, entry) { // this $.each is not included inside the $.mWidget implementation, if needed, it can be added like shown here. We know it will not allways be necessary.
							entry.class = (entry.name == <?php echo "'".$_SESSION['userName']."'"; ?>? 'myMessage': 'theirMessage');
							entry.align = (entry.name == <?php echo "'".$_SESSION['userName']."'"; ?>? 'right': 'left');
						});
						return data;
					}
				});
			});			
		}
		getMessages();

		$('#assignToMe').click(function() {
			$.post( "newMessage.txt", function( data ) {
				var response = $.parseJSON(data).response;
				if(response == 'ok') {
					if($('#assignToMe').children(0).text() == 'Unassign myself')
						$('#assignToMe').children(0).text('Assign to me');
					else
						$('#assignToMe').children(0).text('Unassign myself');
				}
			});
		});

		$('#newMessageForm').on('submit', function(e){
			e.preventDefault();
			$.post( "newMessage.txt", function(data) {
				var response = $.parseJSON(data).response;
				if(response == 'ok'){
					$('#humanModalMessage').text('Message sent successfully');
					getMessages();
				}
				else
					$('#humanModalMessage').text(response);

				$("#myModal").modal("show");
				setTimeout(function(){
					$("#myModal").modal("hide");
				}, 1500);
			});
		});
	</script>
</body>
</html>