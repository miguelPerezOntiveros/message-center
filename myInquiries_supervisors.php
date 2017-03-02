	<div id = "container">
		<?php include 'menu.php';?>
		<div id ="body">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 bs-callout-left">
						<h2>Message Center</h2>
					</div>
					<br><br><br>
					<div class="col-lg-12">
						<div class="col-lg-12">
							<span>
								<label>Filter by: </label>
								<span style="padding-left: 3em;">
									<input type="radio" name="group1" value="none" checked> No filter								
								</span>
								<span style="padding-left: 3em;">
									<input type="radio" name="group1" value="hiu"> HIU
								</span>
								<span  style="padding-left: 3em;">
									<input type="radio" name="group1" value="csr"> CSR
								</span>
								<span  style="padding-left: 3em;">
									<input type="radio" name="group1" value="date"> Date Range
								</span>
							</span>
						</div>

						<br><br>

						<div class="col-lg-12">
							<div id="hiuSelectorDiv" class='hidden'>
								<label>HIU:</label>
								<select id="hiuSelector">
									<option value="jose.perez">jose.perez</option>
									<option value="ernesto.rivera">ernesto.rivera</option>
								</select>
							</div>

							<div id="csrSelectorDiv" class='hidden'>
								<label>CSR:</label>
								<select id="csrSelector">
									<option value="jose.perez">jose.perez</option>
									<option value="ernesto.rivera">ernesto.rivera</option>
								</select>
							</div>

							<div id="dateSelectorDiv" class='hidden'>
								<label>Start Date:</label>
								<input type="date" id="startDate">
								<label>End Date:</label>
								<input type="date" id="endDate">
							</div>
						</div>
						
						<br><br><br>

						<div class="col-lg-2">
							<button id='goFilter' style="width: 100%;" type="button" class="btn btn-primary">
								Apply Filter
							</button>
						</div>

						<br>

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
		Date.prototype.toDateInputValue = (function() {
		    var local = new Date(this);
		    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
		    return local.toJSON().slice(0,10);
		});
		$('#startDate').val(new Date().toDateInputValue());
		$('#endDate').val(new Date().toDateInputValue());

		$(document).ready(function() {
			var table = null;
			function getThreads(qs) {
				if(table != null)
					table.destroy();
				var invisibles = [0, 6];
				var columnReferences = {"attachmentsClip": 1, "actions": 5};
				console.log('qs to be sent is:' + qs);
				table = $('#example').DataTable( {
					"ajax": {
			        	url: "proxy.php?service=getThreads" + qs,
			      		dataSrc: function (json) { console.log('got this json back' + JSON.stringify(json) ); return json; }
					},
					"order": [[ 3, "desc" ]],
					"columns": [
			            { data: "id" },
			            { data: "ownerUid", "defaultContent": "" },
			            { data: "subject", render: function (data, type, full, meta) {return "<a href='single.php?id="+full.id+"'>"+ data +"</a>"; } },
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
			    } );		
			}
			$('#goFilter').click(function () {
				var qs = '';
				switch($('input[name=group1]:checked').val()){
					case 'hiu':
						qs = '&hiu=' + $('#hiuSelector').val();
					break;
					case 'csr':
						qs = '&csr=' + $('#csrSelector').val();
					break;
					case 'date':
						qs = '&start-date='+ $('#startDate').val() + '&end-date=' + $('#endDate').val();
					break;
					case 'none':

					break;
				}
				getThreads(qs);
			});
			$('#goFilter').trigger('click');

			$('input[type=radio][name=group1]').change(function() {
				switch(this.value){
					case 'hiu':
						$('#hiuSelectorDiv').removeClass('hidden');
						$('#csrSelectorDiv').addClass('hidden');
						$('#dateSelectorDiv').addClass('hidden');
					break;
					case 'csr':
						$('#hiuSelectorDiv').addClass('hidden');
						$('#csrSelectorDiv').removeClass('hidden');
						$('#dateSelectorDiv').addClass('hidden');
					break;
					case 'date':
						$('#hiuSelectorDiv').addClass('hidden');
						$('#csrSelectorDiv').addClass('hidden');
						$('#dateSelectorDiv').removeClass('hidden');
					break;
					case 'none':
						$('#hiuSelectorDiv').addClass('hidden');
						$('#csrSelectorDiv').addClass('hidden');
						$('#dateSelectorDiv').addClass('hidden');
					break;
				}
		    });
		} );
	</script>