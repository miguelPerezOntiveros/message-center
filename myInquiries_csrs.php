	<div id = "container">
		<div id ="body">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 bs-callout-left">
						<h2>Message Center</h2>
					</div>
					<br><br><br>
					<div class="col-lg-12 newInquiry">
						<span>
							<label class="switch" style="display: inline-block; vertical-align: middle;">
								<input type="checkbox" id="checkbox">
								<div class="slider round"></div>
							</label>
						</span>
						<span>
							<label id='displaying' style="display: inline-block; vertical-align: middle;"></label>
						</span>
					</div>
				</div>

				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog"  id='humanModalMessage' role="document">
					</div>
				</div>

				<br>
				<div class="row">
					<div class="col-lg-12">
						<table id="example" class="display" cellspacing="0" width="100%">
					        <thead>
					            <tr>
					                <th>id</th>
					                <th>User</th>
					                <th>Subject</th>
					                <th>Updated</th>
					                <th>Status</th>
					                <th>Priority</th>
					                <th>attachment</th>
					                <th>Action</th>
					            </tr>
					        </thead>
					        <tfoot>
					            <tr>
					                <th>id</th>
					                <th>User</th>
					                <th>Subject</th>
					                <th>Updated</th>
					                <th>Status</th>
					                <th>Priority</th>
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
			var table = null;
			function getThreads(own) {
				if(table != null)
					table.destroy();
				var invisibles = [0, 6];
				var columnReferences = {"attachmentsClip": 1, "actions": 5};
				if(!own){
					invisibles.push(1);
					for(var reference in columnReferences) {
						columnReferences[reference]--;
					}
				}
				$.get("proxy.php?service=getThreads&own=" + own, function(ajaxResponse){
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
					            { data: "customer", "defaultContent": "" },
					            { data: "subject", render: function (data, type, full, meta) {return "<a href='single.php?id="+full.id+"'>"+data+"</a>"; } },
					            { data: "lastUpdated" },
					            { data: "status" },
					            { data: "priority" },
					            { data: "hasAttachments" },
					            { data: null, render: function (data, type, full, meta) {return ''; }}
					        ],
					        "columnDefs": [{
				                "targets": invisibles,
				                "visible": false
				            }],
							"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
								if ( (Math.floor(aData['seen']))%2 == 0 )
									$('td', nRow).css( 'font-weight', 'bold');

								if ( aData['hasAttachments'] == 1 && $('td:eq('+columnReferences['attachmentsClip']+')', nRow).find('span').length == 0) 
									$('td:eq('+columnReferences['attachmentsClip']+')', nRow).html( $('td:eq('+columnReferences['attachmentsClip']+')', nRow).html() + '  <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>');

								if ( aData['status'] == 'Open' || aData['status'] == 'Reopened' )
										$('td:eq('+columnReferences['actions']+')', nRow).html( '<center><button type="button" id="action'+ aData['id'] +'" class="btn btn-default">Mark In Progress</button></center>' );
								if ( aData['status'] == 'In Progress' )
										$('td:eq('+columnReferences['actions']+')', nRow).html( '<center><button type="button" id="action'+ aData['id'] +'" class="btn btn-default">Mark Resolved</button></center>' );
					    }
				    });	
				});
			}	
		
			$('#checkbox').change(function () {
			    if ($(this).is(":checked")) {
					$('#displaying').text('Displaying only items assiged to you.');
					getThreads(true);
			    }
		        else {
					$('#displaying').text('Displaying all unassigned items.');
					getThreads(false);
		        }
			});
			$('#checkbox').click();

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
		} );
	</script>