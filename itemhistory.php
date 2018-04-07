<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Items Warehouse</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<?php include 'csslibrary.php';?>
	<?php include 'jslibrary.php';?>
	
	<style>
	
		table.dataTable thead th { font-size: 15px; color: black;text-align: center;}
		a { cursor: pointer; }
		tr td { text-align: center; }
	</style>

</head>
<body>

<div class="wrapper">
	<?php include 'left-nav.php';?>
    <div class="main-panel">
        <?php include 'upper-nav.php';?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">                 
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
								<div class="row" style="margin:10px;">
									<div class="col-md-9">
										<h4 class="title">Item History</h4>
										<p class="category">*All Items</p>
									</div>
								</div>                   
                            </div>
                            <div class="content">
								<div class="row" style="margin:20px;">
									<div class="col-md-4">
										<label for="From">Item Name</label>
										<input type="text" class="form-control" id="itemautocomplete">
									</div>
									<div class="col-md-3">
										<label for="From">From: (DD/MM/YYYY)</label>
										<input type="text" class="form-control" placeholder="DD/MM/YYYY" value="01/04/2017" id="fromDate">
									</div>
									<div class="col-md-3">
										<label for="To">To: (DD/MM/YYYY)</label>
										<input type="text" class="form-control" placeholder="DD/MM/YYYY" id="toDate">
									</div>
									<div class="col-md-2">
										<br/>
										<button type="button" id="btnGetResult" class="btn" style="border-color: #2e6da4 ;background-color: #337ab7;color: white;">Get Result</button>
									</div>
								</div>
                                <div class="row" style="margin:20px;">
									<table id="itemHistoryDisplay" class="table table-condensed table-hover" width="100%"></table>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
				<input type="hidden" class="form-control" value = "-99" id="itemHiddensave">
            </div>
        </div>
    </div>
</div>
</body>
	<script type="text/javascript">
		
    	$( window ).load(function() {
		  // Run code
		});
		
		$(document).ready(function(){
			initTable();
			initItemName();
			function initItemName()
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 9},
					success: function (d) {
						dataRET=JSON.parse(d);
						autocompleteOptions = dataRET[0]
						$('#itemautocomplete').autocomplete({
							source: autocompleteOptions,
							minLength: 3,
							delay:800,
							autoFocus: true,
							open: function(event) {},
							close: function() {},
							focus: function(event,ui) {
							},
							select: function (e, ui) {
							}
						});
					},
					error: function (log) {
						console.log(log);
					}
				});
			}

			$( function() {
				$( "#fromDate" ).datepicker({ dateFormat: 'dd/mm/yy' });
				$( "#toDate" ).datepicker({ dateFormat: 'dd/mm/yy' });
				var d=new Date();
				$( "#toDate" ).val(d.getDate()+'/'+(d.getMonth()+1)+'/'+d.getFullYear())
			});
			
			$('#btnGetResult').on('click',function(){
				initTable();
			})
			function initTable()
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 22, itemName: $('#itemautocomplete').val().trim(), fromDate: $('#fromDate').val().trim(), toDate: $('#toDate').val().trim()},
					success: function (data1) {
						var arr = JSON.parse(data1);
						fillItemTable(arr);
					},
					error: function (log) {
						console.log(log.message);
					}
				});
			}
			
			function fillItemTable(dataSet)
			{
				$('#itemHistoryDisplay').DataTable( {
					data: dataSet,
					dom: 'Bfrtip',
					buttons: [
						'pdf'
					],
					destroy: true,
					columns: [
						{ title: "Sr. no." },
						{ title: "ITEM DESCRIPTION" },
						{ title: "DATE" },
						{ title: "TRANSACTION" },
						{ title: "Invoice" },
						{ title: "ADDITION" },
						{ title: "SUBTRACTION" },
						{ title: "NET QTY" },
					]
				});
			}
    	});
	</script>

</html>
