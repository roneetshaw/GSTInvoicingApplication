<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Purchase Billing</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<?php include 'csslibrary.php';?>
	<?php include 'jslibrary.php';?>
	
	<style>
	
		table.dataTable thead th { font-size: 15px; color: black;text-align: center;}
		table.dataTable tbody tr { cursor:pointer;}
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
										<h4 class="title">Purchase Invoices</h4>
										<p class="category">*All Purchase history</p>
									</div>
									<div class="col-md-3" style="padding-left:37px;">
										<input type="button" value="+New Purchase Invoice" id="btnAddPurchase" >
									</div>
								</div>
                            </div>
                            <div class="content">
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
										<button type="button" id="btnApplyFilter" class="btn" style="border-color: #2e6da4 ;background-color: #337ab7;color: white;">Filter</button>
									</div>
								</div>
                                <div class="row" style="margin:20px;">
									<table id="invoicePurchaseGrandDisplay" style="text-align:center;" class="table table-condensed table-hover" width="100%"></table>
								</div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
	<div class="modal fade" id="addNewPurchaseInvoice" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Add Purchase Invoice</h4>
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
			  <button type="button" class="btn btn-default" id="btnCreatePurchaseInvoice">Create Invoice</button>
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		  </div>
		  
		</div>
	</div>
	<div class="modal fade" id="addCustomerModal" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  
				<div class="row">
					<div class="col-sm-4">
						<h4 class="modal-title">Add Customer</h4>
					</div>
					<div class="col-sm-6" style="text-align:center">
						<button type="button" class="btn btn-default" id="btnCustSave">Save</button>
					</div>
					<div class="col-sm-2">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<label for="usr">Customer Name(*required)</label>
						<input type="text" value="" class="form-control" id="custName">
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-12">
						<label for="usr">GST Number</label>
						<input type="text" value="" class="form-control" id="custGST">
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-6">
						<label for="usr">City</label>
						<input type="text" class="form-control" id="custCity">
					</div>
					<div class="col-sm-6">
						<label for="usr">State</label>
						<div class="dropdown" id="drpState">
							<button class="btn btn-default dropdown-toggle" id="custDrpstate" style="width:250px" type="button" data-toggle="dropdown">Select State
							<span class="caret"></span></button>
						    <ul class="dropdown-menu" style="width:250px;height: 200px;overflow:auto">
								<li><a value="Tamil Nadu">Tamil Nadu</a></li>
								<li><a value="West Bengal">West Bengal</a></li>
								<li><a value="Orissa">Orissa</a></li>
								<li><a value="Delhi">Delhi</a></li>
								<li><a value="Karnataka">Karnataka</a></li>
								<li><a value="ANDAMANANDNICOBARISLANDS">Andaman and Nicobar Islands</a></li>
								<li><a value="Andhra Pradesh">Andhra Pradesh</a></li>
								<li><a value="ARUNACHALPRADESH">Arunachal Pradesh</a></li>
								<li><a value="Assam">Assam</a></li>
								<li><a value="Bihar">Bihar</a></li>
								<li><a value="Chandigarh">Chandigarh</a></li>
								<li><a value="Chhattisgarh">Chhattisgarh</a></li>
								<li><a value="Dadra Nagar Haveli">Dadra Nagar Haveli</a></li>
								<li><a value="Daman and Diu">Daman and Diu</a></li>					
								<li><a value="Goa">Goa</a></li>
								<li><a value="Gujarat">Gujarat</a></li>
								<li><a value="Haryana">Haryana</a></li>
								<li><a value="Himachal Pradesh">Himachal Pradesh</a></li>
								<li><a value="Jammu and Kashmir">Jammu and Kashmir</a></li>
								<li><a value="Jharkhand">Jharkhand</a></li>
								
								<li><a value="Kerala">Kerala</a></li>
								<li><a value="Lakshadweep">Lakshadweep</a></li>
								<li><a value="Madhya Pradesh">Madhya Pradesh</a></li>
								<li><a value="Maharashtra">Maharashtra</a></li>
								<li><a value="Manipur">Manipur</a></li>
								<li><a value="Meghalaya">Meghalaya</a></li>
								<li><a value="Mizoram">Mizoram</a></li>
								<li><a value="Pondicherry">Pondicherry</a></li>
								<li><a value="Punjab">Punjab</a></li>
								<li><a value="Rajasthan">Rajasthan</a></li>
								<li><a value="Sikkim">Sikkim</a></li>
								<li><a value="OTHERTERRITORY">OTHERTERRITORY</a></li>
						    </ul>
						</div>
					</div>
					
				</div>
				<br/>
				<div class="row">				
					<div class="col-sm-6">
						<label for="usr">Contact person</label>
						<input type="text" value=""  class="form-control" id="custContactName">
					</div>
					<div class="col-sm-6">
						<label for="usr">Mobile No.</label>
						<input type="text" value=""  class="form-control" id="custMobileNumber">
					</div>										
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-6">
						<label for="usr">PAN</label>
						<input type="text" value=""  class="form-control" id="custPAN">
					</div>
					<div class="col-sm-6">
						<label for="usr">Pin code</label>
						<input type="text" value=""  class="form-control" id="custPin">
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-12">
						<label for="usr">Address</label>
						<input type="text" value=""  class="form-control" id="custAddress">
					</div>
				</div>
			</div>
			<div class="modal-footer">
			  
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		  </div>
		  
		</div>
	</div>
</div>


</body>
	<script type="text/javascript">
		$( function() {
			$( "#fromDate" ).datepicker({ dateFormat: 'dd/mm/yy' });
			$( "#toDate" ).datepicker({ dateFormat: 'dd/mm/yy' });
		});
    	$(document).ready(function(){
			var availableTags = [];
			initCustomerName();
			initInvoiceTable("1");
			function initCustomerName()
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 7},
					success: function (d) {
						dataRET=JSON.parse(d);
						var autocompleteOptions = dataRET[1];
						$('#customerName').autocomplete({
							source: autocompleteOptions,
							response: function(event, ui){
								ui.content.push({id:'New Customer', label:'New Customer', value:''});
							},
							minLength: 0,
							autoFocus: true,
							open: function(event) {},
							close: function() {},
							focus: function(event,ui) {

							},
							select: function (e, ui) {

								if(ui.item.label.trim() == "New Customer")
								{
									$("#addCustomerModal").modal('show');
									//tempRow=$(emptyColumn).find('td:nth-child(2) input');
								}
							}
						});
						$(".ui-autocomplete").css("z-index", "2147483647");

					},
					error: function (log) {
						console.log(log);
					}
				});
			}
			
			$('#btnAddPurchase').on('click',function(){
				$("#addNewPurchaseInvoice").modal('show');
				$('#customerName').val('');
			})
			$("#btnCustSave").on('click',function(){
				if($("#custName").val().length > 0)
				{
					saveCustomerinDB();
				}
				else
					alert("Please add Vendor Name");
			})
			function saveCustomerinDB()
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 1, vendorName: $("#custName").val(),custGST: $("#custGST").val(),custCity: $("#custCity").val(),drpState: $("#drpState button").text(),custContactName: $("#custContactName").val(),custMobileNumber: $("#custMobileNumber").val(), custPAN: $("#custPAN").val(),custPin: $("#custPin").val(),custAddress: $("#custAddress").val(), query_type: "-99" },
					success: function (d) {
						console.log(d);
						if(d == "1")
						{
							$("#addCustomerModal").modal('hide');
							alert("Customer Saved");
							initCustomerName();
						}
					},
					error: function (log) {
						console.log(log);
					}
				});
			}
			$('#btnCreatePurchaseInvoice').on('click',function(){
				if($('#customerName').val().length> 0)
				{
					$("#addNewPurchaseInvoice").modal('hide');
					$.ajax({ 
						url: 'webmethods.php',
						type: 'POST',
						data: {type: 17, customerName: $("#customerName").val()},
						success: function (d) {
							d=d.split(',');
							if(d[0] == "1")
							{
								window.location.href = "/gst/purchaseinvoice.php?action=new&cust_id="+d[1]+"&name="+$('#customerName').val().trim()+"&invId="+d[2];
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
			
			function initInvoiceTable(mode)
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 16, mode: mode, fromDate: $('#fromDate').val().trim(), toDate: $('#toDate').val().trim()},
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
				$('#invoicePurchaseGrandDisplay').DataTable( {
					data: dataSet,
					dom: 'Bfrtip',
					buttons: [
						'pdf'
					],
					destroy: true,
					"aoColumns": [
						{"sType": "date-uk","sTitle": "DATE" },
						{"sTitle": "INVOICE NO"},
						{"sTitle": "CUSTOMER"},
						{"sTitle": "GSTIN"},
						{"sTitle": "TAXABLE AMOUNT"},
						{"sTitle": "TAX"},
						{"sTitle": "TOTAL AMOUNT"},
						{"sTitle": "TYPE"}
						
					]
				});
			}
			jQuery.extend( jQuery.fn.dataTableExt.oSort, {
			"date-uk-pre": function ( a ) {
				if(a != null)
				{
					var ukDatea = a.split('/');
					return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
				}
			},

			"date-uk-asc": function ( a, b ) {
				return ((a < b) ? -1 : ((a > b) ? 1 : 0));
			},

			"date-uk-desc": function ( a, b ) {
				return ((a < b) ? 1 : ((a > b) ? -1 : 0));
			}
			});
			$('#btnApplyFilter').on('click',function(){
				initInvoiceTable("2");
			})
    	});
	</script>

</html>
