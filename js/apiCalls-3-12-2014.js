function getRates()
{       
    console.log('Fetching rates');
	$('#loading-image').show();
	$('.mainRecords').show();
	
	//console.log('Fetching rates from Canada Post API');
	
			$(".firstBox ul li.canada").remove();
			$(".secondBox ul li.canada").remove();
			$(".thirdBox ul li.canada").remove();
			
			$(".firstBox ul li.ups").remove();
			$(".secondBox ul li.ups").remove();
			$(".thirdBox ul li.ups").remove();
			
			$(".firstBox ul li.pur").remove();
			$(".secondBox ul li.pur").remove();
			$(".thirdBox ul li.pur").remove();
			
			$(".firstBox ul li.fedex").remove();
			$(".secondBox ul li.fedex").remove();
			$(".thirdBox ul li.fedex").remove();
			
			$(".firstBox ul li.tnt").remove();
			$(".secondBox ul li.tnt").remove();
			$(".thirdBox ul li.tnt").remove();
	
	var txt_from = $('#txt_from').val();
	var txt_to = $('#txt_to').val();
	var txt_weight = $('#txt_weight').val();
	var txt_length = $('#txt_length').val();
	var txt_width = $('#txt_width').val();
	var txt_height = $('#txt_height').val();
	var ship_type = $('input[name="ship_type"]:checked').val();
	var ship_mode = $('input[name="ship_mode"]:checked').val();
	
	if(ship_mode == 'int')
	{
		var countryFrom = $('#countryFrom').val();
		var countryTo = $('#countryTo').val();
	}
	else
	{
		var countryFrom = 'CA';
		var countryTo = 'CA';
	}
	
	var check_canada = $('#checkCanada').val();
	var check_fedex = $('#checkFedex').val();
	var check_puro = $('#checkPur').val();
	var check_ups = $('#checkUps').val();
	var check_tnt = $('#checkTnt').val();
	var check_dhl = $('#check_dhl').val();
	var loginType = $('#loginType').val();
	
	if(txt_weight == '')
	{
		txt_weight = 1;
	}
	if(txt_length == '')
	{
		txt_length = 1;
	}
	if(txt_height == '')
	{
		txt_height = 1;
	}
	if(txt_width == '')
	{
		txt_width = 1;
	}
  
	if(loginType == 'admin')
	{
		if($('#check_canada').is(":checked") || $('#check_fedex').is(":checked") || $('#check_ups').is(":checked") || $('#check_puro').is(":checked") || $('#check_tnt').is(":checked") || $('#check_tnt').is(":checked"))
		{
			if($('#check_canada').is(":checked"))
			{
				getCanadaPostRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, countryFrom, countryTo);
			}
			if($('#check_fedex').is(":checked"))
			{
				getFedexRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, countryFrom, countryTo);	
			}
			if($('#check_ups').is(":checked"))
			{
				getUpsRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, ship_type, countryFrom, countryTo);	
			}
			if($('#check_puro').is(":checked"))
			{
				getPurlatorRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, countryFrom, countryTo);
			}
			if($('#check_tnt').is(":checked"))
			{
				getTnTRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, countryFrom, countryTo);
			}	
		}
		else
		{
			$('.mainRecords').hide();
			$('#loading-image').hide();
			alert("Please select Carriers First!");	
		}
	}
	else
	{
			if(check_canada == 1)
			{
				getCanadaPostRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, countryFrom, countryTo);
			}
			if(check_fedex == 1)
			{
				getFedexRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, countryFrom, countryTo);	
			}
			if(check_ups == 1)
			{
				getUpsRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, ship_type, countryFrom, countryTo);	
			}
			if(check_puro == 1)
			{
				getPurlatorRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, countryFrom, countryTo);
			}
			if(check_tnt == 1)
			{
				getTnTRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, countryFrom, countryTo);
			}	
	}
	
}

function getCanadaPostRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, countryFrom, countryTo)
{       
	console.log('Fetching rates from Canada Post API');
		
    var data = {
        "txt_from"  : txt_from,
        "txt_to" : txt_to,
        "txt_weight" : txt_weight,
        "txt_length" : txt_length,
        "txt_width"  : txt_width,
		"txt_height" : txt_height,
		"countryFrom" : countryFrom, 
		"countryTo" : countryTo
    };
	//console.log(data);
	$.ajax({
        url:"http://localhost/shipping/api/canada.php",
        type: "GET",
        dataType: "jsonp",
		data: data,
        jsonp : "callback",
        success:function(data)
        {
			var html = '';
			//console.log(data);
			var firsthtml  = '';
			var secondhtml = '';
			var thirdhtml  = '';
			$.each(data, function(index, value) {
			Rtype = value.canType;
			if(Rtype == 1)
			{
			firsthtml += '<li class="canada"><span class="service Canada">'+value.canName+'</span><span class="rate">'+value.canRate+'</span><span class="discount">'+value.canDiscount+'</span><span class="date">'+value.canDelivery+'</span></li>';
			}
			else if(Rtype == 2)
			{
			secondhtml += '<li class="canada"><span class="service Canada">'+value.canName+'</span><span class="rate">'+value.canRate+'</span><span class="discount">'+value.canDiscount+'</span><span class="date">'+value.canDelivery+'</span></li>';	
			}
			else if(Rtype == 3)
			{
			thirdhtml += '<li class="canada"><span class="service Canada">'+value.canName+'</span><span class="rate">'+value.canRate+'</span><span class="discount">'+value.canDiscount+'</span><span class="date">'+value.canDelivery+'</span></li>';	
			}
			});
			
			$(".firstBox ul li.canada").remove();
			$(".secondBox ul li.canada").remove();
			$(".thirdBox ul li.canada").remove();
			
			$(".firstBox ul").append(firsthtml);
			$(".secondBox ul").append(secondhtml);
			$(".thirdBox ul").append(thirdhtml);
			
			$('#loading-image').hide();
			
        },
        error:function(){
			$('#loading-image').hide();         	
        	console.log('Error: There is some error please try again.'); 
           
        }
    }); 
}

function getFedexRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, countryFrom, countryTo)
{       
	console.log('Fetching rates from Fedex API');
		
    var data = {
        "txt_from"  : txt_from,
        "txt_to" : txt_to,
        "txt_weight" : txt_weight,
        "txt_length" : txt_length,
        "txt_width"  : txt_width,
		"txt_height" :txt_height,
		"countryFrom" : countryFrom, 
		"countryTo" : countryTo
    };
	console.log(data);
	$.ajax({
        url:"http://localhost/shipping/api/fedex.php",
        type: "GET",
        dataType: "jsonp",
		data: data,
        jsonp : "callback",
        success:function(data)
        {
			var html = '';
			//console.log(data);
			var firsthtml  = '';
			var secondhtml = '';
			var thirdhtml  = '';
			$.each(data, function(index, value) {
			Rtype = value.canType;
			if(Rtype == 1)
			{
			firsthtml += '<li class="fedex"><span class="service Fedex">'+value.canName+'</span><span class="rate">'+value.canRate+'</span><span class="discount">'+value.canDiscount+'</span><span class="date">'+value.canDelivery+'</span></li>';
			}
			else if(Rtype == 2)
			{
			secondhtml += '<li class="fedex"><span class="service Fedex">'+value.canName+'</span><span class="rate">'+value.canRate+'</span><span class="discount">'+value.canDiscount+'</span><span class="date">'+value.canDelivery+'</span></li>';	
			}
			else if(Rtype == 3)
			{
			thirdhtml += '<li class="fedex"><span class="service Fedex">'+value.canName+'</span><span class="rate">'+value.canRate+'</span><span class="discount">'+value.canDiscount+'</span><span class="date">'+value.canDelivery+'</span></li>';	
			}
			});
			
			$(".firstBox ul li.fedex").remove();
			$(".secondBox ul li.fedex").remove();
			$(".thirdBox ul li.fedex").remove();
			
			$(".firstBox ul").append(firsthtml);
			$(".secondBox ul").append(secondhtml);
			$(".thirdBox ul").append(thirdhtml);
			
			$('#loading-image').hide();
        },
        error:function(){
			$('#loading-image').hide();         	
        	console.log('Error: There is some error please try again.'); 
           
        }
    }); 
}

function getUpsRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, ship_type, countryFrom, countryTo)
{       
	console.log('Fetching rates from UPS API');
		
    var data = {
        "txt_from"  : txt_from,
        "txt_to" : txt_to,
        "txt_weight" : txt_weight,
        "txt_length" : txt_length,
        "txt_width"  : txt_width,
		"txt_height" :txt_height,
		"ship_type" : ship_type,
		"countryFrom" : countryFrom, 
		"countryTo" : countryTo
    };
	//console.log(data);
	$.ajax({
        url:"http://localhost/shipping/api/ups.php",
        type: "GET",
        dataType: "jsonp",
		data: data,
        jsonp : "callback",
        success:function(data)
        {
			var html = '';
			//console.log(data);
			var firsthtml  = '';
			var secondhtml = '';
			var thirdhtml  = '';
			$.each(data, function(index, value) {
			Rtype = value.canType;
			if(Rtype == 1)
			{
			firsthtml += '<li class="ups"><span class="service UPS">'+value.canName+'</span><span class="rate">'+value.canRate+'</span><span class="discount">'+value.canDiscount+'</span><span class="date"></span></li>';
			}
			else if(Rtype == 2)
			{
			secondhtml += '<li class="ups"><span class="service UPS">'+value.canName+'</span><span class="rate">'+value.canRate+'</span><span class="discount">'+value.canDiscount+'</span><span class="date"></span></li>';	
			}
			else if(Rtype == 3)
			{
			thirdhtml += '<li class="ups"><span class="service UPS">'+value.canName+'</span><span class="rate">'+value.canRate+'</span><span class="discount">'+value.canDiscount+'</span><span class="date"></span></li>';	
			}
			});
			
			$(".firstBox ul li.ups").remove();
			$(".secondBox ul li.ups").remove();
			$(".thirdBox ul li.ups").remove();
			
			$(".firstBox ul").append(firsthtml);
			$(".secondBox ul").append(secondhtml);
			$(".thirdBox ul").append(thirdhtml);
			
			$('#loading-image').hide();
        },
        error:function(){
			$('#loading-image').hide();         	
        	console.log('Error: There is some error please try again.'); 
           
        }
    }); 
}

function getPurlatorRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, countryFrom, countryTo)
{       
	console.log('Fetching rates from UPS API');
		
    var data = {
        "txt_from"  : txt_from,
        "txt_to" : txt_to,
        "txt_weight" : txt_weight,
        "txt_length" : txt_length,
        "txt_width"  : txt_width,
		"txt_height" :txt_height,
		"countryFrom" : countryFrom, 
		"countryTo" : countryTo
    };
	//console.log(data);
	$.ajax({
        url:"http://localhost/shipping/api/pur.php",
        type: "GET",
        dataType: "jsonp",
		data: data,
        jsonp : "callback",
        success:function(data)
        {
			var html = '';
			//console.log(data);
			var firsthtml  = '';
			var secondhtml = '';
			var thirdhtml  = '';
			$.each(data, function(index, value) {
			Rtype = value.canType;
			if(Rtype == 1)
			{
			firsthtml += '<li class="pur"><span class="service Purolator">'+value.canName+'</span><span class="rate">'+value.canRate+'</span><span class="discount">'+value.canDiscount+'</span><span class="date">'+value.canDelivery+'</span></li>';
			}
			else if(Rtype == 2)
			{
			secondhtml += '<li class="pur"><span class="service Purolator">'+value.canName+'</span><span class="rate">'+value.canRate+'</span><span class="discount">'+value.canDiscount+'</span><span class="date">'+value.canDelivery+'</span></li>';	
			}
			else if(Rtype == 3)
			{
			thirdhtml += '<li class="pur"><span class="service Purolator">'+value.canName+'</span><span class="rate">'+value.canRate+'</span><span class="discount">'+value.canDiscount+'</span><span class="date">'+value.canDelivery+'</span></li>';	
			}
			});
			
			$(".firstBox ul li.pur").remove();
			$(".secondBox ul li.pur").remove();
			$(".thirdBox ul li.pur").remove();
			
			$(".firstBox ul").append(firsthtml);
			$(".secondBox ul").append(secondhtml);
			$(".thirdBox ul").append(thirdhtml);
			
			$('#loading-image').hide();
        },
        error:function(){
			$('#loading-image').hide();         	
        	console.log('Error: There is some error please try again.'); 
           
        }
    }); 
}

function getTnTRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, countryFrom, countryTo)
{       
	console.log('Fetching rates from UPS API');
		
    var data = {
        "txt_from"  : txt_from,
        "txt_to" : txt_to,
        "txt_weight" : txt_weight,
        "txt_length" : txt_length,
        "txt_width"  : txt_width,
		"txt_height" :txt_height,
		"countryFrom" : countryFrom, 
		"countryTo" : countryTo
    };
	//console.log(data);
	$.ajax({
        url:"http://localhost/shipping/api/tnt.php",
        type: "GET",
        dataType: "jsonp",
		data: data,
        jsonp : "callback",
        success:function(data)
        {
			var html = '';
			//console.log(data);
			var firsthtml  = '';
			var secondhtml = '';
			var thirdhtml  = '';
			$.each(data, function(index, value) {
			Rtype = value.canType;
			console.log(value.canRate[0]);
			if(Rtype == 1)
			{
			firsthtml += '<li class="tnt"><span class="service TnT">'+value.canName+'</span><span class="rate">'+value.canRate[0]+'</span><span class="discount">'+value.canDiscount+'</span><span class="date"></span></li>';
			}
			else if(Rtype == 2)
			{
			secondhtml += '<li class="tnt"><span class="service TnT">'+value.canName+'</span><span class="rate">'+value.canRate[0]+'</span><span class="discount">'+value.canDiscount+'</span><span class="date"></span></li>';	
			}
			else if(Rtype == 3)
			{
			thirdhtml += '<li class="tnt"><span class="service TnT">'+value.canName+'</span><span class="rate">'+value.canRate[0]+'</span><span class="discount">'+value.canDiscount+'</span><span class="date"></span></li>';	
			}
			});
			
			$(".firstBox ul li.tnt").remove();
			$(".secondBox ul li.tnt").remove();
			$(".thirdBox ul li.tnt").remove();

			
			$(".firstBox ul").append(firsthtml);
			$(".secondBox ul").append(secondhtml);
			$(".thirdBox ul").append(thirdhtml);
			
			$('#loading-image').hide();
        },
        error:function(){ 
			$('#loading-image').hide();       	
        	console.log('Error: There is some error please try again.'); 
           
        }
    }); 
}// JavaScript Document
$(document).ready(function(){
	$(".ship_mode").change(function () {
	$(".cDrop").toggle();
})
})
