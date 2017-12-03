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
									<table id="itemDisplay" class="table table-condensed table-hover" width="100%"></table>
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
								window.location.href = "/gst/salesinvoice.php?cust_id="+d[1]+"&name="+$('#customerName').val().trim()+"&invId="+d[2];
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
					{ title: "DATE" },
					{ title: "ID" },
					{ title: "CUSTOMER" },
					{ title: "GSTIN" },
					{ title: "TAXABLE AMOUNT" },
					{ title: "TAX" }
					//{ title: "TOTAL AMOUNT" }
					//{ title: "TYPE" }
					//{ title: "STATUS" }
					
				]
			} );
    	});
	</script>

</html>
