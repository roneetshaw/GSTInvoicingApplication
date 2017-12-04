<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Sales Billing</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<?php include 'csslibrary.php';?>
	<?php include 'jslibrary.php';?>
	
	<style>
	
		table.dataTable thead th { font-size: 15px; color: black;}
		table.dataTable tbody tr { cursor:pointer;}
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
										<h4 class="title">Sales Invoices</h4>
										<p class="category">*All Sales history</p>
									</div>
									<div class="col-md-3" style="padding-left:37px;">
										<input type="button" value="+New Sales Invoice" id="btnAddSales" >
									</div>
								</div>
                            </div>
                            <div class="content">
                                <div class="row" style="margin:20px;">
									<table id="invoiceGrandDisplay" style="text-align:center;" class="table table-condensed table-hover" width="100%"></table>
								</div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
	<div class="modal fade" id="addNewSalesInvoice" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Add Sale Invoice</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<label for="usr">Select a Customer</label>
						<input id="customerName" placeholder="Type customer name" style="width:100%;text-align:left;" type="text"></input>
					</div>
				</div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" id="btnCreateSaleInvoice">Create Invoice</button>
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		  </div>
		  
		</div>
	</div>	  
		</div>
	</div>
</div>


</body>
	<script type="text/javascript">
    	$(document).ready(function(){
			var availableTags = [];
			initCustomerName();
			initInvoiceTable();
			function initCustomerName()
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 7},
					success: function (d) {
						dataRET=JSON.parse(d);
						var autocompleteOptions = {
							source: dataRET[1]
						};
						$('#customerName').autocomplete(autocompleteOptions);
						$(".ui-autocomplete").css("z-index", "2147483647");
						var render = $('#customerName').autocomplete('instance')._renderMenu;

						/* overrides the default method */
						$('#customerName').autocomplete('instance')._renderMenu = function(ul, items) {
						  /* adds your fixed item */
						  items.push({ label: 'New Customer', value: '' });
						  /* calls the default behavior again */
						  render.call(this, ul, items);
						};

					},
					error: function (log) {
						console.log(log);
					}
				});
			}
			
			$(document).on("click", "#ui-id-1 li", function(event) {
				if($(this).text().trim() == "New Customer")
				{
					$("#addItemModal").modal('show');
				}
			})
			$('#btnAddSales').on('click',function(){
				$("#addNewSalesInvoice").modal('show');
				$('#customerName').val('');
			})
			$('#btnCreateSaleInvoice').on('click',function(){
				if($('#customerName').val().length> 0)
				{
					$("#addNewSalesInvoice").modal('hide');
					$.ajax({ 
						url: 'webmethods.php',
						type: 'POST',
						data: {type: 8, customerName: $("#customerName").val()},
						success: function (d) {
							d=d.split(',');
							if(d[0] == "1")
							{
								window.location.href = "/gst/salesinvoice.php?action=new&cust_id="+d[1]+"&name="+$('#customerName').val().trim()+"&invId="+d[2];
							}
						},
						error: function (log) {
							console.log(log);
						}
					});
				}
				else
					alert("Select a customer")
			})
			$( function() {
				$( "#itemBillDate" ).datepicker();
			});
			
			function initInvoiceTable()
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 13 },
					success: function (data1) {
									var arr = JSON.parse(data1);
									fillInvoiceTable(arr);
					},
					error: function (log) {
									console.log(log.message);
					}
				});
			}
			
			function fillInvoiceTable(dataSet)
			{
				$('#invoiceGrandDisplay').DataTable( {
					data: dataSet,
					dom: 'Bfrtip',
					buttons: [
						'pdf'
					],
					destroy: true,
					columns: [
						{ title: "DATE" },
						{ title: "INVOICE NO." },
						{ title: "CUSTOMER" },
						{ title: "GSTIN" },
						{ title: "TAXABLE AMOUNT" },
						{ title: "TAX" },
						{ title: "TOTAL AMOUNT" },
						{ title: "TYPE" }					
					]
				});
			}
    	});
	</script>

</html>
