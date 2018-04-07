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
	
		table.dataTable thead th { font-size: 15px; color: black;text-align: center; }
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
										<h4 class="title">Items</h4>
										<p class="category">*All Items</p>
									</div>
									<div class="col-md-3" style="padding-left:37px;">
										<input type="button" value="Add Item" id="btnItemAdd" >
									</div>
								</div>
                                
                            </div>
                            <div class="content">
                                <div class="row" style="margin:20px;">
									<table id="itemDisplay" class="table table-condensed table-hover" width="100%"></table>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
				<input type="hidden" class="form-control" value = "-99" id="itemHiddensave">
            </div>
        </div>
    </div>
	<div class="modal fade" id="addItemModal" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-sm-4">
						<h4 class="modal-title">Add Item</h4>
					</div>
					<div class="col-sm-6" style="text-align:center">
						<button type="button" class="btn btn-default" id="btnItemSave">Save</button>
					</div>
					<div class="col-sm-2">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
				</div>
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
								<li><a value="Pieces">Pieces</a></li>
								<li><a value="Packs">Packs</a></li>
								<li><a value="Pairs">Pairs</a></li>
								<li><a value="Rolls">Rolls</a></li>
								<li><a value="Set">Set</a></li>
								<li><a value="Boxes">Boxes</a></li>																
								<li><a value="Dorzen">Dorzen</a></li>																
								<li><a value="Others">Others</a></li>																
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
				$("#addItemModal input").val("");
			}
			function initTable()
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 5 },
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
				$('#itemDisplay').DataTable( {
					data: dataSet,
					dom: 'Bfrtip',
					buttons: [
						'pdf'
					],
					destroy: true,
					"aoColumns": [
						{"sTitle": "Sr. no." },
						{"sTitle": "ITEM DESCRIPTION"},
						{"sTitle": "HSN/SAC"},
						{"sTitle": "PURCHASE PRICE (₹)"},
						{"sTitle": "SELLING PRICE (₹)"},
						{"sTitle": "GST (%)"},
						{"sTitle": "DISCOUNT"},
						{"bSortable": true,"sType": "duration","sTitle": "QUANTITY"}
						
					]
				});
			}
			
			jQuery.extend( jQuery.fn.dataTableExt.oSort, {
			"duration-pre": function ( a ) {
				if(a != null)
				{
					var ukDatea = a.split(' ');
					return ((ukDatea[0]).trim())*1;
				}
			},

			"duration-asc": function ( a, b ) {
				return ((a < b) ? -1 : ((a > b) ? 1 : 0));
			},

			"duration-desc": function ( a, b ) {
				return ((a < b) ? 1 : ((a > b) ? -1 : 0));
			}
			});

			function saveIteminDB()
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 4, Description: $("#addItemModal input:eq(0)").val(),ItemType: $("#addItemModal button:eq(2)").text(),HSN: $("#addItemModal input:eq(1)").val(),ITEMCODE: $("#addItemModal input:eq(2)").val(),UNIT: $("#addItemModal button:eq(3)").text(),TAXRATE: $("#addItemModal button:eq(4)").text(), DISCOUNT: $("#addItemModal input:eq(3)").val(),CESSAMOUNT: $("#addItemModal input:eq(4)").val(),PURCHASEPRICE: $("#addItemModal input:eq(5)").val(),SELLINGPRICE:$("#addItemModal input:eq(6)").val(), query_type: $("#itemHiddensave").val() },
					success: function (d) {
						initTable();
						if(d == "1")
							$("#addItemModal").modal('hide');
					},
					error: function (log) {
						console.log(log);
					}
				});
			}
			$("#btnItemSave").on('click',function(){
				if($("#itemDesp").val().length > 0)
				{
					saveIteminDB();
				}
				else
					alert("Please add Vendor Name");
			})
			$("#btnItemAdd").on('click',function(){
				clearFields();
				$("#itemType button").html('Item Type<span class="caret"></span>');
				$("#itemUnit button").html('Unit<span class="caret"></span>');
				$("#itemTaxRate button").html('Tax Rate<span class="caret"></span>');
				$("#addItemModal").modal('show');
			})
    	});
	</script>

</html>
