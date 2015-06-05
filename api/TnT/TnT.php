<?php
/*ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);
ini_set('error_log','script_errors.log');
ini_set('log_errors','On');*/

class tnt
{
 	function sendToTNTServer($Xml)
	 {
		$postdata = http_build_query(array('xml_in' => $Xml));
		$opts = array('http' =>
					array(
					   'method'  => 'POST',
					   'header'  => 'Content-type: application/x-www-form-urlencoded',
					   'content' => $postdata
					 )
				 );
	
		$context  = stream_context_create( $opts );
		$output = @file_get_contents( 
			   'https://express.tnt.com/expressconnect/pricing/getprice', 
			   false, 
			   $context 
			 );
			 return $output;
    } 
	///////////////////////////

	//function setCredentials($admin_col1_tnt,$admin_col2_tnt,$admin_col3_tnt,$weight,$height,$width,$length,$from,$to)

	function setCredentials($admin_col1_tnt,$admin_col2_tnt,$admin_col3_tnt,$length,$width,$height,$weight,$from,$to,$countryFrom,$countryTo)
	{
	
	$XmlString = "<?xml version='1.0' standalone='no'?><!DOCTYPE PRICEREQUEST SYSTEM
'http://164.39.41.88:81/PriceCheckerDTD1.0/PriceRequestIN.dtd'> 
                  <PRICEREQUEST> 
                       <LOGIN> 
                           <COMPANY>$admin_col1_tnt</COMPANY> 
                           <PASSWORD>$admin_col2_tnt</PASSWORD> 
                           <APPID>$admin_col3_tnt</APPID> 
                       </LOGIN>
					   <DATASETS>
							<COUNTRY>1.0</COUNTRY>
							<CURRENCY>1.0</CURRENCY>
							<POSTCODEMASK>1.0</POSTCODEMASK>
							<TOWNGROUP>1.0</TOWNGROUP>
							<SERVICE>1.0</SERVICE>
							<OPTION>1.0</OPTION>
						</DATASETS>
                       <PRICECHECK> 
                         <RATEID>RATE1</RATEID> 
                         <ORIGINCOUNTRY>$countryFrom</ORIGINCOUNTRY>
                           <ORIGINTOWNNAME></ORIGINTOWNNAME>
                           <ORIGINPOSTCODE>$from</ORIGINPOSTCODE>
                           <ORIGINTOWNGROUP></ORIGINTOWNGROUP>
                           <DESTCOUNTRY>$countryTo</DESTCOUNTRY>
                           <DESTTOWNNAME></DESTTOWNNAME>
                           <DESTPOSTCODE>$to</DESTPOSTCODE>
                           <DESTTOWNGROUP></DESTTOWNGROUP>
                           <CONTYPE>N</CONTYPE> 
                           <CURRENCY>CAD</CURRENCY> 
                           <WEIGHT>$weight</WEIGHT> 
                           <VOLUME>$width</VOLUME> 
                           <ACCOUNT></ACCOUNT>
                           <ITEMS>1</ITEMS>
						   
                     </PRICECHECK> 
                </PRICEREQUEST>";
	//echo $XmlString;		
	$this->returnXml = $this-> sendToTNTServer($XmlString );
	$xml2 = simplexml_load_string($this->returnXml);
	//echo "<pre>";
	//print_r($xml2);

		foreach($xml2->children() as $child)
		{
					
					$arr = $child->attributes();
					//print_r($child);
					$service_code = $child->SERVICE;
					$rate =  $child->RATE[0];
					$service_code = 'TnT '.$service_code;
					$service_type = 1;
					//echo $rate." ";
					$rateData[] = array("rate" => $rate, "name" => $service_code, "serviceType" => $service_type);
					//echo "$service_code" . "= " .$_SESSION["$service_code"] . "<br>";
		}
			//array_unique($rateData);
			return $rateData;
	
	}

   
}


				//	$tntRate = new tnt;
				//$tntRate->setCredentials('devpkgdepT','coffeetea',$admin_col3_tnt,2,$height,$width,$length,'V5Z3A2','K1N9J7');
				//$tntRate->setCredentials();
				 //echo $_SESSION['48N'];
?>