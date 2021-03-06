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
					                <th>Mark as</th>
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
					                <th>Mark as</th>
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
			Window.actionBtnClick = function(e){
				var formData = new FormData();
				formData.append('threadId', $(e.target).data('id'));
				formData.append('isSystemMessage', 4);
				formData.append('status', $(e.target).data('action')); //closed
				
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
			};
			var table = null;
			function getThreads(own) {
				$('#example').css('visibility', 'hidden');
				if(table != null)
					table.destroy();
				var invisibles = [0, 6];
				var columnReferences = {"attachmentsClip": 1, "markAs": 5};
				if(!own){
					invisibles.push(1);
					invisibles.push(7);
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
								if ( Math.floor(aData['seen']/(<?php echo '"'.$_SESSION['userName'].' '.$_SESSION['sn'].'"' ?> == aData['csr']? 1 : 2)) % 2 == 0 )
									$('td', nRow).css( 'font-weight', 'bold');

								if ( aData['hasAttachments'] == 1 && $('td:eq('+columnReferences['attachmentsClip']+')', nRow).find('span').length == 0) 
									$('td:eq('+columnReferences['attachmentsClip']+')', nRow).html( $('td:eq('+columnReferences['attachmentsClip']+')', nRow).html() + '  <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>');

								if ( aData['status'] == 'Open' )
									$('td:eq('+columnReferences['markAs']+')', nRow).html('<a onclick="Window.actionBtnClick(event)" data-action="2" type="button" data-id="'+ aData['id'] +'" href="#">In Progress</button>' );
								else if ( aData['status'] == 'In Progress' )
									$('td:eq('+columnReferences['markAs']+')', nRow).html('<a onclick="Window.actionBtnClick(event)" data-action="3" type="button" data-id="'+ aData['id'] +'" 	href="#">Resolved</button>' );
								else {
									$('td:eq('+columnReferences['markAs']+')', nRow).html('N/A' );
								}
					    }
				    });	
					$('#example').css('visibility', 'visible');
				});
			}	
		
			$('#checkbox').change(function () {
			    if ($(this).is(":checked")) {
					$('#displaying').text('Displaying only items assigned to you.');
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
					getThreads($('#checkbox').is(":checked"));
			}
		} );
	</script>
