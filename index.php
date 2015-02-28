<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>HW6</title>
</head>

<body>
	<div>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
			Key Words: <input type="text" name="keywords"><br>
			Price Range: from $<input type="text" name="MinPrice">
						 to $<input type="text" name="MaxPrice"><br>
			Condition: <input type="checkbox" name="conditions[]" value="1000">New  
					   <input type="checkbox" name="conditions[]" value="3000">Used 
					   <input type="checkbox" name="conditions[]" value="4000">Very Good
					   <input type="checkbox" name="conditions[]" value="5000">Good 
					   <input type="checkbox" name="conditions[]" value="6000">Acceptable <br> 
			Buying formats: <input type="checkbox" name="listingTypes[]" value="FixedPrice">Buy It Now
							<input type="checkbox" name="listingTypes[]" value="Auction">Auction
							<input type="checkbox" name="listingTypes[]" value="Classified">Classified Ads <br>
			Seller: <input type="checkbox" name="returnAccept" value="true">Buy It Now <br>
			Shipping: <div>
						  <input type="checkbox" name="freeShipping" value="true">Free Shipping<br>
						  <input type="checkbox" name="expeditedShopping" value="Expedited">Expedited shipping available<br>
						  Max handling time(days): <input type="text" name="shippingTime"><br>
					  </div>
			<input type="submit" name="submit" value="search">
		</form>	
	</div>
	<?php 

		if(isset($_GET['submit'])){

			//basicurl construct
			$starturl = 'http://svcs.ebay.com/services/search/FindingService/v1';
			$siteid = '0';
			$appid = 'US7ec6dfe-0c4c-4665-9904-c761744ec4f';
			$operationName = 'findItemsAdvanced';
			$responseFormat = 'XML';
			$serviceVersion = '1.0.0';

			$basicurl = "$starturl?siteid=$siteid"."&SECURITY-APPNAME=$appid"
						."&OPERATION-NAME=$operationName"."&SERVICE-VERSION=$serviceVersion"
						."&RESPONSE-DATA-FORMAT=$responseFormat";

			//finalurl construct
			$i = 0;
			//process keywords
			$keywords = $_GET['keywords'];
			$finalurl = $basicurl."&keywords=$keywords";


			//process condition
			$conditions = $_GET['conditions'];
			if($conditions){
				$finalurl .= "&itemFilter($i).name=Condition";
				foreach ($conditions as $key => $val){
					$finalurl .="&itemFilter($i).value($key)=$val";
				}
				$i++;
			}
			

			//process buying formats
			$listingTypes = $_GET['listingTypes'];
			if($listingTypes){
				$finalurl .= "&itemFilter($i).name=ListingType";
				foreach ($listingTypes as $key => $val){
					$finalurl .="&itemFilter($i).value($key)=$val";
				}
				$i++;
			}

			//process returnAccept
			$returnAccept = $_GET['returnAccept'];
			if($returnAccept){
				$finalurl .= "&itemFilter($i).name=ReturnsAcceptedOnly";
				$finalurl .="&itemFilter($i).value(0)=$returnAccept";
				$i++;
			}

			//process free shipping
			$freeShipping = $_GET['freeShipping'];
			if($freeShipping){
				$finalurl .= "&itemFilter($i).name=FreeShippingOnly";
				$finalurl .="&itemFilter($i).value(0)=$freeShipping";
				$i++;
			}

			//process expedited shipping
			$expeditedShopping = $_GET['expeditedShopping'];
			if($expeditedShopping){
				$finalurl .= "&itemFilter($i).name=ExpeditedShippingType";
				$finalurl .="&itemFilter($i).value(0)=$expeditedShopping";
				$i++;
			}

			//process shipping time
			$shippingTime = $_GET['shippingTime'];
			if($shippingTime){
				$finalurl .= "&itemFilter($i).name=MaxHandlingTime";
				$finalurl .="&itemFilter($i).value(0)=$shippingTime";
				$i++;
			}
			

			print $finalurl;
			
		}
	?>
</body>
</html>