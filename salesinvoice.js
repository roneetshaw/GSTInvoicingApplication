/* Shivving (IE8 is not supported, but at least it won't look as awful)
/* ========================================================================== */

(function (document) {
	var
	head = document.head = document.getElementsByTagName('head')[0] || document.documentElement,
	elements = 'article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output picture progress section summary time video x'.split(' '),
	elementsLength = elements.length,
	elementsIndex = 0,
	element;

	while (elementsIndex < elementsLength) {
		element = document.createElement(elements[++elementsIndex]);
	}

	element.innerHTML = 'x<style>' +
		'article,aside,details,figcaption,figure,footer,header,hgroup,nav,section{display:block}' +
		'audio[controls],canvas,video{display:inline-block}' +
		'[hidden],audio{display:none}' +
		'mark{background:#FF0;color:#000}' +
	'</style>';

	return head.insertBefore(element.lastChild, head.firstChild);
})(document);

/* Prototyping
/* ========================================================================== */

(function (window, ElementPrototype, ArrayPrototype, polyfill) {
	function NodeList() { [polyfill] }
	NodeList.prototype.length = ArrayPrototype.length;

	ElementPrototype.matchesSelector = ElementPrototype.matchesSelector ||
	ElementPrototype.mozMatchesSelector ||
	ElementPrototype.msMatchesSelector ||
	ElementPrototype.oMatchesSelector ||
	ElementPrototype.webkitMatchesSelector ||
	function matchesSelector(selector) {
		return ArrayPrototype.indexOf.call(this.parentNode.querySelectorAll(selector), this) > -1;
	};

	ElementPrototype.ancestorQuerySelectorAll = ElementPrototype.ancestorQuerySelectorAll ||
	ElementPrototype.mozAncestorQuerySelectorAll ||
	ElementPrototype.msAncestorQuerySelectorAll ||
	ElementPrototype.oAncestorQuerySelectorAll ||
	ElementPrototype.webkitAncestorQuerySelectorAll ||
	function ancestorQuerySelectorAll(selector) {
		for (var cite = this, newNodeList = new NodeList; cite = cite.parentElement;) {
			if (cite.matchesSelector(selector)) ArrayPrototype.push.call(newNodeList, cite);
		}

		return newNodeList;
	};

	ElementPrototype.ancestorQuerySelector = ElementPrototype.ancestorQuerySelector ||
	ElementPrototype.mozAncestorQuerySelector ||
	ElementPrototype.msAncestorQuerySelector ||
	ElementPrototype.oAncestorQuerySelector ||
	ElementPrototype.webkitAncestorQuerySelector ||
	function ancestorQuerySelector(selector) {
		return this.ancestorQuerySelectorAll(selector)[0] || null;
	};
})(this, Element.prototype, Array.prototype);

/* Helper Functions
/* ========================================================================== */
var x=1;
var tempRow;
initItemName()
var autocompleteOptions= [];
function initItemName()
{
	$.ajax({ 
		url: 'webmethods.php',
		type: 'POST',
		data: {type: 9},
		success: function (d) {
			dataRET=JSON.parse(d);
			autocompleteOptions = dataRET[0]
			$('.itemDespText').autocomplete({
				source: autocompleteOptions,
				response: function(event, ui){
					ui.content.push({id:'New Item', label:'New Item', value:''});
				},
				minLength: 3,
				delay:500,
				autoFocus: true,
				open: function(event) {},
				close: function() {},
				focus: function(event,ui) {
				},
				select: function (e, ui) {

					if(ui.item.label.trim() == "New Item")
					{
						$("#addItemModal").modal('show');
					}
					else
					{
						fillItemDetails(ui.item.label.trim(),tempRow);
					}
				}
			});
		},
		error: function (log) {
			console.log(log);
		}
	});
}
	$('#itemDesp').on("click", "li", function(event) {
		
    });
	function fillItemDetails(itemDesp,ele)
	{
		var tableElem = ele.parent();
		$.ajax({ 
			url: 'webmethods.php',
			type: 'POST',
			data: {type: 10, Description: itemDesp},
			success: function (d) {
				dataRET=JSON.parse(d);
				console.log(dataRET);
				tableElem.parent().find('td:nth-child(3)').text(dataRET.HSN)
				tableElem.parent().find('td:nth-child(6)').text(dataRET.UNIT)
				tableElem.parent().find('td:nth-child(14)').text(dataRET.Quantity)
				tableElem.parent().find('td:nth-child(15)').text(dataRET.ID);
				tableElem.parent().find('td:nth-child(16)').text('0');
				if(dataRET.TAXRATE.trim().indexOf("%") == -1)
					tableElem.parent().find('td:nth-child(9) input').val(dataRET.TAXRATE.trim()+"%")
				else
					tableElem.parent().find('td:nth-child(9) input').val(dataRET.TAXRATE.trim())
				if(dataRET.DISCOUNT.length > 0)
					tableElem.parent().find('td:nth-child(7) input').val(dataRET.DISCOUNT.trim())
			},
			error: function (log) {
				console.log(log);
			}
		});
	}

function calRow(elem)
{
	var rateVal=elem;
	var qtyVal=elem.parent().next().find('input');
	var disVal=elem.parent().next().next().next().find('input');
	var taxVal=elem.parent().next().next().next().next();
	var gstVal=elem.parent().next().next().next().next().next().find('input');
	var cGSTVal=elem.parent().next().next().next().next().next().next();
	var sGSTVal=elem.parent().next().next().next().next().next().next().next();
	var iGSTVal=elem.parent().next().next().next().next().next().next().next().next();
	var totalVal=elem.parent().next().next().next().next().next().next().next().next().next();
	if(rateVal.val().length != 0 && qtyVal.val().length != 0)
	{
		var taxValue=parseFloat(rateVal.val())*parseInt(qtyVal.val())
		var disGSTVal=disVal.val().trim();
		var discount;
		if(disGSTVal.length == 0)
		{
			discount='0';
		}
		else
		{
			if(disGSTVal.indexOf("%") != -1)
			{
				if(disGSTVal.indexOf("%") > 0)
				{
					var discountRate=disGSTVal.substring(0,disGSTVal.indexOf("%"));
					discount= 0.01*parseFloat(discountRate)*taxValue;
				}
				else
					discount='0';
			}
			else
			{
				discount=disGSTVal;
			}
		}
		taxValue=taxValue-parseFloat(discount);
		taxVal.text(taxValue.toFixed(2));
		var gstRate='';
		if(gstVal.val().trim().indexOf("%") != -1)
		{
			gstRate=gstVal.val().trim().substring(0,gstVal.val().trim().indexOf("%"));
		}
		else
		{
			gstRate=gstVal.val().trim();
		}
		if(gstVal.val().trim().indexOf("%") > 0)
		{
			var invoiceType=$('#stateToShip').val();
			var gstTaxVal=0.01*parseFloat(gstRate)*taxValue;
			var iGST=gstTaxVal.toFixed(2);
			var cGST=(0.5*gstTaxVal).toFixed(2);
			var sGST=(0.5*gstTaxVal).toFixed(2);
			if(invoiceType == "West Bengal")
			{
				cGSTVal.text(cGST);
				sGSTVal.text(sGST);
				iGSTVal.text('0.00');
			}
			else
			{
				iGSTVal.text(iGST);
				cGSTVal.text('0.00');
				sGSTVal.text('0.00');
			}
			totalVal.text((parseFloat(taxValue)+parseFloat(iGST)).toFixed(2));
			var grandTotal= 0.00;
			var grandTotalIGST= 0.00;
			var grandTotalCGST= 0.00;
			var grandTotalSGST= 0.00;
			var grandTotalTaxableVal= 0.00;
			$("#itemList tbody tr td:nth-child(10)").each(function()
			{
				var tbltaxVal=parseFloat($(this).prev().prev().text().trim());
				var tblcGST=parseFloat($(this).text().trim());
				var tblsGST=parseFloat($(this).next().text().trim());
				var tbliGST=parseFloat($(this).next().next().text().trim());
				var tblTotal=parseFloat($(this).next().next().next().text().trim());
				grandTotal= Math.round(grandTotal+tblTotal);
				grandTotalIGST = grandTotalIGST + tbliGST;
				grandTotalCGST = grandTotalCGST + tblcGST;
				grandTotalSGST = grandTotalSGST + tblsGST;
				grandTotalTaxableVal = grandTotalTaxableVal + tbltaxVal;
			})
			$('#grandTotal').text(grandTotal.toFixed(2));
			$('#grandTotalCGST').text(grandTotalCGST.toFixed(2));
			$('#grandTotalSGST').text(grandTotalSGST.toFixed(2));
			$('#grandTotalIGST').text(grandTotalIGST.toFixed(2));
			$('#taxableTotal').text(grandTotalTaxableVal.toFixed(2));
		}
	}
}

function rateChange(elem)
{
	calRow(elem)
}

function qtyChange(elem,txt)
{
	var oldval=parseInt(elem.parent().parent().find('td:nth-child(16)').text().trim());
	var itemDesp=elem.parent().prev().prev().prev().find('input')
	var askQuant = parseInt(elem.val());
	var savedQuant = parseInt(elem.parent().parent().find('td:nth-child(14)').text().trim()) + oldval;
	if( askQuant <= savedQuant )
		calRow(elem.parent().prev().find('input'))
	else
	{
		emptyRow(elem);
		alert(itemDesp.val()+" Maximum quantity allowed: "+(savedQuant));
	}
}

function disChange(elem)
{
	calRow(elem.parent().prev().prev().prev().find('input'));
}

function gstChange(elem)
{
	calRow(elem.parent().prev().prev().prev().prev().prev().find('input'));
}

function emptyRow(elem)
{
	elem.val('');
		if(elem.parent().parent().find('td:nth-child(13)').text().trim().length>0)
			$('#grandTotal').text((parseFloat($('#grandTotal').text().trim())-parseFloat(elem.parent().parent().find('td:nth-child(13)').text().trim())).toFixed(2));
		if(elem.parent().parent().find('td:nth-child(10)').text().trim().length>0)
			$('#grandTotalCGST').text((parseFloat($('#grandTotalCGST').text().trim())-parseFloat(elem.parent().parent().find('td:nth-child(10)').text().trim())).toFixed(2));
		if(elem.parent().parent().find('td:nth-child(11)').text().trim().length>0)
			$('#grandTotalSGST').text((parseFloat($('#grandTotalSGST').text().trim())-parseFloat(elem.parent().parent().find('td:nth-child(11)').text().trim())).toFixed(2));
		if(elem.parent().parent().find('td:nth-child(12)').text().trim().length>0)
			$('#grandTotalIGST').text((parseFloat($('#grandTotalIGST').text().trim())-parseFloat(elem.parent().parent().find('td:nth-child(12)').text().trim())).toFixed(2));
		if(elem.parent().parent().find('td:nth-child(8)').text().trim().length>0)
			$('#taxableTotal').text((parseFloat($('#taxableTotal').text().trim())-parseFloat(elem.parent().parent().find('td:nth-child(8)').text().trim())).toFixed(2));
		elem.parent().parent().find('td:nth-child(10)').text('');
		elem.parent().parent().find('td:nth-child(11)').text('');
		elem.parent().parent().find('td:nth-child(12)').text('');
		elem.parent().parent().find('td:nth-child(13)').text('');
		elem.parent().parent().find('td:nth-child(8)').text('');
}


function showSmallModal(elem)
{
	var e = elem;
	var itemId = elem.parent().parent().parent().parent().find('td:nth-child(15)').text().trim()
	initItemDetailTable(itemId);
	fillQtyLeft(itemId);
	$("#itemDespModal").modal('show');
}

function fillQtyLeft(id)
{
	$.ajax({ 
		url: 'webmethods.php',
		type: 'POST',
		data: {type: 27, id: id },
		success: function (data1) {
			var arr = JSON.parse(data1);
			$('#qtyDetailLeft').text(" "+arr.nm+"( Quantity Left: "+arr.qty+")");
		},
		error: function (log) {
			console.log(log.message);
		}
	});
}
function initItemDetailTable(id)
{
	$.ajax({ 
		url: 'webmethods.php',
		type: 'POST',
		data: {type: 26, id: id },
		success: function (data1) {
			var arr = JSON.parse(data1);
			console.log(arr)			
			fillPerItemDetails(arr);
			
		},
		error: function (log) {
			console.log(log.message);
		}
	});
}

function fillPerItemDetails(dataSet)
{
	$('#itemPerDetail').DataTable({
		data: dataSet,
		destroy: true,
		"aoColumns": [
			{"sTitle": "Serial NO"},
			{ "sType": "date-uk","sTitle": "DATE" },
			{"sTitle": "CUSTOMER"},
			{"sTitle": "INV.NO."},
			{"sTitle": "QTY"},
			{"sTitle": "RATE"},
			{"sTitle": "GST"}
				
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
} );	



function generateTableRow() {
	
	var emptyColumn = document.createElement('tr');
	//var input=$('<input class="itemDesp" placeholder="Type a Location" style="width:100%;text-align:left;" type="text" ></input>');
    
	
	emptyColumn.innerHTML = '<td style ="text-align:center;"><a class="cut">-</a><div class="row "><div class="col-sm-6"><a onclick="showSmallModal($(this))" href="javascript:void(0)" class="smlbtn round-button1 no-print"></a></div><div  class="col-sm-6"><span>'+(x)+'</span></div></div></td>' +
		'<td style="padding:0px;height: 30px;" ><input class="itemDespText" placeholder="Type an Item" style="width:100%;height:100%;text-align:left;" type="search" ></input></td>' +
		'<td></td>' +
		'<td style="padding:0px;height: 30px;" ><input  style="width:100%;height:100%;text-align:center;" type="text" onchange="rateChange($(this))"></input></td>' +
		'<td style="padding:0px;height: 30px;" ><input style="width:100%;height:100%;text-align:center;" type="number" min="0" onfocus="this.oldvalue = this.value;" onchange="qtyChange($(this),this);this.oldvalue = this.value;"></input></td>'+
		'<td style="text-align:center;display:none;"><span ></span></td>' +
		'<td style="padding:0px;height: 30px;display:none;" ><input style="width:100%;height:100%;text-align:center;" type="text" onchange="disChange($(this))"></td>' +
		'<td></td>' +
		'<td style="padding:0px;height: 30px;" ><input style="width:100%;height:100%;text-align:center;" type="text" onchange="gstChange($(this))"></td>'+
		'<td></td>' +
		'<td></td>' +
		'<td></td>' +
		'<td></td>' +
		'<td style="display:none;"></td>'+
		'<td style="display:none;"></td>'+
		'<td style="display:none;"></td>';
		
	$('.itemDespText', emptyColumn).autocomplete({
		source: autocompleteOptions,
		response: function(event, ui){
            ui.content.push({id:'New Item', label:'New Item', value:''});
        },
        minLength: 3,
		delay:500,
        autoFocus: true,
        open: function(event) {},
        close: function() {},
        focus: function(event,ui) {

        },
		select: function (e, ui) {

			if(ui.item.label.trim() == "New Item")
			{
				$("#addItemModal").modal('show');
				tempRow=$(emptyColumn).find('td:nth-child(2) input');
			}
			else
			{
				fillItemDetails(ui.item.label.trim(),$(emptyColumn).find('td:nth-child(2) input'));
			}
		}
	});
	/*var render = $('.itemDespText', emptyColumn).autocomplete('instance')._renderMenu;
						$('.itemDespText', emptyColumn).autocomplete('instance')._renderMenu = function(ul, items) {
						  items.push({ label: 'New Item', value: '' });
						  render.call(this, ul, items);
						};*/
	return emptyColumn;
}

function parseFloatHTML(element) {
	return parseFloat(element.innerHTML.replace(/[^\d\.\-]+/g, '')) || 0;
}

function parsePrice(number) {
	return number.toFixed(2).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1,');
}

/* Update Number
/* ========================================================================== */

function updateNumber(e) {
	var
	activeElement = document.activeElement,
	value = parseFloat(activeElement.innerHTML),
	wasPrice = activeElement.innerHTML == parsePrice(parseFloatHTML(activeElement));

	if (!isNaN(value) && (e.keyCode == 38 || e.keyCode == 40 || e.wheelDeltaY)) {
		e.preventDefault();

		value += e.keyCode == 38 ? 1 : e.keyCode == 40 ? -1 : Math.round(e.wheelDelta * 0.025);
		value = Math.max(value, 0);

		activeElement.innerHTML = wasPrice ? parsePrice(value) : value;
	}

	updateInvoice();
}

/* Update Invoice
/* ========================================================================== */

function updateInvoice() {
	var total = 0;
	var cells, price, total, a, i;

	// update inventory cells
	// ======================

	for (var a = document.querySelectorAll('table.inventory tbody tr'), i = 0; a[i]; ++i) {
		// get inventory row cells
		/*cells = a[i].querySelectorAll('span:last-child');

		// set price as cell[2] * cell[3]
		price = parseFloatHTML(cells[2]) * parseFloatHTML(cells[3]);

		// add price to total
		total += price;

		// set row total
		cells[4].innerHTML = price;*/
	}

}

/* On Content Load
/* ========================================================================== */

function onContentLoad() {
	updateInvoice();

	var
	input = document.querySelector('input'),
	image = document.querySelector('img');

	function onClick(e) {
		var element = e.target.querySelector('[contenteditable]'), row;
		
		element && e.target != document.documentElement && e.target != document.body && element.focus();
		
		if (e.target.matchesSelector('.add')) {
			document.querySelector('table.inventory tbody').appendChild(generateTableRow());
			x++;
			//$("table.inventory tbody tr td:eq(0)").text("ron")
		}
		else if (e.target.className == 'cut') {
			row = e.target.ancestorQuerySelector('tr');
			emptyRow($(row).find('td:nth-child(5) input'))
			row.parentNode.removeChild(row);
			var y=1;
			
			$("table.inventory tbody tr").each(function(){
				
				var node='<a class="cut">-</a><span>'+(y)+'</span>'
				$(this).find("td:eq(0)").html(node);
				y++;
			})
			x=y;
		}

		updateInvoice();
	}

	function onEnterCancel(e) {
		e.preventDefault();

		image.classList.add('hover');
	}

	function onLeaveCancel(e) {
		e.preventDefault();

		image.classList.remove('hover');
	}

	function onFileInput(e) {
		console.log("Hi");
		image.classList.remove('hover');

		var
		reader = new FileReader(),
		files = e.dataTransfer ? e.dataTransfer.files : e.target.files,
		i = 0;

		reader.onload = onFileLoad;

		while (files[i]) reader.readAsDataURL(files[i++]);
	}

	function onFileLoad(e) {
		var data = e.target.result;

		image.src = data;
	}

	if (window.addEventListener) {
		document.addEventListener('click', onClick);

		document.addEventListener('mousewheel', updateNumber);
		document.addEventListener('keydown', updateNumber);

		document.addEventListener('keydown', updateInvoice);
		document.addEventListener('keyup', updateInvoice);

		input.addEventListener('focus', onEnterCancel);
		input.addEventListener('mouseover', onEnterCancel);
		input.addEventListener('dragover', onEnterCancel);
		input.addEventListener('dragenter', onEnterCancel);

		input.addEventListener('blur', onLeaveCancel);
		input.addEventListener('dragleave', onLeaveCancel);
		input.addEventListener('mouseout', onLeaveCancel);

		input.addEventListener('drop', onFileInput);
		input.addEventListener('change', onFileInput);
	}
}

window.addEventListener && document.addEventListener('DOMContentLoaded', onContentLoad);
