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

	function setCredentials()
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
                           <COMPANY>devpkgdepT</COMPANY> 
                           <PASSWORD>coffeetea</PASSWORD> 
                           <APPID>00001001878</APPID> 
                       </LOGIN> 
                       <PRICECHECK> 
                         <RATEID>rate1</RATEID> 
                         <ORIGINCOUNTRY>CA</ORIGINCOUNTRY>
                           <ORIGINTOWNNAME></ORIGINTOWNNAME>
                           <ORIGINPOSTCODE>V3w9j6</ORIGINPOSTCODE>
                           <ORIGINTOWNGROUP/>
                           <DESTCOUNTRY>CA</DESTCOUNTRY>
                           <DESTTOWNNAME></DESTTOWNNAME>
                           <DESTPOSTCODE>K1N9j7</DESTPOSTCODE>
                           <DESTTOWNGROUP/> 
                           <CONTYPE>N</CONTYPE> 
                           <CURRENCY>GBP</CURRENCY> 
                           <WEIGHT>0.2</WEIGHT> 
                           <VOLUME>0.1</VOLUME> 
                           <ACCOUNT/> 
                           <ITEMS>1</ITEMS> 
                     </PRICECHECK> 
                </PRICEREQUEST>";
				
	$this->returnXml = $this-> sendToTNTServer($XmlString );
	
 	print_r($returnXml);
	die();
	$xml2 = simplexml_load_string($this->returnXml);
	//echo "<pre>";
	//print_r($xml2);

		foreach($xml2->children() as $child)
		{
					$arr = $child->attributes();
					//echo $child->RATE;
					$service_code = $child->SERVICE;
					//echo "Service Codee = ".$service_code."<br>";
					$rate =  $child->RATE;
					//echo "Rates = ".$rate."<br>";
					 $_SESSION["$service_code"] = $rate;
					//echo "$service_code" . "= " .$_SESSION["$service_code"] . "<br>";
		}
	
	}

   
}


				//	$tntRate = new tnt;
				//$tntRate->setCredentials('devpkgdepT','coffeetea',$admin_col3_tnt,2,$height,$width,$length,'V5Z3A2','K1N9J7');
				//$tntRate->setCredentials();
				 //echo $_SESSION['48N'];
?>