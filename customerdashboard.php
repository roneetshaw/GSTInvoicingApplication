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
	
		table.dataTable thead th { font-size: 15px; color: black;}
		a { cursor: pointer; }
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
									<div class="col-md-8">
										<h4 class="title">Customer Dashboard</h4>
										<p class="category">*All Customer</p>
									</div>
									<div class="col-md-4">
										<input type="button" value="Add Customer" id="btnCustomerAdd">
										<input type="button" value="Edit Customer" id="btnItemChange"  data-toggle="modal" data-target="#editCustomerModal">
									</div>
								</div>
                                
                            </div>
                            <div class="content">
                                <div class="row" style="margin:20px;">
									<table id="custDisplay" class="table table-condensed table-hover" width="100%"></table>
								</div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
		<input type="hidden" class="form-control" value = "-99" id="custHiddensave">
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
	<div class="modal fade" id="editCustomerModal" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Change Item</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-3">
						<label for="usr" style="margin-top:10px;">Item Name:</label>
					</div>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="itemDespName" placeholder="Type an Item">
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-3">
						<label for="usr" style="margin-top:10px;">Bill Date:</label>
					</div>
					<div class="col-sm-9">
						<input class="form-control" id="itemBillDate" name="date" placeholder="MM/DD/YYYY" type="text"/>
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-12">
						<input type="text" class="form-control" id="itemChangeValue" style="text-align:center;">
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-12" style="text-align:center;">
						<button type="button" class="btn btn-default" id="btnItemAdd" style="width:80px;font-weight:bold; color: black;" >Add</button>
						<button type="button" class="btn btn-default" id="btnItemMinus" style="width:80px;font-weight:bold; color: black;" >Minus</button>
						<button type="button" class="btn btn-default" id="btnItemEdit" style="width:80px;font-weight:bold; color: black;" >Edit</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		  </div>
		  
		</div>
	</div>
</div>
</body>
	<script type="text/javascript">
		
    	$(document).ready(function(){
			initTable();
			function clearFields()
			{
				$("#addCustomerModal input").val("");
			}
			function initTable()
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 2 },
					success: function (data1) {
									var arr = JSON.parse(data1);
									fillCustomerTable(arr);
									console.log(data1);
					},
					error: function (log) {
									console.log(log.message);
					}
				});
			}
			
			function fillCustomerTable(dataSet)
			{
				$('#custDisplay').DataTable( {
				data: dataSet,
				dom: 'Bfrtip',
				buttons: [
					'pdf'
				],
				destroy: true,
				columns: [
					{ title: "Sr. no" },
					{ title: "Vendor Name" },
					{ title: "GSTIN" },
					{ title: "STATE" },
					{ title: "MOBILE NUMBER" },
				]
			} );
			}
			function saveCustomerinDB()
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 1, vendorName: $("#custName").val(),custGST: $("#custGST").val(),custCity: $("#custCity").val(),drpState: $("#drpState button").text(),custContactName: $("#custContactName").val(),custMobileNumber: $("#custMobileNumber").val(), custPAN: $("#custPAN").val(),custPin: $("#custPin").val(),custAddress: $("#custAddress").val(), query_type: $("#custHiddensave").val() },
					success: function (d) {
						console.log(d);
						initTable();
						if(d == "1")
							$("#addCustomerModal").modal('hide');
					},
					error: function (log) {
						console.log(log);
					}
				});
			}
			$("#btnCustSave").on('click',function(){
				if($("#custName").val().length > 0)
				{
					saveCustomerinDB();
				}
				else
					alert("Please add Vendor Name");
			})
			$( function() {
				$( "#itemBillDate" ).datepicker();
			});
			$("#btnCustomerAdd").on('click',function(){
				clearFields();
				$("#custDrpstate").html('Select State<span class="caret"></span>');
				$("#addCustomerModal").modal('show');
			})
    	});
	</script>

</html>
