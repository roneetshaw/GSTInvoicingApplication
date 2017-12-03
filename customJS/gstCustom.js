$(document).ready(function() {

	$("#drpState ul li").on('click',function(){
		$("#custDrpstate").html($(this).text()+'  '+'<span class="caret"></span></button>');
	})
	$("#itemType ul li").on('click',function(){
		$("#itemType button").html($(this).text()+'  '+'<span class="caret"></span></button>');

	})
	$("#itemUnit ul li").on('click',function(){
		$("#itemUnit button").html($(this).text()+'  '+'<span class="caret"></span></button>');
	})
	$("#itemTaxRate ul li").on('click',function(){
		$("#itemTaxRate button").html($(this).text()+'  '+'<span class="caret"></span></button>');
	})
	$("#custDisplay").on('click','tbody tr',function(){
		custId=$(this).find(':nth-child(1)').text().trim();
		$("#custHiddensave").val(custId);
		$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 3, id: custId },
					success: function (d) {
						dataRET=JSON.parse(d);
						$("#custName").val(dataRET.VendorName); $("#custGST").val(dataRET.GSTNUMBER);$("#custCity").val(dataRET.City); $("#drpState button").html(dataRET.State+'  '+'<span class="caret"></span></button>'); $("#custContactName").val(dataRET.contactPerson); $("#custMobileNumber").val(dataRET.MobileNumber); $("#custPAN").val(dataRET.PAN);$("#custPin").val(dataRET.pincode);$("#custAddress").val(dataRET.Address) 
						//console.log(dataRET);
					},
					error: function (log) {
						console.log(log);
					}
		});
		$("#addCustomerModal").modal('show');
		
	});
	$("#itemDisplay").on('click','tbody tr',function(){
		itemId=$(this).find(':nth-child(1)').text().trim();
		$("#itemHiddensave").val(itemId);
		$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 6, id: itemId },
					success: function (d) {
						dataRET=JSON.parse(d);
						console.log(dataRET);
						$("#addItemModal input:eq(0)").val(dataRET.Description); $("#addItemModal button:eq(2)").html(dataRET.ItemType+'  '+'<span class="caret"></span></button>');$("#addItemModal button:eq(3)").html(dataRET.UNIT+'  '+'<span class="caret"></span></button>'); $("#addItemModal button:eq(4)").html(dataRET.TAXRATE+'  '+'<span class="caret"></span></button>'); $("#addItemModal input:eq(1)").val(dataRET.HSN); $("#addItemModal input:eq(2)").val(dataRET.ITEMCODE); $("#addItemModal input:eq(3)").val(dataRET.DISCOUNT);$("#addItemModal input:eq(4)").val(dataRET.CESSAMOUNT);$("#addItemModal input:eq(5)").val(dataRET.PURCHASEPRICE);
						$("#addItemModal input:eq(6)").val(dataRET.SELLINGPRICE);
						
					},
					error: function (log) {
						console.log(log);
					}
		});
		$("#addItemModal").modal('show');
		
	});
});