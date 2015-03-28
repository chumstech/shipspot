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
		/*$XmlString = "<?xml version=\"1.0\" encoding=\"UTF-8\"?> 
                  <PRICEREQUEST> 
                       <LOGIN> 
                           <COMPANY>$admin_col1_tnt</COMPANY> 
                           <PASSWORD>$admin_col2_tnt</PASSWORD> 
                           <APPID>PC</APPID> 
                       </LOGIN> 
                       <PRICECHECK> 
                           <RATEID>rate1</RATEID> 
                           <ORIGINCOUNTRY>CA</ORIGINCOUNTRY> 
                           <ORIGINTOWNNAME></ORIGINTOWNNAME> 
                           <ORIGINPOSTCODE>$from</ORIGINPOSTCODE> 
                           <ORIGINTOWNGROUP/> 
                           <DESTCOUNTRY>CA</DESTCOUNTRY> 
                           <DESTTOWNNAME></DESTTOWNNAME> 
                           <DESTPOSTCODE>$to</DESTPOSTCODE> 
                           <DESTTOWNGROUP/> 
                           <CONTYPE>N</CONTYPE> 
                           <CURRENCY>GBP</CURRENCY> 
                           <WEIGHT>$weight</WEIGHT> 
                           <VOLUME>0.1</VOLUME> 
                           <ACCOUNT/> 
                           <ITEMS>1</ITEMS> 
                     </PRICECHECK> 
                </PRICEREQUEST>";
	*/
	
	
	$XmlString = "<?xml version=\"1.0\" encoding=\"UTF-8\"?> 
                  <PRICEREQUEST> 
                       <LOGIN> 
                           <COMPANY>$admin_col1_tnt</COMPANY> 
                           <PASSWORD>$admin_col2_tnt</PASSWORD> 
                           <APPID>$admin_col3_tnt</APPID> 
                       </LOGIN> 
                       <PRICECHECK> 
                         <RATEID>rate1</RATEID> 
                         <ORIGINCOUNTRY>$countryFrom</ORIGINCOUNTRY>
                           <ORIGINTOWNNAME></ORIGINTOWNNAME>
                           <ORIGINPOSTCODE>$from</ORIGINPOSTCODE>
                           <ORIGINTOWNGROUP/>
                           <DESTCOUNTRY>$countryTo</DESTCOUNTRY>
                           <DESTTOWNNAME></DESTTOWNNAME>
                           <DESTPOSTCODE>$to</DESTPOSTCODE>
                           <DESTTOWNGROUP/> 
                           <CONTYPE>N</CONTYPE> 
                           <CURRENCY>CAD</CURRENCY> 
                           <WEIGHT>$weight</WEIGHT> 
                           <VOLUME>$width</VOLUME> 
                           <ACCOUNT/> 
                           <ITEMS>1</ITEMS> 
                     </PRICECHECK> 
                </PRICEREQUEST>";
				
	$this->returnXml = $this-> sendToTNTServer($XmlString );
	$xml2 = simplexml_load_string($this->returnXml);
	//echo "<pre>";
	//print_r($xml2);

		foreach($xml2->children() as $child)
		{
					
					$arr = $child->attributes();
					//echo $child->RATE;
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