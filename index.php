<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>HW6</title>
	<link rel="stylesheet" type="text/css" href="hw6.css">
	<script type="text/javascript" src="hw6.js"></script> 
</head>

<body>
		<table class="outerborder">
		<tr>
			<td>
				<div class="title">
					<img src="http://cs-server.usc.edu:45678/hw/hw6/ebay.jpg" width="100" height="50">Shopping
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get" id="ebay" onsubmit="return check()">
				<table class="innerborder">
					<tr class="border_bottom">
						<td>Key Words*:</td>
						<td><input type="text" name="keywords" id="keywords" value="<?php echo $_GET['keywords']; ?>"></td>
					</tr>
					<tr class="border_bottom">
						<td>Price Range:</td>
						<td>from $<input type="text" name="minPrice" id="minPrice" value=<?php echo $_GET['minPrice'];?>>
								 to $<input type="text" name="maxPrice" id="maxPrice" value=<?php echo $_GET['maxPrice'];?>></td>
					</tr>
					<tr class="border_bottom">
						<td>Condition:</td>
						<td><input type="checkbox" name="conditions[]" value="1000" <?php foreach ($_GET['conditions'] as $val){if($val=='1000'){echo "checked='checked'";}}?>>New  
							   <input type="checkbox" name="conditions[]" value="3000" <?php foreach ($_GET['conditions'] as $val){if($val=='3000'){echo "checked='checked'";}}?>>Used 
							   <input type="checkbox" name="conditions[]" value="4000" <?php foreach ($_GET['conditions'] as $val){if($val=='4000'){echo "checked='checked'";}}?>>Very Good
							   <input type="checkbox" name="conditions[]" value="5000" <?php foreach ($_GET['conditions'] as $val){if($val=='5000'){echo "checked='checked'";}}?>>Good 
							   <input type="checkbox" name="conditions[]" value="6000" <?php foreach ($_GET['conditions'] as $val){if($val=='6000'){echo "checked='checked'";}}?>>Acceptable
						</td>
					</tr>
					<tr class="border_bottom">
						<td>Buying formats:</td>
						<td><input type="checkbox" name="listingTypes[]" value="FixedPrice" <?php foreach ($_GET['listingTypes'] as $val){if($val=='FixedPrice'){echo "checked='checked'";}}?>>Buy It Now
									<input type="checkbox" name="listingTypes[]" value="Auction" <?php foreach ($_GET['listingTypes'] as $val){if($val=='Auction'){echo "checked='checked'";}}?>>Auction
									<input type="checkbox" name="listingTypes[]" value="Classified" <?php foreach ($_GET['listingTypes'] as $val){if($val=='Classified'){echo "checked='checked'";}}?>>Classified Ads
						</td>
					</tr>
					<tr class="border_bottom">
						<td>Seller:</td>
						<td><input type="checkbox" name="returnAccept" value="true" <?php if($_GET['returnAccept']=='true'){echo "checked='checked'";}?>>Return accepted</td>
					</tr>
					<tr class="border_bottom">
						<td>Shipping:</td>
						<td><input type="checkbox" name="freeShipping" value="true" <?php if($_GET['freeShipping']=='true'){echo "checked='checked'";}?>>Free Shipping</td>
					</tr>
					<tr class="border_bottom">
						<td></td>
						<td><input type="checkbox" name="expeditedShipping" value="Expedited" <?php if($_GET['expeditedShipping']=='Expedited'){echo "checked='checked'";}?>>Expedited shipping available<br>
							Max handling time(days): <input type="text" name="shippingTime" id="shippingTime" value=<?php echo $_GET['shippingTime'];?>></td>
					</tr>
					<tr class="border_bottom">
						<td>Sorted by:</td>
						<td><select name="sortOrder">
									<option value="BestMatch" <?php if($_GET['sortOrder']){if($_GET['sortOrder']=='BestMatch'){echo "selected='selected'";}}else{echo "selected='selected'";}?>>Best Match</option>
									<option value="CurrentPriceHighest" <?php if($_GET['sortOrder']=='CurrentPriceHighest'){echo "selected='selected'";}?>>Price: highest first</option>
									<option value="PricePlusShippingHighest" <?php if($_GET['sortOrder']=='PricePlusShippingHighest'){echo "selected='selected'";}?>>Price + Shipping: highest first</option>
									<option value="PricePlusShippingLowest" <?php if($_GET['sortOrder']=='PricePlusShippingLowest'){echo "selected='selected'";}?>>Price + Shipping: lowest first</option>
							   </select>
						</td>
					</tr>
					<tr>
						<td>Result Per Page:</td>
						<td><select name="pagination">
										<option value="5"  <?php if($_GET['pagination']){if($_GET['pagination']=='5'){echo "selected='selected'";}}else{echo "selected='selected'";}?>>5</option>
										<option value="10" <?php if($_GET['pagination']=='10'){echo "selected='selected'";}?>>10</option>
										<option value="15" <?php if($_GET['pagination']=='15'){echo "selected='selected'";}?>>15</option>
										<option value="20" <?php if($_GET['pagination']=='20'){echo "selected='selected'";}?>>20</option>
									 </select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="right">
							<input type="button" name="clear" value="clear" onclick="reset()">
							<input type="submit" name="submit" value="search">
						</td>
					</tr>
			</table>
			</form>
			</td>
		</tr>
		<tr>
			<td><br><div id="noResult"></div></td>
		</tr>
	</table><br>
	
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

			//process Price Range
			$minPrice = $_GET['minPrice'];
			if($minPrice){
				$finalurl .= "&itemFilter($i).name=MinPrice";
				$finalurl .="&itemFilter($i).value(0)=$minPrice";
				$i++;
			}

			$maxPrice = $_GET['maxPrice'];
			if($maxPrice){
				$finalurl .= "&itemFilter($i).name=MaxPrice";
				$finalurl .="&itemFilter($i).value(0)=$maxPrice";
				$i++;
			}

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
			$expeditedShipping = $_GET['expeditedShipping'];
			if($expeditedShipping){
				$finalurl .= "&itemFilter($i).name=ExpeditedShippingType";
				$finalurl .="&itemFilter($i).value(0)=$expeditedShipping";
				$i++;
			}

			//process shipping time
			$shippingTime = $_GET['shippingTime'];
			if($shippingTime){
				$finalurl .= "&itemFilter($i).name=MaxHandlingTime";
				$finalurl .="&itemFilter($i).value(0)=$shippingTime";
				$i++;
			}

			//process sorted by
			$sortOrder = $_GET['sortOrder'];
			$finalurl .= "&sortOrder=$sortOrder";

			//process pagination
			$pagination = $_GET['pagination'];
			$finalurl .= "&paginationInput.entriesPerPage=$pagination";

			// print $finalurl;

			//load the call
			$loads = simplexml_load_file($finalurl);
			
			//check if the resp has been loaded and if there is items in the result
			if($loads && $loads->paginationOutput->totalEntries > 0){
				//table build
				$results .="<table class='resultOutBorder'>";
				$results .="<tr><td><div class='resultTitle'><b>".$loads->paginationOutput->totalEntries . " Results for <span style='font-style: italic'>".$keywords."</span></b></div></td></tr>";
				$results .= "<tr><td><table class='result'>";

				//traverse items
				foreach($loads->searchResult->item as $item){
					//process image
					if($item->galleryURL){
						$imageURL = $item->galleryURL;
					}else{
						$imageURL = "http://cs-server.usc.edu:45678/hw/hw6/ebay.jpg";
					}

					//receive all data
					$title = $item->title;
					$link = $item->viewItemURL;
					$conditionDisplay = $item->condition->conditionDisplayName;
					$topRated = $item->topRatedListing;
					$buyingFormateDisplay = $item->listingInfo->listingType;
					$returnAcceptDisplay = (($item->returnsAccepted)=='true')?'Seller Accepts return':'Seller doesn\'t accept return';
					$shippingCost = $item->shippingInfo->shippingServiceCost;
					$expeditedDisplay = (($item->shippingInfo->expeditedShipping)=='true')?'Expedited Shipping Available':'Expedited Shipping Not Available';
					$shippingTimeDisplay = $item->shippingInfo->handlingTime;
					$price = $item->sellingStatus->convertedCurrentPrice;
					$location = $item->location;
					$freeDisplay = ($shippingCost==0.0)?'FREE Shipping':'Shipping Not Free';

					//process BuyingFormat
					if($buyingFormateDisplay){
						switch ($buyingFormateDisplay) {
							case 'FixedPrice':
								$buyingFormateDisplay = 'Buy It Now';
								break;
							
							case 'StoreInventory':
								$buyingFormateDisplay = 'Buy It Now';
								break;

							case 'Auction':
								$buyingFormateDisplay = 'Auction';
								break;

							case 'Classified':
								$buyingFormateDisplay = 'Classified Ad';
								break;
						}
					}


					$results .= "<tr class='border_bottom'>
									<td>
									<div id = 'leftDisplay'><img width='178px' height='178px' src=$imageURL></div>
									<div id = 'rightDisplay'>
										<a href=$link>$title</a><br><br>
										<b>Condition:</b> $conditionDisplay ";
										if($topRated=='true'){
											$results .= "<img src='http://cs-server.usc.edu:45678/hw/hw6/itemTopRated.jpg' height='50' width='40'>";
										}
					$results .= "        <br><br>
										<b>$buyingFormateDisplay</b><br><br>
										$returnAcceptDisplay<br>
										$freeDisplay -- $expeditedDisplay -- Handled for shipping in $shippingTimeDisplay day(s)<br><br>
										<b>Price: $$price </b>";
										if($shippingCost>0){
											$results .= "<b>(+$$shippingCost for shipping)</b> ";
										}
					$results .="		<span style='font-style: italic'>From $location</span>
									</div>
									</td>
								</tr>";


				}

				$results .= "</table></td></tr></table>";
			}else{
				echo "<script type='text/javascript'>document.getElementById('noResult').innerHTML='<h2><b>No results found</b></h2>';</script>";
			}
		}

		echo $results;
	?>
</body>
</html>