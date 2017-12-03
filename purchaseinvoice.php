
<html>
	<head>
		<meta charset="utf-8">
		<title>Invoice</title>
		<link rel="license" href="https://www.opensource.org/licenses/mit-license/">
		<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
				<link rel="stylesheet" href="invoice.css?v=3.1">
		<?php include 'jslibrary.php';?>
		<script src="invoice.js?v=4"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script type="text/javascript">
			var url = new URL(window.location.href);
			var c = url.searchParams.get("cust_id");
			alert(c);
			var i=0;
			$( function() {
				$( "#itemBillDate" ).datepicker({ dateFormat: 'dd/mm/yy' });
			});
			$(document).ready(function() {
				$('#itemList tbody tr').on('click','a',function(){
					alert($('#itemList tbody tr').length);
				});
				$(".add").on('click',function(){
					//alert(2);
				});
				$("#btnInvoiceSave").on('click',function(){
					alert("Hello")
				})
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
				
			});
			
			
		</script>
		<style>

		</style>
	</head>
	<body >
		<div class="row" style="text-align:center;">
						<div class="col-sm-3">
							<button type="button" class="btn btn-default" id="btnInvoiceSave">Save</button>
						</div>
						<div class="col-sm-3">
							<button type="button" class="btn btn-default" id="btnInvoiceEdit">Edit</button>
						</div>
						<div class="col-sm-3">
							<button type="button" onclick="window.history.go(-1); return false;" class="btn btn-default" id="btnInvoiceBackx">Back</button>
						</div>
						<div class="col-sm-3">
							<button type="button" class="btn btn-primary" id="btnInvoiceBackx">Print</button>
						</div>
		</div>
		<header>
			<h1>Invoice</h1>
			<address contenteditable>
				<p>Jonathan Neal</p>
				<p>101 E. Chapman Ave<br>Orange, CA 92866</p>
				<p>(800) 555-1234</p>
			</address>
			<span><img alt="" src="http://www.jonathantneal.com/examples/invoice/logo.png"><input type="file" accept="image/*"></span>
		</header>
		<article>
			<h1>Recipient</h1>
			<address contenteditable>
				<p>Some Company<br>c/o Some Guy</p>
			</address>
			<table class="meta">
				<tr>
					<th><span>Invoice #</span></th>
					<td><span contenteditable>00001</span></td>
				</tr>
				<tr>
					<th><span>Bill Date</span></th>
					<td><input id="itemBillDate" placeholder="MM/DD/YYYY" type="text"/></td>
				</tr>
				<tr>
					<th><span>Place of Supply</span></th>
					<td><span contenteditable>West Bengal</span></td>
				</tr>
			</table>
			
			<table class="inventory" id="itemList">
				<thead>
					<tr>
						<th style="width:15px"><span >#</span></th>
						<th style="width:130px"><span >Item Description</span></th>
						<th style="width:30px"><span >HSN</span></th>
						<th style="width:20px"><span >Rate</span></th>
						<th style="width:20px"; ><span >Qty.</span></th>
						<th style="width:30px"><span >Unit</span></th>
						<th style="width:25px"><span >Dis.</span></th>
						<th style="width:40px"><span >Taxable Value</span></th>
						<th style="width:30px"><span >GST Rate</span></th>
						<th style="width:40px"><span >CGST(₹)</span></th>
						<th style="width:40px"><span >SGST(₹)</span></th>
						<th style="width:40px"><span >IGST(₹)</span></th>
						<th style="width:40px"><span >Total(₹)</span></th>
					</tr>
				</thead>
				<tbody>
					<!--<tr>
						<td><a class="cut" id="minus">-</a><span contenteditable>1</span></td>
						<td><span contenteditable>Experience Review</span></td>
						<td><span contenteditable>150</span></td>
						<td><span contenteditable>4</span></td>
						<td><span contenteditable>4</span></td>
						<td><span>600.00</span></td>
						<td><span contenteditable>10%</span></td>
						<td><span data-prefix>₹</span><span contenteditable>12,00</span></td>						
						<td><span contenteditable>4</span></td>
						<td><span data-prefix>₹</span><span contenteditable>150.00</span></td>
						<td><span data-prefix>₹</span><span>600.00</span></td>
						<td><span data-prefix>₹</span><span>600.00</span></td>
						<td><span data-prefix>₹</span><span>600.00</span></td>
					</tr>-->
				</tbody>
			</table>
			<a class="add">+</a>
			<table class="balance">
				<tr>
					<th><span>Total(₹)</span></th>
					<td><span>600.00</span></td>
				</tr>
				<tr>
					<th><span >CGST(₹)</span></th>
					<td><span >0.00</span></td>
				</tr>
				<tr>
					<th><span >SGST(₹)</span></th>
					<td><span>600.00</span></td>
				</tr>
				<tr>
					<th><span >IGST(₹)</span></th>
					<td><span >0.00</span></td>
				</tr>
				<tr>
					<th><span >Grand Total(₹)</span></th>
					<td><span>600.00</span></td>
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
	
		</article>
		<aside>
			<h1><span contenteditable>Additional Notes</span></h1>
			<div contenteditable>
				<p>A finance charge of 1.5% will be made on unpaid balances after 30 days.</p>
			</div>
		</aside>
		
	</body>
</html>