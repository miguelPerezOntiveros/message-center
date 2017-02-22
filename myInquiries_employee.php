	<div id = "container">
		<?php include 'menu.php';?>
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
				table = $('#example').DataTable( {
					"ajax": {
			        	url: <?php echo '"proxy.php?service=getThreads&own='.own.'"'; ?>,
			      		dataSrc: function (json) { console.log(json); return json; }
					},
					"order": [[ 3, "desc" ]],
					"columns": [
			            { data: "id" },
			            { data: "ownerUid", "defaultContent": "" },
			            { data: "subject", render: function (data, type, full, meta) {return "<a href='single.php?id="+full.id+"'>"+data+"</a>"; } },
			            { data: "lastUpdated" },
			            { data: "status" },
			            { data: "priority" },
			            { data: "hasAttachments" },
			            { data: null, render: function (data, type, full, meta) {return ''; }}
			        ],
			        "columnDefs": [{
		                "targets": [0, 6],
		                "visible": false
		            }],
					"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
						if ( (Math.floor(aData['seen']))%2 == 0 )
							$('td', nRow).css( 'font-weight', 'bold');

						if ( aData['hasAttachments'] == 1 && $('td:eq(1)', nRow).find('span').length == 0) 
							$('td:eq(1)', nRow).html( $('td:eq(1)', nRow).html() + '  <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>');

						if ( aData['status'] == 'Open' || aData['status'] == 'Reopened' )
								$('td:eq(5)', nRow).html( '<center><button type="button" id="action'+ aData['id'] +'" class="btn btn-default">Mark In Progress</button></center>' );
						if ( aData['status'] == 'In Progress' )
								$('td:eq(5)', nRow).html( '<center><button type="button" id="action'+ aData['id'] +'" class="btn btn-default">Mark Resolved</button></center>' );
				    }
			    } );		
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

		} );
	</script>