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
					                <th>Name</th>
					                <th>Position</th>
					                <th>Office</th>
					                <th>Extn.</th>
					                <th>Start date</th>
					                <th>Salary</th>
					            </tr>
					        </thead>
					        <tfoot>
					            <tr>
					                <th>Name</th>
					                <th>Position</th>
					                <th>Office</th>
					                <th>Extn.</th>
					                <th>Start date</th>
					                <th>Salary</th>
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
			$('#checkbox').change(function () {
			    if ($(this).is(":checked")) {
					$('#displaying').text('Displaying only items assiged to you.');
					if(table != null)
						table.destroy();
					table = $('#example').DataTable( {
				        "ajax": "service.txt",
				        "columnDefs": [{
						    "targets": 1,
						    "render": function (data, type, full, meta) {
						      return "<a href='single.php'>"+data+"</a>";
						    }
						}]
				    } );
			    }
		        else {
					$('#displaying').text('Displaying all unassigned items.');
					if(table != null)
						table.destroy();
					table = $('#example').DataTable( {
				        "ajax": "service.txt",
				        "columnDefs": [{
						    "targets": 1,
						    "render": function (data, type, full, meta) {
						      return "<a href='single.php'>"+data+"</a>";
						    }
						}]
				    } );
		        }
			});
			$('#checkbox').click();

		} );
	</script>