<?php 
require "./config.php";
require "./classes/Backup.php";

$database = new Backup;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Database B&R</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
</head>
<body>

  <div class="container-fluid text-center">
    <h1 class="text-success">Connected to <?php echo database; ?></h1>
  </div>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<form name="tForm" id="tForm" method="post" accept-charset="utf-8">
						<table class="table table-striped" >
							<thead>
								<tr>
									<th>Tables</th>
									<th>Rows(Approx)</th>
									<th class="text-center">Structure</th>
									<th class="text-center">Structure + Data</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($database->getAllTables() as $key => $table_name): ?>
									<tr>
										<td class="text-left"><?php echo $table_name['TABLE_NAME']; ?></td>
										<td class="text-center"><?php echo $table_name['TABLE_ROWS']; ?></td>
										<td class="text-center">
											<input value="<?php echo $table_name['TABLE_NAME']; ?>" class="cb_<?php echo $key; ?>" type="checkbox" name="structure[]"></td>
										<td class="text-center">
											<input value="<?php echo $table_name['TABLE_NAME']; ?>" class="cb_<?php echo $key; ?>" type="checkbox" name="structure_data[]"></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<input type="submit" name="tForm_submit" id="tForm_submit" class="btn btn-primary" value="Backup Tables">
					<input type="button" name="clear_data" id="clear_data" class="btn btn-danger" value="Clear All data">
					<input type="button" name="restore" id="restore" class="btn btn-info" value="Restore Old Data">
					<h5 class="label text-danger mt-2">Selected Tables will replace old ones during backup. Triggers are not included</h5>
				</form>
			</div>
		</div>
	</div>
	<div class="resp"></div>
	<script type="text/javascript">
		$(document).ready(function() {
		    var table = $('.table').DataTable({
		    	"columnDefs": [{
					"targets": [2,3],
					"orderable": false
					}]
		    });

		    //Check Uncheck checkboxes as we neeed to only select one checkbox from a row
		    // $('[class^="cb"]').click(function(){
		    // 	var cl = $(this).attr('class');
		    // 	$("."+cl).prop('checked', false);
		    // 	$(this).prop('checked', true);
		    // });

		    $("#tForm_submit").click(function(e){
		    	e.preventDefault();

		    	var data = table.$('input').serialize();

		    	$.ajax({
		    		url : './ajax/submit_tables.php',
		    		type: 'POST',
		    		data:{
		    			form_data : data
		    		},
		    		success:function(response){
		    			alert(response);
		    		}
		    	});

		    });

		    $("#clear_data").click(function(){

		    	if(confirm("are you sure?")) {
			    	$.ajax({
			    		url : './ajax/clear_data.php',
			    		type: 'POST',
			    		success:function(response){
			    			alert("Cleared");
			    		}
			    	});
		    	}

		    });

		    $("#restore").click(function(){
		    	$.ajax({
		    		url : './ajax/install.php',
		    		type: 'POST',
		    		success:function(response){
		    			alert(response);
		    		}
		    	});
		    });

		});
	</script>
</body>
</html>