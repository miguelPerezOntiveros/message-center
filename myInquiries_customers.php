	<div id = "container">
		<div id ="body">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 bs-callout-left">
						<h2>Message Center</h2>
					</div>
					<br><br><br>
					<div class="col-lg-12 newInquiry" id='callout'>
						<button type="button" id="createBtn" onclick="myToggle();" class="btn btn-primary">Create New Inquiry</button>
						<form class="formToToggle" id="newMessageForm">
							<input type="hidden" name="threadId" value=0>
							<br>
							<div class="form-group">
								<label for="InquirySubject">Subject</label>
								<input type="text" name="subject" class="form-control" id="InquirySubject" placeholder="Enter subject" requred>
								<small class="form-text text-muted">Cannot be changed once submitted.</small>
							</div>
							<div class="form-group">
								<label for="InquiryBody">Body</label>
	    						<textarea class="form-control" name="message" id="InquiryBody" rows="3" placeholder="Enter body" required></textarea>
	    					</div>
	    					<div class="form-group">
								<label for="InquiryFile">Attachment</label><br>
								<label class="btn btn-default btn-file">
								    Browse <input type="file" name="attachments" id="InquiryFile" style="display: none;">
								</label>&nbsp;<span id='fileLabel'></span>
	    					</div>
	    					<button style='float:right;' id="submitNewBtn" type="submit" class="btn btn-primary">Submit</button>
							<br>
						</form>
					</div>
				</div>

				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog"  id='humanModalMessage' role="document">
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
					                <th>Owner</th>
					                <th>Subject</th>
					                <th>Updated</th>
					                <th>Status</th>
					                <th>attachment</th>
					                <th>Actions</th>
					            </tr>
					        </thead>
					        <tfoot>
					            <tr>
					                <th>id</th>
					                <th>Owner</th>
					                <th>Subject</th>
					                <th>Updated</th>
					                <th>Status</th>
					                <th>attachment</th>
					                <th>Actions</th>
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
		$(document).on('change', ':file', function() {
		    var input = $(this),
		        numFiles = input.get(0).files ? input.get(0).files.length : 1,
		        label = input.val().replace(/\\/g, '/').replace(/.*\//, ''),
		   	 	log = numFiles > 1 ? numFiles + ' files selected' : label;
		   	$('#fileLabel').text(log);
		});
		$(document).ready(function() {

			myToggle = function (){
				$('.formToToggle').toggle('slow');
				if ( $('#callout').hasClass('bs-callout') )
					$('#callout').removeClass('bs-callout');
				else
					$('#callout').addClass('bs-callout');
			};
			$('.formToToggle').toggle();

			var table = null;
			function getThreads() {	
				$('#example').css('visibility', 'hidden');
				if(table != null)
					table.destroy();

				$.get("proxy.php?service=getThreads", function(ajaxResponse){
					console.log(ajaxResponse);
					ajaxResponse = JSON.parse(ajaxResponse);
					if(ajaxResponse.length > 0 && ajaxResponse[0].error)
						modalAndReload(JSON.stringify(ajaxResponse[0]), true);
					else
						table = $('#example').DataTable( {
					        "data": ajaxResponse,
							"order": [[ 3, "desc" ]],
					        "columns": [
					            { data: "id" },
					            { data: "ownerUid", "defaultContent": "" },
					            { data: "subject", render: function (data, type, full, meta) {return "<a href='single.php?id="+full.id+"'>"+data+"</a>"; } },
					            { data: "lastUpdated" },
					            { data: "status" },
					            { data: "hasAttachments" },
					            { data: null }
					        ],
					        "columnDefs": [{
				                "targets": [0, 5],
				                "visible": false
				            }],
							"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
								if ( (Math.floor(aData['seen']/4))%2 == 0 )
									$('td', nRow).css( 'font-weight', 'bold');

								if ( aData['hasAttachments'] == 1 && $('td:eq(1)', nRow).find('span').length == 0) 
										$('td:eq(1)', nRow).html( $('td:eq(1)', nRow).html() + '<span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>');

								switch(aData['status']) {
									case 'Open':
									case 'Closed': 
										$('td:eq(4)', nRow).html( '<font color="grey"><small>N/A</small><font color="grey">' );
									break;
									case 'Resolved': 
										$('td:eq(4)', nRow).html('<button class="actionBtn" data-action="4" type="button" id="'+ aData['id'] +'" class="btn btn-default" title="Close">Close</button>' +
																 '<button class="actionBtn" data-action="2" type="button" id="'+ aData['id'] +'" class="btn btn-default" title="Reopen">Reopen</button>' );
									break;
									default:
										$('td:eq(4)', nRow).html( '<button class="actionBtn" data-action="4" type="button" id="'+ aData['id'] +'" class="btn btn-default" title="Close">Close</button>' );
									break;
								}
						    }
					    });
					$('#example').css('visibility', 'visible');

					$('.actionBtn').click(function(e){
						var formData = new FormData();
						formData.append('threadId', e.target.id);
						formData.append('isSystemMessage', 4);
						formData.append('status', 4); //closed
						
						$.ajax({
							type: "POST",
							url: "proxy.php?service=postMessage",
							data: formData,
							success: function(data) {
								modalAndReload(data, false);
							},
							contentType: "multipart/mixed; boundary=frontier",
							//contentType: false,
			    			processData: false
						});
					});
				});
			}
	
			getThreads();

			function modalAndReload(msg, stay) {
				msg = JSON.parse(msg);
				if(msg.error){
					$('#humanModalMessage').html('<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only"></span>&nbsp;Error: '+msg.error+'</div>');
				}
				else{
					$('#humanModalMessage').html('<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span><span class="sr-only"></span>&nbsp;'+msg.success+'</div>');			
				}

				$("#myModal").modal("show");
				setTimeout(function(){
					$("#myModal").modal("hide");
				}, 2500);
				if(!stay)
					getThreads();
			}

			$('#newMessageForm').on('submit', function(e){
				e.preventDefault();
				myToggle();
				postMessageAjax(new FormData($('#newMessageForm')[0]));
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
		} );
	</script>