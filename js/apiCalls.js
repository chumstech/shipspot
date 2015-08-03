<<<<<<< HEAD
//var appBaseURL = document.location.protocol + '//localhost/shipping/';
var appBaseURL = document.location.protocol + '//96.126.101.70/shipping_new';
=======
//var appBaseURL = document.location.protocol + '//96.126.101.70/';
//var appBaseURL = document.location.protocol + '//96.126.101.70/shipping_new';
//var appBaseURL = document.location.protocol + '//localhost/shipspot/'
>>>>>>> 32b34a49b603c58006c6ab92e43dc97a8208b56e
function updateUserSelectedCarriers()
{
	var dataArry = [];
	$('.selectedCarriers').each(function(index,value){
		if($(value).is(':checked')){
			dataArry.push($(value).attr('carrier_selected_id'));
		}	
	});
	$.ajax({
        url:appBaseURL+"/controls/carrier.php",
        type: "POST",
        dataType: "jsonp",
		data: {cerrier_id : dataArry , uId : $('#star_user_id').val()},
        jsonp : "callback",
        success:function(data){
		},
		 error:function(){
			//$('#loading-image').hide();         	
        	console.log('Error: There is some error please try again.'); 
           
        }
		
	});
}

function getRates()
{       
    console.log('Fetching rates');
	//$('#loading-image').show();
	$('.loadingList').html('');
	$('.mainRecords').show();
	
	//console.log('Fetching rates from Canada Post API');
			//$(".firstBox table").find("tr:gt(0)").remove();
			/*$(".firstBox table tr.canada").remove();
			$(".secondBox table tr.canada").remove();
			$(".thirdBox table tr.canada").remove();*/
			
			$(".firstBox tbody tr.canada").remove();
			$(".secondBox tbody tr.canada").remove();
			$(".thirdBox tbody tr.canada").remove();
			
			$(".firstBox table tr.ups").remove();
			$(".secondBox table tr.ups").remove();
			$(".thirdBox table tr.ups").remove();
			
			$(".firstBox table tr.pur").remove();
			$(".secondBox table tr.pur").remove();
			$(".thirdBox table tr.pur").remove();
			
			$(".firstBox table tr.fedex").remove();
			$(".secondBox table tr.fedex").remove();
			$(".thirdBox table tr.fedex").remove();
			
			$(".firstBox table tr.tnt").remove();
			$(".secondBox table tr.tnt").remove();
			$(".thirdBox table tr.tnt").remove();
	
	var txt_from = $('#txt_from').val();
	var txt_to = $('#txt_to').val();
	var txt_weight = $('#txt_weight').val();
	var txt_length = $('#txt_length').val();
	var txt_width = $('#txt_width').val();
	var txt_height = $('#txt_height').val();
	var ship_type = $('input[name="ship_type"]:checked').val();
	var ship_mode = $('input[name="ship_mode"]:checked').val();
	var show_disc = $('input[name="show_disc"]:checked').val();
	
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
  
	if(loginType ==  2)
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
	//console.log("==========ALL DONE========");
	setTimeout(function(){ $('#loading-image').hide(); }, 2000);
}

function getCanadaPostRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, countryFrom, countryTo)
{   
	var loadingCanada = '<div class="item loadingCanada"><img src="images/loading.gif" />Loading Canda Post Rates</div>';
	$('.loadingList').append(loadingCanada);    
	console.log('Fetching rates from Canada Post API');
	var show_disc = $('input[name="show_disc"]:checked').val();	
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
	var Posted_Rate_Flag = $('#checkPostRates').val();
	var checkDiscountRates = $('#checkDiscountRates').val();
	$.ajax({
        url:appBaseURL+"/api/canada.php",
        type: "GET",
        dataType: "jsonp",
		data: data,
        jsonp : "callback",
        success:function(data)
        {
			$('.loadingCanada').html('Canada Post Rates Fetched');
			setTimeout(function(){ $('.loadingCanada').fadeOut(); }, 5000);
			var html = '';
			console.log(data);
			var firsthtml  = '';
			var secondhtml = '';
			var thirdhtml  = '';
			$.each(data, function(index, value) {
			Rtype = value.canType;
			if(Rtype == 1)
			{
			firsthtml += '<tr class="canada"><td class="service Canada">'+value.canName+'</td><td class="rate">'+value.canRate+'</td><td class="discount">'+value.canDiscount+'</td><td class="date">'+value.canDelivery+'</td></tr>';
			}
			else if(Rtype == 2)
			{
			secondhtml += '<tr class="canada"><td class="service Canada">'+value.canName+'</td><td class="rate">'+value.canRate+'</td><td class="discount">'+value.canDiscount+'</td><td class="date">'+value.canDelivery+'</td></tr>';	
			}
			else if(Rtype == 3)
			{
			thirdhtml += '<tr class="canada"><td class="service Canada">'+value.canName+'</td><td class="rate">'+value.canRate+'</td><td class="discount">'+value.canDiscount+'</td><td class="date">'+value.canDelivery+'</td></tr>';	
			}
			});
			
			$(".firstBox table tbody").append(firsthtml);
			$(".secondBox table tbody").append(secondhtml);
			$(".thirdBox table tbody").append(thirdhtml);
			
			$("table").trigger("update"); 
            var sorting = [[1,0]]; 
            $("table").trigger("sorton",[sorting]); 
			
			
			
			if(Posted_Rate_Flag != 1)
			{
				$('td.rate').hide();
				$('th.rate').hide();
			}
			if(checkDiscountRates != 1)
			{
				$('td.discount').hide();
				$('th.discount').hide();
			}
			
			if(show_disc != 1)
			{
				$('td.discount').hide();
				$('th.discount').hide();
			}
			
        },
        error:function(){
			//$('#loading-image').hide();
			$('.loadingCanada').html('Error Fetching Canada Post Rates.');
			setTimeout(function(){ $('.loadingCanada').fadeOut(); }, 5000);      	
        	console.log('Error: There is some error please try again.'); 
           
        }
    }); 
		
}

function getFedexRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, countryFrom, countryTo)
{  
	var loadingFedex = '<div class="item loadingFedex"><img src="images/loading.gif" />Loading Fedex Rates</div>';
	$('.loadingList').append(loadingFedex);     
	console.log('Fetching rates from Fedex API');
	var show_disc = $('input[name="show_disc"]:checked').val();		
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
	var Posted_Rate_Flag = $('#checkPostRates').val();
	var checkDiscountRates = $('#checkDiscountRates').val();	
	$.ajax({
        url:appBaseURL+"/api/fedex.php",
        type: "GET",
        dataType: "jsonp",
		data: data,
        jsonp : "callback",
        success:function(data)
        {
			$('.loadingFedex').html('Fedex Rates Fetched');
			setTimeout(function(){ $('.loadingFedex').fadeOut(); }, 5000);
			var html = '';
			console.log(data);
			var firsthtml  = '';
			var secondhtml = '';
			var thirdhtml  = '';
			$.each(data, function(index, value) {
			Rtype = value.canType;
			if(Rtype == 1)
			{
			firsthtml += '<tr class="fedex"><td class="service Fedex">'+value.canName+'</td><td class="rate">'+value.canRate+'</td><td class="discount">'+value.canDiscount+'</td><td class="date">'+value.canDelivery+'</td></tr>';
			}
			else if(Rtype == 2)
			{
			secondhtml += '<tr class="fedex"><td class="service Fedex">'+value.canName+'</td><td class="rate">'+value.canRate+'</td><td class="discount">'+value.canDiscount+'</td><td class="date">'+value.canDelivery+'</td></tr>';	
			}
			else if(Rtype == 3)
			{
			thirdhtml += '<tr class="fedex"><td class="service Fedex">'+value.canName+'</td><td class="rate">'+value.canRate+'</td><td class="discount">'+value.canDiscount+'</td><td class="date">'+value.canDelivery+'</td></tr>';	
			}
			});
			
			$(".firstBox table tbody").append(firsthtml);
			$(".secondBox table tbody").append(secondhtml);
			$(".thirdBox table tbody").append(thirdhtml);
			
			$("table").trigger("update"); 
            var sorting = [[1,0]]; 
            $("table").trigger("sorton",[sorting]); 
			
			if(Posted_Rate_Flag != 1)
			{
				$('td.rate').hide();
				$('th.rate').hide();
			}
			if(checkDiscountRates != 1)
			{
				$('td.discount').hide();
				$('th.discount').hide();
			}
			if(show_disc != 1)
			{
				$('td.discount').hide();
				$('th.discount').hide();
			}
        },
        error:function(){
			//$('#loading-image').hide();
			$('.loadingFedex').html('Error Fetching Fedex Rates.');
			setTimeout(function(){ $('.loadingFedex').fadeOut(); }, 5000);          	
        	console.log('Error: There is some error please try again.'); 
           
        }
    }); 
}

function getUpsRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, ship_type, countryFrom, countryTo)
{    
	var loadingUps = '<div class="item loadingUps"><img src="images/loading.gif" />Loading UPS Rates</div>';
	$('.loadingList').append(loadingUps);   
	console.log('Fetching rates from UPS API');
	var show_disc = $('input[name="show_disc"]:checked').val();		
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
	var Posted_Rate_Flag = $('#checkPostRates').val();
	var checkDiscountRates = $('#checkDiscountRates').val();
	$.ajax({
        url:appBaseURL+"/api/ups.php",
        type: "GET",
        dataType: "jsonp",
		data: data,
        jsonp : "callback",
        success:function(data)
        {
			$('.loadingUps').html('UPS Rates Fetched');
			setTimeout(function(){ $('.loadingUps').fadeOut(); }, 5000);
			var html = '';
			//console.log(data);
			var firsthtml  = '';
			var secondhtml = '';
			var thirdhtml  = '';
			$.each(data, function(index, value) {
			Rtype = value.canType;
			if(Rtype == 1)
			{
			firsthtml += '<tr class="ups"><td class="service UPS">'+value.canName+'</td><td class="rate">'+value.canRate+'</td><td class="discount">'+value.canDiscount+'</td><td class="date"></td></tr>';
			}
			else if(Rtype == 2)
			{
			secondhtml += '<tr class="ups"><td class="service UPS">'+value.canName+'</td><td class="rate">'+value.canRate+'</td><td class="discount">'+value.canDiscount+'</td><td class="date"></td></tr>';	
			}
			else if(Rtype == 3)
			{
			thirdhtml += '<tr class="ups"><td class="service UPS">'+value.canName+'</td><td class="rate">'+value.canRate+'</td><td class="discount">'+value.canDiscount+'</td><td class="date"></td></tr>';	
			}
			});
			
			$(".firstBox table tbody").append(firsthtml);
			$(".secondBox table tbody").append(secondhtml);
			$(".thirdBox table tbody").append(thirdhtml);
			
			$("table").trigger("update"); 
            var sorting = [[1,0]]; 
            $("table").trigger("sorton",[sorting]); 
			
			if(Posted_Rate_Flag != 1)
			{
				$('td.rate').hide();
				$('th.rate').hide();
			}
			if(checkDiscountRates != 1)
			{
				$('td.discount').hide();
				$('th.discount').hide();
			}
			if(show_disc != 1)
			{
				$('td.discount').hide();
				$('th.discount').hide();
			}
        },
        error:function(){
			//$('#loading-image').hide();      
			$('.loadingUps').html('Error Fetching UPS Rates.');
			setTimeout(function(){ $('.loadingUps').fadeOut(); }, 5000);   	
        	console.log('Error: There is some error please try again.'); 
           
        }
    }); 
}

function getPurlatorRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, countryFrom, countryTo)
{   
	var loadingPurolator = '<div class="item loadingPurolator"><img src="images/loading.gif" />Loading Purolator Rates</div>';
	$('.loadingList').append(loadingPurolator);    
	console.log('Fetching rates from UPS API');
		var show_disc = $('input[name="show_disc"]:checked').val();	
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
	var Posted_Rate_Flag = $('#checkPostRates').val();
	var checkDiscountRates = $('#checkDiscountRates').val();
	$.ajax({
        url:appBaseURL+"/api/pur.php",
        type: "GET",
        dataType: "jsonp",
		data: data,
        jsonp : "callback",
        success:function(data)
        {
			$('.loadingPurolator').html('Purolator Rates Fetched.');
			setTimeout(function(){ $('.loadingPurolator').fadeOut(); }, 5000);
			var html = '';
			//console.log(data);
			var firsthtml  = '';
			var secondhtml = '';
			var thirdhtml  = '';
			$.each(data, function(index, value) {
			Rtype = value.canType;
			if(Rtype == 1)
			{
			firsthtml += '<tr class="pur"><td class="service Purolator">'+value.canName+'</td><td class="rate">'+value.canRate+'</td><td class="discount">'+value.canDiscount+'</td><td class="date">'+value.canDelivery+'</td></tr>';
			}
			else if(Rtype == 2)
			{
			secondhtml += '<tr class="pur"><td class="service Purolator">'+value.canName+'</td><td class="rate">'+value.canRate+'</td><td class="discount">'+value.canDiscount+'</td><td class="date">'+value.canDelivery+'</td></tr>';	
			}
			else if(Rtype == 3)
			{
			thirdhtml += '<tr class="pur"><td class="service Purolator">'+value.canName+'</td><td class="rate">'+value.canRate+'</td><td class="discount">'+value.canDiscount+'</td><td class="date">'+value.canDelivery+'</td></tr>';	
			}
			});
			
			$(".firstBox table tbody").append(firsthtml);
			$(".secondBox table tbody").append(secondhtml);
			$(".thirdBox table tbody").append(thirdhtml);
			
			$("table").trigger("update"); 
            var sorting = [[1,0]]; 
            $("table").trigger("sorton",[sorting]);  
			
			if(Posted_Rate_Flag != 1)
			{
				$('td.rate').hide();
				$('th.rate').hide();
			}
			if(checkDiscountRates != 1)
			{
				$('td.discount').hide();
				$('th.discount').hide();
			}
			if(show_disc != 1)
			{
				$('td.discount').hide();
				$('th.discount').hide();
			}
        },
        error:function(){
			//$('#loading-image').hide();
			$('.loadingPurolator').html('Error Fetching Purolator Rates.');
			setTimeout(function(){ $('.loadingPurolator').fadeOut(); }, 5000);         	
        	console.log('Error: There is some error please try again.'); 
           
        }
    }); 
}

function getTnTRates(txt_from, txt_to, txt_weight, txt_length, txt_width, txt_height, countryFrom, countryTo)
{ 
	var loadingTnt = '<div class="item loadingTnt"><img src="images/loading.gif" />Loading TNT Rates</div>';
	$('.loadingList').append(loadingTnt);     
	console.log('Fetching rates from UPS API');
	var show_disc = $('input[name="show_disc"]:checked').val();		
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
	var Posted_Rate_Flag = $('#checkPostRates').val();
	var checkDiscountRates = $('#checkDiscountRates').val();
	$.ajax({
        url:appBaseURL+"/api/tnt.php",
        type: "GET",
        dataType: "jsonp",
		data: data,
        jsonp : "callback",
        success:function(data)
        {
			$('.loadingTnt').html('TNT Rates Fetched.');
			setTimeout(function(){ $('.loadingTnt').fadeOut(); }, 5000);
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
			firsthtml += '<tr class="tnt"><td class="service TnT">'+value.canName+'</td><td class="rate">'+value.canRate[0]+'</td><td class="discount">'+value.canDiscount+'</td><td class="date"></td></tr>';
			}
			else if(Rtype == 2)
			{
			secondhtml += '<tr class="tnt"><td class="service TnT">'+value.canName+'</td><td class="rate">'+value.canRate[0]+'</td><td class="discount">'+value.canDiscount+'</td><td class="date"></td></tr>';	
			}
			else if(Rtype == 3)
			{
			thirdhtml += '<tr class="tnt"><td class="service TnT">'+value.canName+'</td><td class="rate">'+value.canRate[0]+'</td><td class="discount">'+value.canDiscount+'</td><td class="date"></td></tr>';	
			}
			});
			
			$(".firstBox table tbody").append(firsthtml);
			$(".secondBox table tbody").append(secondhtml);
			$(".thirdBox table tbody").append(thirdhtml);
			
			$("table").trigger("update"); 
            var sorting = [[1,0]]; 
            $("table").trigger("sorton",[sorting]); 
			
			if(Posted_Rate_Flag != 1)
			{
				$('td.rate').hide();
				$('th.rate').hide();
			}
			if(checkDiscountRates != 1)
			{
				$('td.discount').hide();
				$('th.discount').hide();
			}
			if(show_disc != 1)
			{
				$('td.discount').hide();
				$('th.discount').hide();
			}
        },
        error:function(){ 
			//$('#loading-image').hide();    
			$('.loadingTnt').html('Error Fetching TNT Rates.');
			setTimeout(function(){ $('.loadingTnt').fadeOut(); }, 5000);   	
        	console.log('Error: There is some error please try again.'); 
           
        }
    }); 
}// JavaScript Document
$(document).ready(function(){
	$(".ship_mode").change(function () {
	$(".cDrop").toggle();
})
})
