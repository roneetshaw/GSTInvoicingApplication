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
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	
	<style>
	
		table.dataTable thead th { font-size: 15px; color: black;}
		a { cursor: pointer; }
		tr td { text-align: center; }
		.scrollable-menu {
    height: auto;
    max-height: 200px;
    overflow-x: hidden;
}
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
										<h4 class="title">Monthly Report</h4>
										<p class="category"></p>
									</div>
								</div>
                                
                            </div>
                            <div class="content">
								<div class="row" style="margin:20px;">
									<div class="col-md-3">
										<input type="number" min="2017" class="form-control" placeholder="2017" id="salesYear">
									</div>
									<div class="col-md-2">
										<button type="button" id="btnDrawChart" class="btn" style="border-color: #2e6da4 ;background-color: #337ab7;color: white;">Result</button>
									</div>
								</div>
								<div class="row" style="margin:20px;">
									<div id="chart_div"></div> 
								</div>
                                <div class="row" style="margin:20px;">
									<div class="col-md-4">
										<label for="From">From: (DD/MM/YYYY)</label>
										<input type="text" class="form-control" placeholder="DD/MM/YYYY" id="fromDate">
									</div>
									<div class="col-md-4">
										<label for="To">To: (DD/MM/YYYY)</label>
										<input type="text" class="form-control" placeholder="DD/MM/YYYY" id="toDate">
									</div>
									<div class="col-md-4">
										<br/>
										<button type="button" id="btnGetResult" class="btn" style="border-color: #2e6da4 ;background-color: #337ab7;color: white;">Get Result</button>
									</div>
								</div>
                                <div class="row" style="margin:20px;">
									<table id="itemMonthlyPortfolioDisplay" class="table table-condensed table-hover" width="100%"></table>
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
		$( function() {
				$( "#fromDate" ).datepicker({ dateFormat: 'dd/mm/yy' });
				$( "#toDate" ).datepicker({ dateFormat: 'dd/mm/yy' });
				var d=new Date();
				$( "#fromDate" ).val(d.getDate()+"/"+(d.getMonth()+1)+"/"+d.getFullYear());
				$( "#toDate" ).val(d.getDate()+"/"+(d.getMonth()+1)+"/"+d.getFullYear());
				initTable();
				
		});
    	$(document).ready(function(){
			drawCh();
			$('#btnGetResult').on('click',function(){
				initTable();
			})
    	});
		function initTable()
		{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 23,fromDate: $('#fromDate').val().trim(), toDate: $('#toDate').val().trim() },
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
			$('#itemMonthlyPortfolioDisplay').DataTable( {
				data: dataSet,
				dom: 'Bfrtip',
				buttons: [
						'pdf'
					],
				destroy: true,
				columns: [
					{ title: "Sr. no." },
					{ title: "Invoice Type" },
					{ title: "No. of Transaction" },
					{ title: "Start Date" },
					{ title: "End Date" },
					{ title: "Taxable Amount (₹)" },
					{ title: "GST Amount (₹)" },
					{ title: "Net Amount (₹)" }
				]
			});
		}
		function drawCh()
		{
			google.charts.load('current', {'packages':['bar']});
			google.charts.setOnLoadCallback(drawChart);
		}

		function drawChart() {
			var year = $('#salesYear').val().trim();
			if(year == "")
			{
				year = (new Date()).getFullYear();
				$('#salesYear').val(year);
			}
			var data;
			var title="Sales and Purchase : "+year;
			$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 24,Year: year},
					success: function (data1) {
						var arr = JSON.parse(data1);
						console.log(arr)
						data = google.visualization.arrayToDataTable(arr);		
						var options = {
							chart: {
								title: 'Yearly Performance',
								subtitle: title,
							  },
							bars: 'vertical',
							vAxis: {baseline: 0,format: 'decimal'},
							height: 400,
							colors: ['#7570b3', '#d95f02']
						};

						var chart = new google.charts.Bar(document.getElementById('chart_div'));
						chart.draw(data, google.charts.Bar.convertOptions(options));
						var btns = document.getElementById('btn-group');
					},
					error: function (log) {
						console.log(log.message);
					}
			});
		}
		
		$('#btnDrawChart').on('click',function(){
			drawCh()
		})
	</script>

</html>
