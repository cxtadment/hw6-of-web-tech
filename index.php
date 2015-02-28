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
			$keywords = $_GET['keywords'];
			$finalurl = "$basicurl"."&Keywords=$keywords";

			$conditions = $_GET['conditions'];
			foreach ($conditions as $condition){
				$finalurl .="&Condition=$condition";
			}

			

			print $finalurl;
			
		}
	?>
</body>
</html>