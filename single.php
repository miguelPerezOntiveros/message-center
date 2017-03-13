<?php include 'session.php';?>

<!DOCTYPE html>
<html lang="en">

<?php include 'head.php';?>

<body>
	<!-- mWidget 0.1 -->
	<script src = "js/mWidget0.1.js"></script>

	<?php include 'menu.php';?>

	<div id = "container">
		<div id ="body">
			<div class="container">
				<div class="row">
					<div class="col-md-12 bs-callout-left">
						<h2 id="h2AtTop">Message Center</h2>
					</div>
					<br><br><br>
					<div class="col-md-2 newInquiry">
						<a href="myInquiries.php"><button style="width: 100%;" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;Return</button></a>
					</div>
					<div class="col-md-2 newInquiry" align="right">
						<form id="assignToMeForm" enctype="multipart/form-data">
							<input type="hidden" name="ownerId" value= <?php echo "'".$_SESSION['dn']."'"; ?> >
							<input type="hidden" name="isSystemMessage" value=2 >
							<input type="hidden" name="threadId" value=<?php echo "'".$_GET['id']."'"; ?>>
							<a id="assignToMe" class="hidden"><button style="width: 100%;" type="button" class="btn btn-primary">Assign to me</button></a>
						</form>
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
						<a id="chooseStatus" onclick='$("#statusModal").modal("show");'><button style="width: 100%;" type="button" class="btn btn-primary">Change Status</button></a>
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
								<form id="changeOwnerForm" enctype="multipart/form-data">
									<input type="hidden" name="threadId" value=<?php echo $_GET['id']; ?> >
									<input type="hidden" name="isSystemMessage" value="2">
									<div class="form-group">
										<label for="changeOwner">Owner</label>
			    						<input type='text' onKeyUp="completeCsr('csrs', '#changeOwner', '#ownerOptions')" class="form-control" name="owner" id="changeOwner"></textarea>
			    						<div class='options' id='ownerOptions'></div>
			    					</div>
									<div class="form-group">
										<label for="changeOwnerMessage">Message</label>
			    						<textarea class="form-control" name="message" id="changeOwnerMessage" rows="3" placeholder="Type a message"></textarea>
			    					</div>
								</form>
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
								<form id="changeDelegateForm" enctype="multipart/form-data">
									<input type="hidden" name="threadId" value=<?php echo $_GET['id']; ?> >
									<input type="hidden" name="isSystemMessage" value="1">
									<div class="form-group">
										<label for="changeDelegate">Delegate</label>
			    						<input type='text' onKeyUp="completeCsr('csrs', '#changeDelegate', '#delegateOptions')" class="form-control" name="delegate" id="changeDelegate">
			    						<div class='options' id="delegateOptions"></div>
			    					</div>
									<div class="form-group">
										<label for="changeDelegateMessage">Message</label>
			    						<textarea class="form-control" name="message" id="changeDelegateMessage" rows="3" placeholder="Type a message"></textarea>
			    					</div>
								</form>
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
								<form id="changePriorityForm" enctype="multipart/form-data">
									<input type="hidden" name="threadId" value=<?php echo $_GET['id']; ?> >
									<input type="hidden" name="isSystemMessage" value="3">
									<div class="form-group">
										<label for="changePriority">Priority</label>
			    						<input type='text' class="form-control" name="priority" id="changePriority">
			    					</div>
									<div class="form-group">
										<label for="changePriorityMessage">Message</label>
			    						<textarea class="form-control" name="message" id="changePriorityMessage" rows="3" placeholder="Type a message"></textarea>
			    					</div>
								</form>
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
								<form id="changeStatusForm" enctype="multipart/form-data">
									<input type="hidden" name="threadId" value=<?php echo $_GET['id']; ?> >
									<input type="hidden" name="isSystemMessage" value="4">
									<div class="form-group">
										<label for="changeStatus">Status</label>
			    						<input type='text' class="form-control" name="status" id="changeStatus"></textarea>
			    					</div>
									<div class="form-group">
										<label for="changeStatusMessage">Message</label>
			    						<textarea class="form-control" name="message" id="changeStatusMessage" rows="3" placeholder="Type a message"></textarea>
			    					</div>
								</form>
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
							<span id='delegate'></span><br>
							<span id='status'></span><br>
							<span id='priority'></span><br><br>
						</div>
						<div id="messages" style='border: 1px solid #DDD; background-color: #f8f8f8; padding: 1em;'></div>
					</div>
					<div class="col-md-12 bs-callout">
						<form id="newMessageForm" enctype="multipart/form-data">
							<input type="hidden" name="threadId" value=<?php echo "'".$_GET['id']."'"; ?>>
							<div class="form-group">
								<label for="InquiryBody">New message</label>
	    						<textarea class="form-control" name="message" id="InquiryBody" rows="3" placeholder="Type a message" required=""></textarea>
	    					</div>
	    					<div class="form-group">
								<label for="InquiryFile">Attachment</label><br>
								<label class="btn btn-default btn-file">
								    Browse <input type="file" name="attachments" id="InquiryFile" style="display: none;">
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
			if($_SESSION['type'] == 'csrs'){
				echo "
						$('#chooseDelegate').removeClass('hidden');
						$('#chooseStatus').removeClass('hidden');
						$('#choosePriority').removeClass('hidden');
					";
			}
			if($_SESSION['type'] == 'supervisors'){
				echo "
						$('#chooseOwner').removeClass('hidden');
						$('#chooseDelegate').removeClass('hidden');
						$('#chooseStatus').removeClass('hidden');
						$('#choosePriority').removeClass('hidden');
					";
			}
		?>

		var defaultMessages = [
			'delegate',
			'owner', 
			'priority', 
			'status'
		];

		var message = null;
		function getMessages(){
			$.get(<?php echo '"proxy.php?service=getMessages&threadId='.$_GET['id'].'"'; ?>, function( data ) {
				message = $.parseJSON(data);

				console.log('got Messages: %o',message);
				$('#h2AtTop').text(message[0].subject);

				if(!message[0] || !message[0].csr && <?php echo ($_SESSION['type'] == 'csrs' || $_SESSION['type'] == 'supervisros' ? 'true' : 'false'); ?>)
					$('#assignToMe').removeClass('hidden');
				else
					$('#csr').html('CSR working on this thread: <b>'+message[0].csr+'</b>.');
				if(!message[0] || !message[0].delegate)
					$('#delegate').html('');
				else
					$('#delegate').html('This thread is currently being delegated to: <b>'+message[0].delegate+'</b>.');
				
				$('#status').html('Status: <b>' + message[0].status + '</b>.');
				if(message[0].priority)
					$('#priority').html('Priority: <b>' + message[0].priority + '</b>.');

				if(message[0])
				$.mWidget({
					data: message[0].messages,
					tplAjax: {
						url: 'messageTpl.html'
					},
					target: '#messages',
					customHandler: function(data) {
						var currentMessages = $('#messages').find('.message').length;
						console.log('current messages: ' + currentMessages);
						data = data.slice(currentMessages);

						$.each(data, function(i, entry) { // this $.each is not included inside the $.mWidget implementation, if needed, it can be added like shown here. We know it will not allways be necessary.
					        if(entry.isSystemMessage != 0){
						        entry.class = 'systemMessage';
						        entry.align = 'center';
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
									res += '<a href="proxy.php?service=getAttachment&threadId='+message[0].id+'&messageId='+entry.id+'&attachment='+e+'" class="attachments">'+e+'</a>, ';									
								})
								res = res.substring(0, res.length-2);
								entry.attachments = res;
							}
							else
								entry.attachments = '';

							entry.authorFirstName = entry.author.substring(0, entry.author.indexOf(' '));
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

		$('#ownerModal').keypress(function(event) { if (event.keyCode == 13 || event.which == 13) { $('#changeOwnerSubmit').click(); }});
		$('#changeOwnerSubmit').click(function() {
			$('#ownerModal').modal('hide');
			postMessageAjax(new FormData($('#changeOwnerForm')[0]));
		});

		$('#delegateModal').keypress(function(event) { if (event.keyCode == 13 || event.which == 13) { $('#changeDelegateSubmit').click(); }});
		$('#changeDelegateSubmit').click(function() {
			$('#delegateModal').modal('hide');
			postMessageAjax(new FormData($('#changeDelegateForm')[0]));
		});

		$('#priorityModal').keypress(function(event) { if (event.keyCode == 13 || event.which == 13) { $('#changePrioritySubmit').click(); }});
		$('#changePrioritySubmit').click(function() {
			$('#priorityModal').modal('hide');
			postMessageAjax(new FormData($('#changePriorityForm')[0]));
		});
		
		$('#statusModal').keypress(function(event) { if (event.keyCode == 13 || event.which == 13) { $('#changeStatusSubmit').click(); }});
		$('#changeStatusSubmit').click(function() {
			$('#statusModal').modal('hide');
			postMessageAjax(new FormData($('#changeStatusForm')[0]));
		});

		$('#assignToMe').click(function() {
			postMessageAjax(new FormData($('#assignToMeForm')[0]));
		});

		$('#newMessageForm').on('submit', function(e){
			e.preventDefault();
			
			/*
			var data = {};
			data.threadId = <?php echo $_GET['id']; ?>;
			data.message = $('#InquiryBody').val();
			
			if(document.getElementById('InquiryFile').files[0] != undefined)
			{
		 		var reader = new FileReader();
		    	reader.readAsDataURL(document.getElementById('InquiryFile').files[0]);
		    	reader.onload = function () {
        			var base64 = reader.result;
		    		data.attachment = [{
			    		file : base64.substring(base64.indexOf(',')+1),
			    		name : document.getElementById('InquiryFile').files[0].name
		    		}];

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
			*/
			
			postMessageAjax(new FormData($('#newMessageForm')[0]));
			//formData.append('file', $('#InquiryFile')[0].files[0]);
		});
		function postMessageAjax(formData){
			$.ajax({
				type: "POST",
				url: "proxy.php?service=postMessage",
				data: formData,
				success: function(data) {
					modalAndReload(data);
					$('#InquiryBody').val('');
					$('#InquiryFile').val('');
				},
				contentType: "multipart/mixed; boundary=frontier",
				//contentType: false,
    			processData: false
			});
		}
		var options = [];
		$.get('proxy.php?service=getCsrs', function( data ) {
			console.log('getCsrs:');
			options['csrs'] = JSON.parse(data);
			console.log(options['csrs']);
		});
		$.get('proxy.php?service=getCustomers', function( data ) {
			console.log('getCustomers:');
			options['customers'] = JSON.parse(data);
			console.log(options['customers']);
		});
		function completeCsr(type, inputObj, optionsObj){
			$(optionsObj).html('');

			if($(inputObj).val().length > 3) {
				$.each(options[type], function(i, e){
					if(e.uid.includes($(inputObj).val()) || e.name.includes($(inputObj).val())){
						$(optionsObj).append('<span class="autoCompleteOption" onclick="$(\''+inputObj+'\').val(\''+e.uid+'\')">'+e.name+'</span>&nbsp;');
					}
				});				
			}
		}
	</script>
</body>
</html>