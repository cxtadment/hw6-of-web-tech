function resetsb(){

	document.getElementById("sbform").innerHTML="";
	document.getElementById("keywords").value="";
	document.getElementById("minPrice").value="";
	document.getElementById("maxPrice").value="";
	document.getElementById("newc").checked="";
	document.getElementById("usedc").checked="";
	document.getElementById("verygoodc").checked="";
	document.getElementById("goodc").checked="";
	document.getElementById("acceptc").checked="";
	document.getElementById("fixedPrice").checked="";
	document.getElementById("auction").checked="";
	document.getElementById("classified").checked="";
	document.getElementById("returnAccept").checked="";
	document.getElementById("freeShipping").checked="";
	document.getElementById("expedited").checked="";
	document.getElementById("shippingTime").value="";
	document.getElementById("bestMatch").selected="selected";
	document.getElementById("priceHighest").selected="";
	document.getElementById("priceShopHighest").selected="";
	document.getElementById("priceShopLowest").selected="";
	document.getElementById("p5").selected="selected";
	document.getElementById("p10").selected="";
	document.getElementById("p15").selected="";
	document.getElementById("p20").selected="";
	document.getElementById("noResult").innerHTML="";

}


function check(){
	//keywords validation
	keywords = document.getElementById("keywords").value;
	if(!keywords){
		alert("Please enter value for Key Words");
		return false;
	}

	//price range validation
	minPrice = document.getElementById("minPrice").value;
	maxPrice = document.getElementById("maxPrice").value;
	var re = /^[0-9]+([.]{1}[0-9]+){0,1}$/;
	if(minPrice){
		if(!re.test(minPrice)){
			alert("please type number for price range");
			return false;
		}
	}
	if(maxPrice){
		if(!re.test(maxPrice)){
			alert("please type number for price range");
			return false;
		}
	}
	if(minPrice&&maxPrice){
		if(maxPrice<minPrice){
			alert("The price range is invalid, maxPrice should greater than minPrice");
			return false;
		}
	}

	//shipping time validation
	shippingTime = document.getElementById("shippingTime").value;
	var re2 = /^[0-9]+$/;
	if(shippingTime){
		if(!re2.test(shippingTime)){
			alert("please type number for Max handling time");
			return false;
		}
	}

	return true;

}
