<?php include 'session.php';?>

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
					<div class="col-md-12 bs-callout-left">
						<h2>Message Center</h2>
					</div>
					<br><br><br>
					<div class="col-md-2 newInquiry">
						<a href="myInquiries.php"><button style="width: 100%;" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;Return</button></a>
					</div>
					<div class="col-md-2 newInquiry">
						<a id="chooseOwner" onclick='$("#ownerModal").modal("show");' class="hidden"><button style="width: 100%;" type="button" class="btn btn-primary">Change Owner</button></a>
					</div>
					<div class="col-md-2 newInquiry">
						<a id="chooseDelegate" onclick='$("#delegateModal").modal("show");' class="hidden"><button style="width: 100%;" type="button" class="btn btn-primary">Change Delegate</button></a>
					</div>
					<div class="col-md-2 newInquiry">
						<a id="choosePriority" onclick='$("#priorityModal").modal("show");' class="hidden"><button style="width: 100%;" type="button" class="btn btn-primary">Change Priority</button></a>
					</div>
					<div class="col-md-2 newInquiry">
						<a id="chooseStatus" onclick='$("#statusModal").modal("show");' class="hidden"><button style="width: 100%;" type="button" class="btn btn-primary">Change Status</button></a>
					</div>
					<div class="col-md-2 newInquiry" align="right">
						<a id="assignToMe" class="hidden"><button style="width: 100%;" type="button" class="btn btn-primary">Assign to me</button></a>
					</div>
				</div>

				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog"  id='humanModalMessage' role="document">
					</div>
				</div>
				<!-- owner -->
				<div class="modal fade" id="ownerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       						<h4 class="modal-title">Change Owner</h4>
							</div>
							<div class="modal-body">
								<div class="form-group">
									<label for="changeOwner">Owner</label>
		    						<input type='text' class="form-control" id="changeOwner"></textarea>
		    					</div>
								<div class="form-group">
									<label for="changeOwnerMessage">Message</label>
		    						<textarea class="form-control" id="changeOwnerMessage" rows="3" placeholder="Type a message"></textarea>
		    					</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        					<button type="button" id="changeOwnerSubmit" class="btn btn-primary">Submit</button>

							</div>
						</div>
					</div>
				</div>
				<!-- delegate -->
				<div class="modal fade" id="delegateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       						<h4 class="modal-title">Change Delegate</h4>
							</div>
							<div class="modal-body">
								<div class="form-group">
									<label for="changeDelegate">Delegate</label>
		    						<input type='text' class="form-control" id="changeDelegate"></textarea>
		    					</div>
								<div class="form-group">
									<label for="changeDelegateMessage">Message</label>
		    						<textarea class="form-control" id="changeDelegateMessage" rows="3" placeholder="Type a message"></textarea>
		    					</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        					<button type="button" id="changeDelegateSubmit" class="btn btn-primary">Submit</button>
							</div>
						</div>
					</div>
				</div>
				<!-- priority -->
				<div class="modal fade" id="priorityModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       						<h4 class="modal-title">Change Priority</h4>
							</div>
							<div class="modal-body">
								<div class="form-group">
									<label for="changePriority">Priority</label>
		    						<input type='text' class="form-control" id="changePriority"></textarea>
		    					</div>
								<div class="form-group">
									<label for="changePriorityMessage">Message</label>
		    						<textarea class="form-control" id="changePriorityMessage" rows="3" placeholder="Type a message"></textarea>
		    					</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        					<button type="button" id="changePrioritySubmit" class="btn btn-primary">Submit</button>
							</div>
						</div>
					</div>
				</div>
				<!-- status -->
				<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       						<h4 class="modal-title">Change Status</h4>
							</div>
							<div class="modal-body">
								<div class="form-group">
									<label for="changeStatus">Status</label>
		    						<input type='text' class="form-control" id="changeStatus"></textarea>
		    					</div>
								<div class="form-group">
									<label for="changeStatusMessage">Message</label>
		    						<textarea class="form-control" id="changeStatusMessage" rows="3" placeholder="Type a message"></textarea>
		    					</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        					<button type="button" id="changeStatusSubmit" class="btn btn-primary">Submit</button>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12" style='border-left-width: 5px; padding-left: 20px;'>
						<div>
							<span id='csr'></span><br>
							<span id='delegate'></span><br><br>
						</div>
						<div id="messages" style='border: 1px solid #DDD; background-color: #f8f8f8; padding: 1em;'></div>
					</div>
					<div class="col-md-12 bs-callout">
						<form id="newMessageForm">
							<div class="form-group">
								<label for="InquiryBody">New message</label>
	    						<textarea class="form-control" name="message" id="InquiryBody" rows="3" placeholder="Type a message" required=""></textarea>
	    					</div>
	    					<div class="form-group">
								<label for="InquiryFile">Attachment</label><br>
								<label class="btn btn-default btn-file">
								    Browse <input type="file" name="attachment" id="InquiryFile" style="display: none;">
								</label> <span id='label'></span>
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
	$(document).on('change', ':file', function() {
	    var input = $(this),
	        numFiles = input.get(0).files ? input.get(0).files.length : 1,
	        label = input.val().replace(/\\/g, '/').replace(/.*\//, ''),
	   	 	log = numFiles > 1 ? numFiles + ' files selected' : label;
	   	$('#label').text(log);
	});

		<?php 
			if($_SESSION['type'] == 'Employees'){
				echo "
						$('#chooseOwner').removeClass('hidden');
						$('#chooseDelegate').removeClass('hidden');
						$('#chooseStatus').removeClass('hidden');
						$('#choosePriority').removeClass('hidden');
					";
			}
		?>

		var message = null;
		function getMessages(){
			$.get(<?php echo '"proxy.php?service=getMessages&threadId='.$_GET['id'].'"'; ?>, function( data ) {
				message = $.parseJSON(data);

				console.log('%o',message);

				if(!message[0] || !message[0].csr)
					$('#assignToMe').removeClass('hidden');
				else
					$('#csr').html('CSR working on this thread: <b>'+message[0].csr+'</b>.');
				if(message[0] && message[0].delegate)
					$('#delegate').html('This thread is currently being delegated to: <b>'+message[0].delegate+'</b>.');
				
				$('#messages').html('');
				if(message[0])
				$.mWidget({
					data: message[0].messages,
					tplAjax: {
						url: 'messageTpl.html'
					},
					target: '#messages',
					customHandler: function(data) {
				        var defaultMessages = [
				        						'default message for delegate change',
										        'default message for owner change', 
										        'default message for priority change', 
										        'default message for status change'
										      ];

						$.each(data, function(i, entry) { // this $.each is not included inside the $.mWidget implementation, if needed, it can be added like shown here. We know it will not allways be necessary.
					        if(entry.isSystemMessage != 0){
						        entry.class = 'systemMessage';
						        entry.align = 'center';
					        	if(!entry.message)
					        		entry.message = defaultMessages[entry.isSystemMessage-1];
					        } else if( entry.author == <?php echo "'".$_SESSION['userName'].' '.$_SESSION['sn']."'"; ?> ) {
							    entry.class = 'myMessage';
					        	entry.align = 'right';
							} else {
							        entry.class = 'theirMessage';
							        entry.align = 'left';
							}
							if(entry.attachments){
								var res = '<hr><b>Attachment(s):&nbsp;</b>';
								entry.attachments.split(',').forEach(function(e){
									res += '<a class="attachments">'+e+'</a>, ';									
								})
								res = res.substring(0, res.length-2);
								entry.attachments = res;
							}
							else
								entry.attachments = '';
						});
						return data;
					}
				});
			});			
		}
		getMessages();

		function modalAndReload(msg) {
			msg = JSON.parse(msg);
			if(msg.error){
				$('#humanModalMessage').html('<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only"></span>&nbsp;Error: '+msg.error+'</div>');
				console.log(msg.error);
			}
			else{
				$('#humanModalMessage').html('<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span><span class="sr-only"></span>&nbsp;'+msg.success+'</div>');
				console.log(msg.success);		
			}

			$("#myModal").modal("show");
			setTimeout(function(){
				$("#myModal").modal("hide");
			}, 2500);
			getMessages();
		}

		$('#changeDelegateSubmit').click(function() {
			$('#delegateModal').modal('hide');

			var data = {};
			data.threadId = <?php echo $_GET['id']; ?>;
			data.delegateId = $('#changeDelegate').val();
			data.message = $('#changeDelegateMessage').val();
			data.isSystemMessage = 1;

			$.post( "proxy.php?service=postMessage", JSON.stringify(data), function(data) {
				modalAndReload(data);
			});
		});
		$('#changeOwnerSubmit').click(function() {
			$('#ownerModal').modal('hide');

			var data = {};
			data.threadId = <?php echo $_GET['id']; ?>;
			data.ownerId = $('#changeOwner').val();
			data.message = $('#changeOwnerMessage').val();
			data.isSystemMessage = 2;			

			$.post( "proxy.php?service=postMessage", JSON.stringify(data), function(data) {
				modalAndReload(data);
			});
		});
		$('#changePrioritySubmit').click(function() {
			$('#priorityModal').modal('hide');

			var data = {};
			data.threadId = <?php echo $_GET['id']; ?>;
			data.priority = $('#changePriority').val();
			data.message = $('#changePriorityMessage').val();
			data.isSystemMessage = 3;	

			$.post( "proxy.php?service=postMessage", JSON.stringify(data), function(data) {
				modalAndReload(data);
			});
		});
		$('#changeStatusSubmit').click(function() {
			$('#statusModal').modal('hide');

			var data = {};
			data.threadId = <?php echo $_GET['id']; ?>;
			data.status = $('#changeStatus').val();
			data.message = $('#changeStatusMessage').val();
			data.isSystemMessage = 4;

			$.post( "proxy.php?service=postMessage", JSON.stringify(data), function(data) {
				modalAndReload(data);
			});
		});

		$('#assignToMe').click(function() {
			var data = {};
			data.threadId = <?php echo $_GET['id']; ?>;
			data.ownerId = <?php echo "'".$_SESSION['dn']."'"; ?>;
			data.message = $('#changeOwnerMessage').val();
			data.isSystemMessage = 2;			

			$.post( "proxy.php?service=postMessage", JSON.stringify(data), function(data) {
				modalAndReload(data);
			});
		});

		$('#newMessageForm').on('submit', function(e){
			e.preventDefault();
				
			var data = {};
			data.threadId = <?php echo $_GET['id']; ?>;
			data.message = $('#InquiryBody').val();
			
			if(document.getElementById('InquiryFile').files[0] != undefined)
			{
		 		var reader = new FileReader();
		    	reader.readAsDataURL(document.getElementById('InquiryFile').files[0]);
		    	reader.onload = function () {
        			var base64 = reader.result;
		    		data.attachment = base64.substring(base64.indexOf(',')+1);

		    		console.log(data);
					$.post( "proxy.php?service=postMessage", JSON.stringify(data), function(data) {
						modalAndReload(data);
						$('#InquiryBody').val('');
						$('#InquiryFile').val('');
					});
				};
				reader.onerror = function (error) {
			        console.log('Error: ', error);
				};
			}
			else{
	    		console.log(data);
				$.post( "proxy.php?service=postMessage", JSON.stringify(data), function(data) {
					modalAndReload(data);
					$('#InquiryBody').val('');
					$('#InquiryFile').val('');
				});
			}
	
			/*
			var formData = new FormData($('#newMessageForm')[0]);
			formData.append('file', $('#InquiryFile')[0].files[0]);
			formData.append('threadId', <?php echo "'".$_GET['id']."'"; ?>);
			
			$.ajax({
				type: "POST",
				url: "proxy.php?service=postMessage",
				data: formData,
				success: function(response) {
					modalAndReload(response);
					$('#InquiryBody').val('');
					$('#InquiryFile').val('');
				},
				contentType: false,
    			processData: false
			});
			*/
		});
	</script>
</body>
</html>