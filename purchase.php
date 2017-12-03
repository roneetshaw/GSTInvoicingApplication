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
                                <h4 class="title">Item Lookup</h4>
                                <p class="category">*All Items history</p>
                            </div>
                            <div class="content">
                                <div class="row" style="margin:20px;">
									<table id="itemDisplay" class="table table-condensed table-hover" width="100%"></table>
								</div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
	<div class="modal fade" id="addItemModal" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Add Item</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<label for="usr">Item Description (*required)</label>
						<input type="text" class="form-control" id="itemDesp">
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-6">
						<label for="usr">Item Type (*required)</label>
						<div class="dropdown" id="itemType">
							<button class="btn btn-default dropdown-toggle" style="width:250px" type="button" data-toggle="dropdown">Item Type 
							<span class="caret"></span></button>
						    <ul class="dropdown-menu" style="width:250px">
								<li><a href="#">Goods</a></li>
								<li><a href="#">Services</a></li>
						    </ul>
						</div>
					</div>
					<div class="col-sm-6">
						<label for="usr">HSN/SAC code (*required)</label>
						<input type="text" class="form-control" id="itemHSNCode">
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-6">
						<label for="usr">Item/SKU code</label>
						<input type="text" class="form-control" id="itemSKUCode">
					</div>
					<div class="col-sm-6">
						<label for="usr">Unit</label>
						<div class="dropdown" id="itemUnit">
							<button class="btn btn-default dropdown-toggle" style="width:250px" type="button" data-toggle="dropdown">Unit
							<span class="caret"></span></button>
						    <ul class="dropdown-menu" style="width:250px">
								<li><a href="#">Pieces</a></li>
								<li><a href="#">Packs</a></li>
								<li><a href="#">Pairs</a></li>
								<li><a href="#">Rolls</a></li>
								<li><a href="#">Set</a></li>
								<li><a href="#">Boxes</a></li>																
								<li><a href="#">Dorzen</a></li>																
								<li><a href="#">Others</a></li>																
						    </ul>
						</div>
					</div>
					
				</div>
				<br/>
				<div class="row">				
					<div class="col-sm-6">
						<label for="usr">Tax Rate</label>
						<div class="dropdown" id="itemTaxRate">
							<button class="btn btn-default dropdown-toggle" style="width:250px" type="button" data-toggle="dropdown">Tax Rate
							<span class="caret"></span></button>
						    <ul class="dropdown-menu" style="width:250px">
								<li><a href="#">0.25%</a></li>
								<li><a href="#">12%</a></li>
								<li><a href="#">18%</a></li>
								<li><a href="#">28%</a></li>
								<li><a href="#">3%</a></li>
								<li><a href="#">5%</a></li>																
						    </ul>
						</div>
					</div>
					<div class="col-sm-6">
						<label for="usr">Discount</label>
						<input type="text" class="form-control" id="itemDiscount">
					</div>										
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-6">
						<label for="usr">Cess Amount</label>
						<input type="text" class="form-control" id="itemCess">
					</div>				
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-6">
						<label for="usr">Purchase Price</label>
						<input type="text" class="form-control" id="itemPurchase">
					</div>
					
					<div class="col-sm-6">
						<label for="usr">Selling price</label>
						<input type="text" class="form-control" id="itemSelling">
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
	<div class="modal fade" id="changeItemModal" role="dialog">
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
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myLargeModalLabel" aria-hidden="true"  id="onload">

    <div class="modal-dialog">
		<!-- Modal content-->
        <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title" align="center" >Enter Year</h4>
			</div>
			<form action="/predict/settings.php">
				<div class="modal-body" align="center">
					<input class="form-control" maxlength="4" onkeypress="return isNumber(event)" style="text-align:center;font-size: 20px;" placeholder="2014" id="onloadYear" name="onloadYear" style="width: 100px;" type="text">
					<p id="vldYearErr" style="color: red; display: none;">Please enter a valid Year</p>
				</div>
				<div class="modal-footer">
					<button type="submit"  style="display: none;" id="btnGoToSettings" class="btn btn-default" >Settings</button>
					<button type="button"  id="btnGlobalYearSubmit" class="btn btn-default" >Submit</button>
					
				</div>
			</form>
        </div>
    </div>
</div>

</body>
	<script type="text/javascript">
    	$(document).ready(function(){
			$( function() {
				$( "#itemBillDate" ).datepicker();
			});
			var dataSet = [
				[ "Tiger Nixon", "System Architect", "Edinburgh", "5421", "2011/04/25", "$320,800" ],
				[ "Garrett Winters", "Accountant", "Tokyo", "8422", "2011/07/25", "$170,750" ],
				[ "Ashton Cox", "Junior Technical Author", "San Francisco", "1562", "2009/01/12", "$86,000" ],
				[ "Cedric Kelly", "Senior Javascript Developer", "Edinburgh", "6224", "2012/03/29", "$433,060" ],
				[ "Airi Satou", "Accountant", "Tokyo", "5407", "2008/11/28", "$162,700" ],
				[ "Brielle Williamson", "Integration Specialist", "New York", "4804", "2012/12/02", "$372,000" ],
				[ "Herrod Chandler", "Sales Assistant", "San Francisco", "9608", "2012/08/06", "$137,500" ],
				[ "Rhona Davidson", "Integration Specialist", "Tokyo", "6200", "2010/10/14", "$327,900" ],
				[ "Colleen Hurst", "Javascript Developer", "San Francisco", "2360", "2009/09/15", "$205,500" ],
				[ "Sonya Frost", "Software Engineer", "Edinburgh", "1667", "2008/12/13", "$103,600" ],
				[ "Jena Gaines", "Office Manager", "London", "3814", "2008/12/19", "$90,560" ],
				[ "Quinn Flynn", "Support Lead", "Edinburgh", "9497", "2013/03/03", "$342,000" ],
				[ "Charde Marshall", "Regional Director", "San Francisco", "6741", "2008/10/16", "$470,600" ]
			];
			$('#itemDisplay').DataTable( {
				data: dataSet,
				dom: 'Bfrtip',
				buttons: [
					'pdf'
				],
				destroy: true,
				columns: [
					{ title: "Name" },
					{ title: "Position" },
					{ title: "Office" },
					{ title: "Extn." },
					{ title: "Start date" },
					{ title: "Salary" }
				]
			} );
    	});
	</script>

</html>
