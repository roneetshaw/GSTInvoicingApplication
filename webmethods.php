<?php
	include('config.php');
	$type = mysqli_real_escape_string($db,$_POST['type']);
	function transpose($array) {
		return array_map(null, ...$array);
	}
	if($type=="1")
	{
		$query_type = mysqli_real_escape_string($db,$_POST['query_type']);
		$VendorName = mysqli_real_escape_string($db,$_POST['vendorName']);
		$GSTNUMBER = mysqli_real_escape_string($db,$_POST['custGST']);
		$State = mysqli_real_escape_string($db,$_POST['drpState']);
		$City = mysqli_real_escape_string($db,$_POST['custCity']);
		$contactPerson = mysqli_real_escape_string($db,$_POST['custContactName']);
		$MobileNumber = mysqli_real_escape_string($db,$_POST['custMobileNumber']);
		$PAN = mysqli_real_escape_string($db,$_POST['custPAN']);
		$Address = str_replace(array(":", "-", "/", "*","'"), '',mysqli_real_escape_string($db,$_POST['custAddress']));
		$pincode = mysqli_real_escape_string($db,$_POST['custPin']);
		if($query_type == "-99")
		{
			
			$insert_query = "insert into CUSTOMER_MASTER (VendorName, GSTNUMBER, State, City, contactPerson, MobileNumber, PAN, Address, pincode) values ('".$VendorName."','".$GSTNUMBER."','".$State."','".$City."','".$contactPerson."','".$MobileNumber."','".$PAN."','".$Address."','".$pincode."')";
			$runcheck=mysqli_query($db,$insert_query);
			if ( false===$runcheck ) {
			  printf("error: %s\n", mysqli_error($db));
			}
			else {
			  echo '1';
			}
		}
		else
		{
			$update_query = "Update CUSTOMER_MASTER set VendorName= '".$VendorName."',GSTNUMBER= '".$GSTNUMBER."',State= '".$State."',City='".$City."',contactPerson='".$contactPerson."',MobileNumber='".$MobileNumber."',PAN='".$PAN."',Address='".$Address."',pincode='".$pincode."' where id=".$query_type;
			$runcheck=mysqli_query($db,$update_query);
			if ( false===$runcheck ) {
			  printf("error: %s\n", mysqli_error($db));
			}
			else {
			  echo '1';
			}
		}
	}
	else if($type=="2")
	{
		$sql12="SELECT ID,vendorName,gstnumber,state,Mobilenumber FROM CUSTOMER_MASTER";
		$result = mysqli_query($db,$sql12);
		$ID = Array();$vendorName = Array();$gstnumber = Array();$state = Array();$mobilenumber = Array();
		while ($row = mysqli_fetch_array($result)) 
		{
			$ID[] = $row["ID"]; 
			$vendorName[] = $row["vendorName"];
			$gstnumber[] = $row["gstnumber"]; 
			$state[] = $row["state"];
			$mobilenumber[] = $row["Mobilenumber"]; 
		}
		//$row = mysqli_fetch_array($result);
		$res = array($ID, $vendorName,$gstnumber,$state,$mobilenumber);
		$res=transpose($res);
		echo json_encode($res);
	}

	else if($type=="3")
	{
		$custId = mysqli_real_escape_string($db,$_POST['id']);
		$total_row='select * from CUSTOMER_MASTER where id='.$custId;
		$result=mysqli_query($db,$total_row);
		$rows = mysqli_fetch_assoc($result);
		echo json_encode($rows);
		
	}
	else if($type=="4")
	{
		$query_type = mysqli_real_escape_string($db,$_POST['query_type']);
		$Description = mysqli_real_escape_string($db,$_POST['Description']);
		$ItemType = mysqli_real_escape_string($db,$_POST['ItemType']);
		$HSN = mysqli_real_escape_string($db,$_POST['HSN']);
		$ITEMCODE = mysqli_real_escape_string($db,$_POST['ITEMCODE']);
		$UNIT = mysqli_real_escape_string($db,$_POST['UNIT']);
		$TAXRATE = mysqli_real_escape_string($db,$_POST['TAXRATE']);
		$DISCOUNT = mysqli_real_escape_string($db,$_POST['DISCOUNT']);
		$CESSAMOUNT = str_replace(array(":", "-", "/", "*","'"), '',mysqli_real_escape_string($db,$_POST['CESSAMOUNT']));
		$PURCHASEPRICE = mysqli_real_escape_string($db,$_POST['PURCHASEPRICE']);
		$SELLINGPRICE = mysqli_real_escape_string($db,$_POST['SELLINGPRICE']);
		if($query_type == "-99")
		{
			
			$insert_query = "insert into ITEM_MASTER (Description, ItemType, HSN, ITEMCODE, UNIT, TAXRATE, DISCOUNT, CESSAMOUNT, PURCHASEPRICE, SELLINGPRICE, Quantity) values ('".$Description."','".$ItemType."','".$HSN."','".$ITEMCODE."','".$UNIT."','".$TAXRATE."','".$DISCOUNT."','".$CESSAMOUNT."','".$PURCHASEPRICE."','".$SELLINGPRICE."','0')";
			$runcheck=mysqli_query($db,$insert_query);
			if ( false===$runcheck ) {
			  printf("error: %s\n", mysqli_error($db));
			}
			else {
			  echo '1';
			}
		}
		else
		{
			$update_query = "Update ITEM_MASTER set Description= '".$Description."',ItemType= '".$ItemType."',HSN= '".$HSN."',ITEMCODE='".$ITEMCODE."',UNIT='".$UNIT."',TAXRATE='".$TAXRATE."',DISCOUNT='".$DISCOUNT."',CESSAMOUNT='".$CESSAMOUNT."',PURCHASEPRICE='".$PURCHASEPRICE."',SELLINGPRICE='".$SELLINGPRICE."' where id=".$query_type;
			$runcheck=mysqli_query($db,$update_query);
			if ( false===$runcheck ) {
			  printf("error: %s\n", mysqli_error($db));
			}
			else {
			  echo '1';
			}
		}
	}
	else if($type=="5")
	{
		$sql12="SELECT ID,Description,TAXRATE,SELLINGPRICE,PURCHASEPRICE,HSN, DISCOUNT, CONCAT(QUANTITY,' ',UNIT) as 'QUANTITY' FROM ITEM_MASTER";
		$result = mysqli_query($db,$sql12);
		$ID = Array();$Description = Array();$TAXRATE = Array();$SELLINGPRICE = Array();$PURCHASEPRICE = Array();$HSN = Array();$DISCOUNT = Array();$QUANTITY = Array();
		while ($row = mysqli_fetch_array($result)) 
		{
			$ID[] = $row["ID"]; 
			$Description[] = $row["Description"];
			$TAXRATE[] = $row["TAXRATE"]; 
			$SELLINGPRICE[] = $row["SELLINGPRICE"];
			$PURCHASEPRICE[] = $row["PURCHASEPRICE"]; 
			$HSN[] = $row["HSN"]; 
			$DISCOUNT[] = $row["DISCOUNT"]; 
			$QUANTITY[] = $row["QUANTITY"]; 
		}
		//$row = mysqli_fetch_array($result);
		$res = array($ID, $Description, $HSN, $PURCHASEPRICE, $SELLINGPRICE, $TAXRATE, $DISCOUNT,$QUANTITY);
		$res=transpose($res);
		echo json_encode($res);
	}

	else if($type=="6")
	{
		$custId = mysqli_real_escape_string($db,$_POST['id']);
		$total_row='select * from ITEM_MASTER where id='.$custId;
		$result=mysqli_query($db,$total_row);
		$rows = mysqli_fetch_assoc($result);
		echo json_encode($rows);
		
	}
	else if($type=="7")
	{
		$total_row='select ID,VendorName from CUSTOMER_MASTER';
		$result=mysqli_query($db,$total_row);
		$ID = Array();$VendorName = Array();
		while ($row = mysqli_fetch_array($result)) 
		{
			$ID[] = $row["ID"]; 
			$VendorName[] = $row["VendorName"];
			
		}
		//$row = mysqli_fetch_array($result);
		$res = array($ID, $VendorName);
		//$res=transpose($res);
		echo json_encode($res);
		//$rows = mysqli_fetch_assoc($result);
		//echo json_encode($rows);
		
	}
	else if($type=="8")
	{
		$custName = mysqli_real_escape_string($db,$_POST['customerName']);
		$select_gst="Select GSTNUMBER, ID from CUSTOMER_MASTER where VendorName like '".$custName."'";
		$result=mysqli_query($db,$select_gst);
		$row = mysqli_fetch_array($result);
		$gst = $row["GSTNUMBER"];
		$cust_type = "B2C";
		$created_date = date('d-m-Y');
		if(strlen($gst) > 0)
		{
			$cust_type = "B2B";
		}
		$insert_query = "insert into SALES_MASTER (CustomerID, TYPE, CreatedDate) values ('".$row["ID"]."','".$cust_type."',CURDATE())";
		$runcheck=mysqli_query($db,$insert_query);
		if ( false===$runcheck ) {
			printf("error: %s\n", mysqli_error($db));
		}
		else {
			echo '1,'.$row["ID"].','.mysqli_insert_id($db);
		}
		
	}
	else if($type=="9")
	{
		$total_row='select Description from ITEM_MASTER';
		$result=mysqli_query($db,$total_row);
		$Description = Array();
		while ($row = mysqli_fetch_array($result)) 
		{
			$Description[] = $row["Description"];
			
		}
		$res = array($Description);
		echo json_encode($res);
	}
	else if($type=="10")
	{
		$itemDesp = mysqli_real_escape_string($db,$_POST['Description']);
		$total_row="select * from ITEM_MASTER where Description like '".$itemDesp."'";
		$result=mysqli_query($db,$total_row);
		$rows = mysqli_fetch_assoc($result);
		echo json_encode($rows);
	}
	else if($type=="11")
	{
		$invId = mysqli_real_escape_string($db,$_POST['invId']);
		$stateToShip = mysqli_real_escape_string($db,$_POST['stateToShip']);
		$itemBillDate = mysqli_real_escape_string($db,$_POST['itemBillDate']);	
		$taxableTotal = mysqli_real_escape_string($db,$_POST['taxableTotal']);
		$grandTotalCGST = mysqli_real_escape_string($db,$_POST['grandTotalCGST']);
		$grandTotalSGST = mysqli_real_escape_string($db,$_POST['grandTotalSGST']);
		$grandTotalIGST = mysqli_real_escape_string($db,$_POST['grandTotalIGST']);
		$grandTotal = mysqli_real_escape_string($db,$_POST['grandTotal']);
		$invoiceAddress = str_replace(array("/:", "/-", "//", "/*","/'"), ' ',mysqli_real_escape_string($db,$_POST['invoiceAddress']));	
		$insert_query = "update SALES_MASTER set PlaceOfSupply ='".$stateToShip."', CreatedDate = '".$itemBillDate."', BillDate = '".$itemBillDate."', InvoiceAddress ='".$invoiceAddress."', TotalTaxable ='".$taxableTotal."', TOTALCGST ='".$grandTotalCGST."', TOTALSGST ='".$grandTotalSGST."', TOTALIGST ='".$grandTotalIGST."', GrandTotal ='".$grandTotal."' where InvoiceNo='".$invId."'";
		$runcheck=mysqli_query($db,$insert_query);
		if ( false===$runcheck ) {
			printf("error: %s\n", mysqli_error($db));
		}
		else {
			echo '1';
		}
	}
	else if($type=="12")
	{
		$invId = mysqli_real_escape_string($db,$_POST['invId']);
		$tableJSONObj =$_POST['JSONtableObject'];
		$data = json_decode($tableJSONObj,true);
		$invStatus=1;
		for ($i = 0; $i < count($data); $i++) {
			$insert_query = "insert into SALES_TRANSACTIONS (CGST, Discount, GSTRate, IGST, InvoiceNo, ItemID, Quantity, Rate, SGST, TaxableValue, TotalItemValue) values ('".$data[$i]['cgst']."','".$data[$i]['dis']."','".$data[$i]['gstrate']."','".$data[$i]['igst']."','".$invId."','".$data[$i]['itemID']."','".$data[$i]['qty']."','".$data[$i]['rate']."','".$data[$i]['sgst']."','".$data[$i]['taxableVal']."','".$data[$i]['itemtotal']."')";
			$runcheck=mysqli_query($db,$insert_query);
			if ( false===$runcheck ) {
				$invStatus = 0;
				printf("error: %s\n", mysqli_error($db));
			}
			$remQty=(int)$data[$i]['qtyLeft']-(int)$data[$i]['qty'];
			$UPDATE_ITEM_QUERY = "Update ITEM_MASTER set Quantity= '".$remQty."' where id=".$data[$i]['itemID'];
			$runcheck=mysqli_query($db,$UPDATE_ITEM_QUERY);
		}
		echo $invStatus;
	}
	
	else if($type=="13")
	{
		$sql13="SELECT sm.BillDate as Date,sm.InvoiceNo as InvoiceNo, cm.VendorName as custName,
		cm.GSTNUMBER as GST, sm.TotalTaxable as TotalTaxable, (sm.TOTALCGST+sm.TOTALSGST+sm.TOTALIGST) as Tax,
		sm.GrandTotal as GrandTotal, sm.TYPE as custType
		FROM sales_master sm INNER JOIN customer_master cm ON sm.CustomerID = cm.ID";
		$result = mysqli_query($db,$sql13);
		$Date = Array();$InvoiceNo = Array();$custName = Array();$GST = Array();$TotalTaxable = Array();$Tax = Array();$GrandTotal = Array();$custType = Array();
		while ($row = mysqli_fetch_array($result)) 
		{
			$Date[] = $row["Date"]; 
			$InvoiceNo[] = $row["InvoiceNo"];
			$custName[] = $row["custName"]; 
			$GST[] = $row["GST"];
			$TotalTaxable[] = $row["TotalTaxable"]; 
			$Tax[] = $row["Tax"]; 
			$GrandTotal[] = $row["GrandTotal"]; 
			$custType[] = $row["custType"]; 
		}
		//$row = mysqli_fetch_array($result);
		$res = array($Date, $InvoiceNo, $custName, $GST, $TotalTaxable, $Tax, $GrandTotal, $custType);
		$res=transpose($res);
		echo json_encode($res);
	}
	
	else if($type=="14")
	{
		$invId = mysqli_real_escape_string($db,$_POST['invId']);
		$sql14="SELECT sm.BillDate as Date, sm.PlaceOfSupply as PlaceOfSupply, sm.InvoiceAddress as InvoiceAddress,sm.TOTALCGST as TOTALCGST,sm.TOTALSGST as TOTALSGST,sm.TOTALIGST as TOTALIGST, sm.InvoiceNo as InvoiceNo, cm.VendorName as custName,
		cm.GSTNUMBER as GST, sm.TotalTaxable as TotalTaxable, (sm.TOTALCGST+sm.TOTALSGST+sm.TOTALIGST) as Tax,
		sm.GrandTotal as GrandTotal, sm.TYPE as custType
		FROM sales_master sm INNER JOIN customer_master cm ON sm.CustomerID = cm.ID where sm.InvoiceNo='".$invId."'";
		$result=mysqli_query($db,$sql14);
		$rows = mysqli_fetch_assoc($result);
		echo json_encode($rows);
		
	}
	else if($type=="15")
	{
		$invId = mysqli_real_escape_string($db,$_POST['invId']);
		$sql15="select *,SALES_TRANSACTIONS.Quantity as iQty,im.Quantity as qtyLeft,im.Description as desp, im.HSN as hsn, im.UNIT as un from SALES_TRANSACTIONS INNER JOIN item_master im on im.ID=sales_transactions.ItemID where InvoiceNo='".$invId."'";
		$result = mysqli_query($db,$sql15);
		$CGST = Array();$SGST = Array();$IGST = Array();$TotalItemValue = Array();$TaxableValue = Array();$Discount = Array();$GSTRate = Array();$Rate = Array();$Quantity = Array();$ItemID = Array();$InvoiceNo = Array();$ID = Array();$qtyLeft = Array();$desp = Array();$hsn = Array();$un = Array();
		while ($row = mysqli_fetch_array($result)) 
		{
			$CGST[] = $row["CGST"]; 
			$SGST[] = $row["SGST"];
			$IGST[] = $row["IGST"]; 
			$TotalItemValue[] = $row["TotalItemValue"];
			$TaxableValue[] = $row["TaxableValue"]; 
			$Discount[] = $row["Discount"]; 
			$GSTRate[] = $row["GSTRate"]; 
			$Rate[] = $row["Rate"]; 
			$Quantity[] = $row["iQty"]; 
			$ItemID[] = $row["ItemID"]; 
			$InvoiceNo[] = $row["InvoiceNo"]; 
			$ID[] = $row["ID"]; 
			$qtyLeft[] = $row["qtyLeft"]; 
			$desp[] = $row["desp"]; 
			$hsn[] = $row["hsn"]; 
			$un[] = $row["un"]; 
		}
		$res = array($CGST, $SGST, $IGST,$TotalItemValue,$TaxableValue,$Discount, $GSTRate, $Rate,$Quantity	,$ItemID, $ID, $qtyLeft, $desp, $hsn, $un);
		echo json_encode($res);
	}
?>