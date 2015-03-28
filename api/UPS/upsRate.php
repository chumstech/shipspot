<?php
ini_set('display_errors',0);
class upsRate 
{
    var $AccessLicenseNumber;  
    var $UserId;  
    var $Password;
    var $shipperNumber;
    var $credentials;
	var $dimensionsUnits = "IN";
	var $weightUnits = "LBS";
	var $packingType;
	var $countryFrom;
	var $countryTo;

    function setCredentials($access,$user,$pass,$shipper,$postalCode,$dest_zip,$length,$width,$height,$weight,$pType,$countryFrom,$countryTo)
	 {
		/*echo($access." ".$user." ".$pass." ".$shipper." ".$postalCode." ".$dest_zip." ".$length." ".$width." ".$height." ".$weight." ".$pType);*/
		$this->AccessLicenseNumber = $access;
		$this->UserID = $user;
		$this->Password = $pass;	
		$this->shipperNumber = $shipper;
		$this->PostalCode = $postalCode; 
		$this->Dest_zip= $dest_zip; 
		$this->Length = $length; 
		$this->Width =$width ; 
		$this->Height = $height; 
		$this->Weight = $weight; 
		$this->PType = $pType;
		$this->countryFrom = $countryFrom;
		$this->countryTo = $countryTo; 
		$this->Services = array(
				"Next_Day_Air_(early_AM)"=>"14", 
				"Next_Day_Air"=>"01", 
				"Next_Day_Air_Saver"=>"13", 
				"2nd_Day_Air"=>"02", 
				"Ground"=>"03"
				);
		$this->credentials = 1;

			foreach($this->Services as $name => $value) // ship code /service_code
				{
				$rate = $this->getRate($value);
				if($rate)
				{
				if($value == "14")
				{
					$serviceName = "UPS Next Day Air (8.30 AM)";
					$serviceType = 1;
				}
				if($value == "01")
				{
					$serviceName = "UPS Next Day Air 10.30 AM";
					$serviceType = 1;
				}
				if($value == "13")
				{
					$serviceName = "UPS Next Day Air Saver(12.30 Noon)";
					$serviceType = 1;
				}
				if($value == "02")
				{
					$serviceName = "UPS 2nd Day Air";
					$serviceType = 2;
				}
				if($value == "03")
				{
					$serviceName = "UPS Ground";
					$serviceType = 3;
				}
				//var_dump($rate);
				//$_SESSION['ups_'.$value] = $rate;
				 $rateData[] = array("rate" => $rate, "name" => $serviceName, "serviceType" => $serviceType);
				//echo "<li>"."$name = ".'$ '."$rate"."<li>";
				}
				}
				return $rateData;
    }
	
	function setDimensionsUnits($unit){
		$this->dimensionsUnits = $unit;
	}
	
	function setWeightUnits($unit){
		$this->weightUnits = $unit;
	}

    // Define the function getRate() - no parameters
    function getRate($value) 
	{
	if ($this->credentials != 1) 
	{
		print 'Please set your credentials with the setCredentials function';
		die();
	}
	
	$data ="<?xml version=\"1.0\"?>  
		<AccessRequest xml:lang=\"en-US\">  
		    <AccessLicenseNumber>$this->AccessLicenseNumber</AccessLicenseNumber>  
		    <UserId>$this->UserID</UserId>  
		    <Password>$this->Password</Password>  
		</AccessRequest>  
		<?xml version=\"1.0\"?>  
		<RatingServiceSelectionRequest xml:lang=\"en-US\">  
		    <Request>  
			<TransactionReference>  
			    <CustomerContext>Bare Bones Rate Request</CustomerContext>  
			    <XpciVersion>1.0001</XpciVersion>  
			</TransactionReference>  
			<RequestAction>Rate</RequestAction>  
			<RequestOption>Rate</RequestOption>  
		    </Request>  
		<PickupType>  
		    <Code>01</Code>  
		</PickupType>  
		<Shipment>  
		    <Shipper>  
			<Address>  
			    <PostalCode>$this->PostalCode</PostalCode>  
			    <CountryCode>$this->countryFrom</CountryCode>  
			</Address>  
		    <ShipperNumber>$this->shipperNumber</ShipperNumber>  
		    </Shipper>  
		    <ShipTo>  
			<Address>  
			    <PostalCode>$this->Dest_zip</PostalCode>  
			    <CountryCode>$this->countryTo</CountryCode>  
			<ResidentialAddressIndicator/>  
			</Address>  
		    </ShipTo>  
		    <ShipFrom>  
			<Address>  
			    <PostalCode>$this->PostalCode</PostalCode>  
			    <CountryCode>$this->countryFrom</CountryCode>  
			</Address>  
		    </ShipFrom>  
		    <Service>  
			<Code>$value</Code>  
		    </Service>  
		    <Package>  
			<PackagingType>  
			    <Code>$this->PType</Code>  
			</PackagingType>  
			<Dimensions>  
			    <UnitOfMeasurement>  
				<Code>$this->dimensionsUnits</Code>  
			    </UnitOfMeasurement>  
			    <Length>$this->Length</Length>  
			    <Width>$this->Width</Width>  
			    <Height>$this->Height</Height>  
			</Dimensions>  
			<PackageWeight>  
			    <UnitOfMeasurement>  
				<Code>$this->weightUnits</Code>  
			    </UnitOfMeasurement>  
			    <Weight>$this->Weight</Weight>  
			</PackageWeight>  
		    </Package>  
		</Shipment>  
		</RatingServiceSelectionRequest>";  
		$ch = curl_init("https://www.ups.com/ups.app/xml/Rate");  
		curl_setopt($ch, CURLOPT_HEADER, 1);  
		curl_setopt($ch,CURLOPT_POST,1);  
		curl_setopt($ch,CURLOPT_TIMEOUT, 60);  
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);  
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data);  
		$result=curl_exec ($ch);
		//var_dump($result);
	    //echo  $result; // THIS LINE IS FOR DEBUG PURPOSES ONLY-IT WILL SHOW IN HTML COMMENTS  
		$data = strstr($result, '<?');  
		$xml_parser = xml_parser_create();  
		xml_parse_into_struct($xml_parser, $data, $vals, $index);  
		xml_parser_free($xml_parser);  
		$params = array();  
		$level = array();  
		foreach ($vals as $xml_elem) {  
		 if ($xml_elem['type'] == 'open') {  
		if (array_key_exists('attributes',$xml_elem)) {  
		     list($level[$xml_elem['level']],$extra) = array_values($xml_elem['attributes']);  
		} else {  
		     $level[$xml_elem['level']] = $xml_elem['tag'];  
		}  
		 }  
		 if ($xml_elem['type'] == 'complete') {  
		$start_level = 1;  
		$php_stmt = '$params';  
		while($start_level < $xml_elem['level']) {  
		     $php_stmt .= '[$level['.$start_level.']]';  
		     $start_level++;  
		}  
		$php_stmt .= '[$xml_elem[\'tag\']] = $xml_elem[\'value\'];';  
		eval($php_stmt);  
		 }  
		}
		curl_close($ch);
		$rate = $params['RATINGSERVICESELECTIONRESPONSE']['RATEDSHIPMENT']['TOTALCHARGES']['MONETARYVALUE']; 
		return $rate;  
	    }  
			
		}
		
///////////////////////////////////////////////////////////////
		
			
?>
