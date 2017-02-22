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
								<input type="text" class="form-control" id="InquirySubject" placeholder="Enter subject" requred>
								<small class="form-text text-muted">Cannot be changed once submitted.</small>
							</div>
							<div class="form-group">
								<label for="InquiryBody">Body</label>
	    						<textarea class="form-control" id="InquiryBody" rows="3" placeholder="Enter body" required></textarea>
	    					</div>
	    					<div class="form-group">
								<label for="InquiryFile">Attachment</label><br>
								<label class="btn btn-default btn-file">
								    Browse <input type="file" id="InquiryFile" style="display: none;">
								</label>
	    					</div>
	    					<button style='float:right;' type="submit" class="btn btn-primary">Submit</button>
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
					                <th>Action</th>
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
					                <th>Action</th>
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
				if(table != null)
					table.destroy();

				table = $('#example').DataTable( {
			        "ajax": {
			        	url: "proxy.php?service=getThreads",
			      		dataSrc: function (json) { console.log(json); return json; }
					},
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
								$('td:eq(1)', nRow).html( $('td:eq(1)', nRow).html() + '  <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>');

						if ( aData['status'] != 'Closed' )
								$('td:eq(4)', nRow).html(  '<center><button type="button" id="action'+ aData['id'] +'" class="btn btn-default" title="Close"><span class="glyphicon glyphicon-folder-close"></span></button></center>' );
						else
								$('td:eq(4)', nRow).html(  '<center><button type="button" id="action'+ aData['id'] +'" class="btn btn-default" title="Open"><span class="glyphicon glyphicon-folder-open"></span></button></center>' );
				    }
			    } );		
			}
			getThreads();

			function modalAndReload(msg) {
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
				getThreads();
			}

			$('#newMessageForm').on('submit', function(e){
				e.preventDefault();
				myToggle();
				
				var data = {};
				data.threadId = 0;
				data.subject = $('#InquirySubject').val();
				data.message = $('#InquiryBody').val();
				data.attachment = $('#InquiryFile').val();

				$.post( "proxy.php?service=postMessage", JSON.stringify(data), function(data) {
					modalAndReload(data);
				});
			});
		} );
	</script>