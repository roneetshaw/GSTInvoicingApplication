
<html>
	<head>
		<meta charset="utf-8">
		<title>Invoice</title>
		<link rel="license" href="https://www.opensource.org/licenses/mit-license/">
		<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
				<link rel="stylesheet" href="invoice.css?v=3.1">
		<?php include 'jslibrary.php';?>
		<script src="purchaseinvoice.js?v=1.3"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<style>
			input,textarea:disabled{background-color:white;}
			@media print {
				html, body {
					height: auto;    
				}
			}
			
		</style>
		<script type="text/javascript">

			var i=0;
			$( function() {
				$( "#itemBillDate" ).datepicker({ dateFormat: 'dd/mm/yy' });
			});
			$( window ).load(function() {
				
			});
			$(document).ready(function() {
				var url = new URL(window.location.href);
				var invId = url.searchParams.get("invId");
				var action = url.searchParams.get("action");
				if(action == "new")
				{
					var id = url.searchParams.get("cust_id");
					var name = url.searchParams.get("name");
					$("#custName").html(name)
					$("#invoiceId").val(invId);
					$('#invoiceNote').removeAttr("disabled")
					$('#invoiceNote').css("background-color", "white");
					loadAddress(id)
				}
				else if(action == "edit")
				{
					$('#invoiceNote').attr("disabled", "disabled");
					$('#invoiceNote').css("background-color", "#e8e6e6");
					loadInvoiceFromDB(invId);
				}
				$('#stateToShip').on('change', function() {
					
					$("#itemList tbody tr td:nth-child(4)").each(function()
					{
							calRow($(this).find('input'));
					})
				})
				$('#itemList tbody tr').on('click','a',function(){
					alert($('#itemList tbody tr').length);
				});
				
				function loadInvoiceFromDB(invId)
				{
					initHeader(invId)
					fillInvoiceTableRows();
				}
				function loadAddress(cust_id)
				{
					$.ajax({ 
						url: 'webmethods.php',
						type: 'POST',
						data: {type: 25, id: cust_id},
						success: function (data1) {
							var arr = JSON.parse(data1);
							console.log(arr);
							$('#invoiceAddress').text(arr.Address);
							$('#custGST').text('GST: '+arr.GSTNUMBER);
						},
						error: function (log) {
							console.log(log.message);
						}
					});
				}
				function DisableInvoice(state)
				{
					$('#invoiceNote').prop('disabled', state);
					if (state)
						$('#invoiceNote').css("background-color", "#e8e6e6");
					else
						$('#invoiceNote').css("background-color", "white");
					$('#btnInvoiceSave').prop('disabled', state);
					$('#itemBillDate').prop('disabled', state);
					$('#stateToShip').prop('disabled', state);
					$('#itemList td input').prop('disabled', state);
					$('#invoiceAddress').prop('disabled', state);
					$('#purchaseNo').prop('disabled', state);
					if(state)
					{
						$('.add').click(function () {return false;});
						$('.cut').click(function () {return false;});
					}
					else
					{
						$('.add').unbind('click');
						$('.cut').unbind('click');
					}
				}
				function initHeader(invId)
				{
					$.ajax({ 
						url: 'webmethods.php',
						type: 'POST',
						data: {type: 18, invId: invId},
						success: function (data1) {
							var arr = JSON.parse(data1);
							console.log(arr)
							if (arr !=null)
							{
								$('#itemBillDate').val(arr.Date);
								$('#invoiceNote').val(arr.note);
								$('#invoiceId').val(invId);
								$('#custGST').text('GST: '+arr.GST);
								$('#purchaseNo').val(arr.PurchaseNo);
								$('#stateToShip').val(arr.PlaceOfSupply);
								$('#custName').text(arr.custName);
								$('#invoiceAddress').val(arr.InvoiceAddress);
								$('#taxableTotal').text(arr.TotalTaxable);
								$('#grandTotalCGST').text(arr.TOTALCGST);
								$('#grandTotalSGST').text(arr.TOTALSGST);
								$('#grandTotalIGST').text(arr.TOTALIGST);
								$('#grandTotal').text(arr.GrandTotal);
							}
						},
						error: function (log) {
							console.log(log.message);
						}
					});
				}
				function fillInvoiceTableRows()
				{
					$.ajax({ 
						url: 'webmethods.php',
						type: 'POST',
						data: {type: 19, invId: invId},
						success: function (data1) {
							var arr = JSON.parse(data1);
							console.log(arr);
							generateItemRows(arr);
						},
						error: function (log) {
							console.log(log.message);
						}
					});
				}
				
				function generateItemRows(arr)
				{
					var i=0;
					$('#itemList tbody').empty();
					for(i=0 ;i<arr[0].length;  i++)
					{var emptyColumn = document.createElement('tr');
						emptyColumn.innerHTML = '<td style="text-align:right;"><a class="cut">-</a><span >'+(i+1)+'</span></td>' +
						'<td><input class="itemDespText" placeholder="Type an Item" value="'+arr[12][i]+'" style="width:100%;text-align:left;" type="search" ></input></td>' +
						'<td>'+arr[13][i]+'</td>' +
						'<td><input  style="width:100%;text-align:right;" type="text"value="'+arr[7][i]+'" onchange="rateChange($(this))"></input></td>' +
						'<td><input style="width:100%;text-align:right;" type="number" min="0" value="'+arr[8][i]+'" onfocus="this.oldvalue = this.value;" onchange="qtyChange($(this),this);this.oldvalue = this.value;"></input></td>'+
						'<td style="text-align:center;"><span >'+arr[14][i]+'</span></td>' +
						'<td><input style="width:100%;text-align:right;" type="text" value="'+arr[5][i]+'" onchange="disChange($(this))"></td>' +
						'<td>'+arr[4][i]+'</td>' +
						'<td><input style="width:100%;text-align:right;" type="text" value="'+arr[6][i]+'%" onchange="gstChange($(this))"></td>'+
						'<td>'+arr[0][i]+'</td>' +
						'<td>'+arr[1][i]+'</td>' +
						'<td>'+arr[2][i]+'</td>' +
						'<td>'+arr[3][i]+'</td>' +
						'<td style="display:none;">'+arr[11][i]+'</td>'+
						'<td style="display:none;">'+arr[9][i]+'</td>'+
						'<td style="display:none;">'+arr[8][i]+'</td>';
						$('#itemList tbody').append($(emptyColumn));
					}
					x=(i+1);
					DisableInvoice(true);
				}
				
				function initTable()
				{
					$.ajax({ 
						url: 'webmethods.php',
						type: 'POST',
						data: {type: 7 },
						success: function (data1) {
										var arr = JSON.parse(data1);
										fillItemTable(arr);
						},
						error: function (log) {
										console.log(log.message);
						}
					});
				}
				$("#btnInvoiceSave").on('click',function(){
					if($('#invoiceAddress').val().trim().length > 0)
					{
						if($('#itemBillDate').val().trim().length > 0)
						{
							$('#grandTotal').click();
							saveInvoiceTransaction();	
						}
						else
						{
							alert("Bill Date required");
						}
					}
					else
					{
						alert("Customer address required");
					}
				});
				
				$("#btnInvoiceEdit").on('click',function(){
					
					DisableInvoice(false);
				});
				
				function saveInvoiceTransaction()
				{
					
					var JSONObject = JSON.stringify(tableJSON());
					console.log(JSONObject)
					$.ajax({ 
						url: 'webmethods.php',
						type: 'POST',
						data: {type: 20, invId: invId, JSONtableObject: JSONObject, action: action},
						success: function (d) {
							if(d == "1")
							{
								saveInvoiceDetails();
							}
						},
						error: function (log) {
							console.log(log);
						}
					});
				}
				function saveInvoiceDetails()
				{
					$.ajax({ 
						url: 'webmethods.php',
						type: 'POST',
						data: {type: 21,action: action, invId: invId, purchaseNo: $('#purchaseNo').val().trim() , stateToShip:$('#stateToShip').val().trim(), itemBillDate: $('#itemBillDate').val().trim(), invoiceAddress: $('#invoiceAddress').val().trim(), taxableTotal: $('#taxableTotal').text().trim(),grandTotalCGST: $('#grandTotalCGST').text().trim(), grandTotalSGST: $('#grandTotalSGST').text().trim(), grandTotalIGST: $('#grandTotalIGST').text().trim(), grandTotal: $('#grandTotal').text().trim(),note: $('#invoiceNote').val().trim() },
						success: function (d) {
							if(d == "1")
							{
								alert("Invoice saved");
								DisableInvoice(true);
								loadInvoiceFromDB(invId);
							}
						},
						error: function (log) {
							console.log(log);
						}
					});
				}
				function tableJSON()
				{
					var elementTable = $('#itemList tbody tr');
					var jObject = [];
					elementTable.each(function(){
						item = {}
						item ["sr"] = $(this).find('td:nth-child(1)').find('span').text().trim();
						item ["itemID"] = $(this).find('td:nth-child(15)').text().trim();
						item ["HSN"] = $(this).find('td:nth-child(3)').text().trim();
						item ["rate"] = $(this).find('td:nth-child(4)').find('input').val().trim();
						item ["qty"] = $(this).find('td:nth-child(5)').find('input').val().trim();
						item ["unit"] = $(this).find('td:nth-child(6)').text().trim();
						item ["dis"] = $(this).find('td:nth-child(7)').find('input').val().trim();
						item ["taxableVal"] = $(this).find('td:nth-child(8)').text().trim();
						item ["gstrate"] = $(this).find('td:nth-child(9)').find('input').val().trim().substring(0,2);
						item ["cgst"] = $(this).find('td:nth-child(10)').text().trim();
						item ["sgst"] = $(this).find('td:nth-child(11)').text().trim();
						item ["igst"] = $(this).find('td:nth-child(12)').text().trim();
						item ["itemtotal"] = $(this).find('td:nth-child(13)').text().trim();
						item ["qtyLeft"] = $(this).find('td:nth-child(14)').text().trim();
						jObject.push(item);
					});
					return jObject;
				}
				function saveIteminDB()
				{
					var desp = $("#addItemModal input:eq(0)").val();
					$.ajax({ 
						url: 'webmethods.php',
						type: 'POST',
						data: {type: 4, Description: $("#addItemModal input:eq(0)").val(),ItemType: $("#addItemModal button:eq(2)").text(),HSN: $("#addItemModal input:eq(1)").val(),ITEMCODE: $("#addItemModal input:eq(2)").val(),UNIT: $("#addItemModal button:eq(3)").text(),TAXRATE: $("#addItemModal button:eq(4)").text(), DISCOUNT: $("#addItemModal input:eq(3)").val(),CESSAMOUNT: $("#addItemModal input:eq(4)").val(),PURCHASEPRICE: $("#addItemModal input:eq(5)").val(),SELLINGPRICE:$("#addItemModal input:eq(6)").val(), query_type: "-99" },
						success: function (d) {
							if(d == "1")
							{
								alert("Item Saved");
								$("#addItemModal").modal('hide');
								$(tempRow).val(desp);
								fillItemDetails(desp,tempRow);
								initItemName();
							}
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
						alert("Please enter Item Description");
				})
			});
			
			
		</script>
		<style>
			@media print
			{    
				.no-print, .no-print *
				{
					display: none !important;
				}
			}
		</style>
	</head>
	<body >
		<input type="hidden" id="customerType" name="customerType" value="B2C">
		<div class="row no-print" style="text-align:center;">
						<div class="col-sm-3">
							<button type="button" class="btn btn-default" id="btnInvoiceSave">Save</button>
						</div>
						<div class="col-sm-3">
							<button type="button" class="btn btn-default" id="btnInvoiceEdit">Edit</button>
						</div>
						<div class="col-sm-3">
							<button type="button" onclick="window.history.go(-1); return false;" class="btn btn-default" id="btnInvoiceBack">Back</button>
						</div>
						<div class="col-sm-3">
							<button type="button" onclick="window.print(); return false;" class="btn btn-primary" id="btnInvoiceBack">Print</button>
						</div>
		</div>
		<header >
			<h1>Purchase Invoice</h1>
			<span><img alt="" src="assets/img/letter_head.png"><input type="file" accept="image/*"></span>
		</header>
		<p style="text-decoration: underline;"><b>Invoice Address</b></p>
		<article>
			
			<address>
				<p><span id="custName" >Some Company</span></p>
				<p><span id="custGST" ></span></p>
				<textarea rows="4" cols="40" id="invoiceAddress" placeholder="Type Vendor Address"></textarea>
			</address>
			<table class="meta">
				<tr>
					<th><span>Purchase Invoice #</span></th>
					<td><input id="purchaseNo" placeholder="Invoice #" type="text"/></td>
					<input id="invoiceId" name="invoiceId" type="hidden" >
				</tr>
				<tr>
					<th><span>Bill Date</span></th>
					<td><input id="itemBillDate" placeholder="MM/DD/YYYY" type="text"/></td>
				</tr>
				<tr>
					<th><span>Place of Purchase</span></th>
					<td>
						<select id="stateToShip">
							<option  value="Tamil Nadu">Tamil Nadu </option>
								<option  value="West Bengal" selected>West Bengal </option>
								<option  value="Orissa">Orissa </option>
								<option  value="Delhi">Delhi </option>
								<option  value="Karnataka">Karnataka </option>
								<option  value="ANDAMANANDNICOBARISLANDS">Andaman and Nicobar Islands </option>
								<option  value="Andhra Pradesh">Andhra Pradesh </option>
								<option  value="ARUNACHALPRADESH">Arunachal Pradesh </option>
								<option  value="Assam">Assam </option>
								<option  value="Bihar">Bihar </option>
								<option  value="Chandigarh">Chandigarh </option>
								<option  value="Chhattisgarh">Chhattisgarh </option>
								<option  value="Dadra Nagar Haveoption">Dadra Nagar Haveoption </option>
								<option  value="Daman and Diu">Daman and Diu </option>					
								<option  value="Goa">Goa </option>
								<option  value="Gujarat">Gujarat </option>
								<option  value="Haryana">Haryana </option>
								<option  value="Himachal Pradesh">Himachal Pradesh </option>
								<option  value="Jammu and Kashmir">Jammu and Kashmir </option>
								<option  value="Jharkhand">Jharkhand </option>
								
								<option  value="Kerala">Kerala </option>
								<option  value="Lakshadweep">Lakshadweep </option>
								<option  value="Madhya Pradesh">Madhya Pradesh </option>
								<option  value="Maharashtra">Maharashtra </option>
								<option  value="Manipur">Manipur </option>
								<option  value="Meghalaya">Meghalaya </option>
								<option  value="Mizoram">Mizoram </option>
								<option  value="Pondicherry">Pondicherry </option>
								<option  value="Punjab">Punjab </option>
								<option  value="Rajasthan">Rajasthan </option>
								<option  value="Sikkim">Sikkim </option>
								<option  value="OTHERTERRITORY">OTHERTERRITORY </option>
						</select>
					</td>
				</tr>
			</table>
			
			<table class="inventory" id="itemList">
				<thead>
					<tr>
						<th style="width:15px"><span >#</span></th>
						<th style="width:130px"><span >Item Description</span></th>
						<th style="width:30px"><span >HSN</span></th>
						<th style="width:25px"><span >Rate</span></th>
						<th style="width:35px"; ><span >Qty.</span></th>
						<th style="width:25px"><span >Unit</span></th>
						<th style="width:25px"><span >Dis.</span></th>
						<th style="width:40px"><span >Taxable Value</span></th>
						<th style="width:25px"><span >GST Rate</span></th>
						<th style="width:35px"><span >CGST(₹)</span></th>
						<th style="width:40px"><span >SGST(₹)</span></th>
						<th style="width:40px"><span >IGST(₹)</span></th>
						<th style="width:40px"><span >Total(₹)</span></th>
						<th style="width:1px;display:none;"><span >lQty</span></th>
						<th style="width:1px;display:none;"><span >itemId</span></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<a class="add" style="text-align:center;">+</a>
			<table class="balance">
				<tr>
					<th><span>Total(₹)</span></th>
					<td id="taxableTotal">0.00</td>
				</tr>
				<tr>
					<th><span >CGST(₹)</span></th>
					<td id="grandTotalCGST">0.00</td>
				</tr>
				<tr>
					<th><span >SGST(₹)</span></th>
					<td id="grandTotalSGST">0.00</td>
				</tr>
				<tr>
					<th><span >IGST(₹)</span></th>
					<td id="grandTotalIGST">0.00</td>
				</tr>
				<tr>
					<th><span >Grand Total(₹)</span></th>
					<td id="grandTotal">0.00</td>
				</tr>
			</table>
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
						<input type="search" class="form-control" id="itemDesp">
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
								<li><a >Goods</a></li>
								<li><a >Services</a></li>
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
								<li><a >0.25%</a></li>
								<li><a >12%</a></li>
								<li><a >18%</a></li>
								<li><a >28%</a></li>
								<li><a >3%</a></li>
								<li><a >5%</a></li>																
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
	
		</article>
		<aside>
			<h1><span contenteditable>Additional Notes</span></h1>
			<div  class="print">
				<p>*All charges are inclusive of taxes</p>
				<textarea style= "width:100%;height:80px;border:solid 3px grey;font-size: 18px;" id="invoiceNote" placeholder="Make a note"></textarea>
			</div>
		</aside>
		
	</body>
</html>