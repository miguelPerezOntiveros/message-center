	<div id = "container">
		<?php include 'menu.php';?>
		<div id ="body">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 bs-callout-left">
						<h2>Message Center</h2>
					</div>
					<br><br><br>
					<div class="col-lg-12 newInquiry" id='callout'>
						<button type="button" onclick="myToggle();" class="btn btn-primary">Create New Inquiry</button>
						<form class="formToToggle" id="newMessageForm">
							<br>
							<div class="form-group">
								<label for="InquirySubject">Subject</label>
								<input type="text" class="form-control" id="InquirySubject" placeholder="Enter subject">
								<small class="form-text text-muted">Cannot be changed once submitted.</small>
							</div>
							<div class="form-group">
								<label for="InquiryBody">Body</label>
	    						<textarea class="form-control" id="InquiryBody" rows="3" placeholder="Enter body"></textarea>
	    					</div>
	    					<!--
	    					<div class="form-group">
								<label for="InquiryFile">Attachment</label><br>
								<label class="btn btn-default btn-file">
								    Browse <input type="file" id="InquiryFile" style="display: none;">
								</label>
	    					</div>
	    					-->
	    					<button style='float:right;' type="submit" class="btn btn-primary">Submit</button>
							<br>
						</form>
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

				<div class="formToToggle">
					<br><br>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<table id="example" class="display" cellspacing="0" width="100%">
					        <thead>
					            <tr>
					                <th>id</th>
					                <th>ownerUid</th>
					                <th>lastUpdated</th>
					                <th>subject</th>
					                <th>status</th>
					                <th>priority</th>
					                <th>seen</th>
					                <th>hasAttachments</th>
					            </tr>
					        </thead>
					        <tfoot>
					            <tr>
					                <th>id</th>
					                <th>ownerUid</th>
					                <th>lastUpdated</th>
					                <th>subject</th>
					                <th>status</th>
					                <th>priority</th>
					                <th>seen</th>
					                <th>hasAttachments</th>
					            </tr>
					        </tfoot>
					    </table>
					</div>
				</div>
			</div>
		</div> <!--id = "body"-->
		<?php include 'foot.php';?>
	</div>

	<script>
		function myToggle(){
			$('.formToToggle').toggle('slow');
			if ( $('#callout').hasClass('bs-callout') )
				$('#callout').removeClass('bs-callout');
			else
				$('#callout').addClass('bs-callout');
		};
		$('.formToToggle').toggle();
		$(document).ready(function() {
		    $('#example').DataTable( {
		        "ajax": "proxy.php?service=getThreads",
		        "columns": [
		            { "data": "id" },
		            { "data": "ownerUid" },
		            { "data": "lastUpdated" },
		            { "data": "subject" },
		            { "data": "status" },
		            { "data": "priority" },
		            { "data": "seen" },
		            { "data": "hasAttachments" }
		        ],
		        "columnDefs": [{
				    "targets": 3,
				    "render": function (data, type, full, meta) {
				      return "<a href='single.php'>"+data+"</a>";
				    }
				}]
		    } );
		} );

		$('#newMessageForm').on('submit', function(e){
			e.preventDefault();
			myToggle();
			$.post( "newMessage.txt", function(data) {
				var response = $.parseJSON(data).response;
				if(response == 'ok')
					$('#humanModalMessage').text('Message sent successfully');
				else
					$('#humanModalMessage').text(response);

				$("#myModal").modal("show");
				setTimeout(function(){
					$("#myModal").modal("hide");
				}, 1500);
			});
		});
	</script>