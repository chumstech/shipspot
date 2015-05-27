<?php
ini_set('display_errors',0);
class CanadaPost
{
	protected $sendXML;
	protected $responseXML;
	protected $merchantInfo;
	protected $customerInfo;
	protected $productInfo;
	protected $errorMessage;
	

		public function setMain($cpc_no,$from)
		 {
			$this->merchatInfo = array( 
 			'merchantCPCID' => $cpc_no,   //'CPC_MY_STORE',
		    'fromPostalCode' => $from,
		    'turnAroundTime' => '24',
		    'itemsPrice' => '0'		
								);
			$this->productInfo = array();
			$this->errorMessage = array (
					'code' => 0,
					'message' => 'success'
				);
		}

	public function setManufacturer($mInfo) 
	{
		$this->merchantInfo = $mInfo;
	}

	public function setPrice($itemPrice)
	{
		$this->merchantInfo['itemsPrice'] = $itemPrice;
	}	
	
	public function setCustomer($to,$countryTo) 
	{
		$this->customerInfo = array( 
				'city' => '',
				'provOrState' => '',
				'country' => $countryTo,
				'postalCode' => $to,
			 						) ;
	}

	public function addItem($pInfo)
	{
		$this->productInfo[] = $pInfo;
	}
	
	public function addProduct($weight,$length,$width,$height) 
	{
		$this->productInfo[] =  array (
		   		'quantity' => 1,
				'weight' =>$weight,
				'length' => $length,
				'width' => $width, 
				'height' => $height,  
				'description' => ' '
									);
	}	
	
	public function getRates($returnString = 'xml') 
	{
		
		$pData = $this->prepareXML();
		$context_options = array (
   	    	'http' => array (
   		   	    'method' => 'POST',
    	   	    'header'=> "Host: sellonline.canadapost.ca\n"
						 . "Content-type: application/x-www-form-urlencoded\r\n"
			             . "Content-Length: " . strlen($pData) . "\r\n"
    	       )
    	);
	
		$context = stream_context_create($context_options);	
		$socket = @stream_socket_client('sellonline.canadapost.ca:30000', $errno,
				 $errstr, 15, STREAM_CLIENT_CONNECT, $context);
		
		if( !$socket ) {
			$this->errorMessage['code'] = $errno;
			$this->errorMessage['message'] = $errstr;
			return false;
		}
			 
		fwrite($socket, $pData);
		$responseXML = "";
		while (!feof($socket) ) {
			$responseXML .= fgets($socket,255);
	   }	
	   fclose($socket);			
	   
//       $this->responseXML = $responseXML;
	   
	   if( $returnString == 'xml' ) {
			return $responseXML;
	   } else if( $returnString == 'array') {
	   	
			// make an assoc array by using xpath on Dom and the basic elements in an assoc array
	   		$rArray = array();	
   			$rDoc 	= new DomDocument();
   			$rDoc->loadXML($responseXML);
   			$xpath 	= new DomXPath($rDoc);
			
   			$statusCode = $xpath->query('//statusCode');
			
			// check for Error, if there's error then return false
			if( $statusCode->item(0)->nodeValue != "1" ) {
				$this->errorMessage['code'] 	= $statusCode->item(0)->nodeValue;
	   			$statusMessage = $xpath->query('//statusMessage');
				$this->errorMessage['message'] 	= $statusMessage->item(0)->nodeValue;
//				var_dump ( $responseXML );
				return false;
			}	
			
   			$rates 	= $xpath->query('/eparcel/ratesAndServicesResponse/product');
     		foreach($rates as $eachRate) { 
  	 			$tempArray = array();
  	 			foreach($eachRate->childNodes as $eachChild) {
   					if( $eachChild->tagName != "" )  	 		
	  			 		$tempArray[$eachChild->tagName] = $eachChild->nodeValue;
  	 			}
				$rArray['product'][] = $tempArray;
   			}
   
   			$packingInfo = $xpath->query('/eparcel/ratesAndServicesResponse/shippingOptions');
   			foreach($packingInfo as $eachPack )	 {
   				$tempArray = array();
   				foreach($eachPack->childNodes as $eachChild) {
   					if( $eachChild->tagName != "" )
		   				$tempArray[$eachChild->tagName] = $eachChild->nodeValue;
   				}
				$rArray['shippingOptions'] = $tempArray;
   			}     
   
			return $rArray;
	   }
	   
	}
	
	
	/**
	 * This Method prepares the XML to be send to Canada Posts's Server.
	 * @return none
	 */
	public function prepareXML() {
		
		$sendXML 	= new DomDocument("1.0");
		$eParcel 	= $sendXML->createElement("eparcel");
		$eParcel->appendChild( $sendXML->createElement('language', 'en') );
		$rSRequest 	= $sendXML->createElement("ratesAndServicesRequest");
		
		foreach($this->merchatInfo as $tag=>$value) {
			$rSRequest->appendChild( $sendXML->createElement($tag, $value) );
		}
		
		$lineItems = $sendXML->createElement('lineItems');
		foreach($this->productInfo as $eachProduct ) {
			$eachItems = $sendXML->createElement('item');
			foreach($eachProduct as $eachKey=>$eachValue) {
				$eachItems->appendChild( $sendXML->createElement($eachKey,$eachValue) );	
			}
			$lineItems->appendChild($eachItems);
		}
		$rSRequest->appendChild( $lineItems );
		foreach($this->customerInfo as $tag=>$value) {
			$rSRequest->appendChild( $sendXML->createElement($tag, $value) );
		}
		
		$eParcel->appendChild( $rSRequest );
		$sendXML->appendChild( $eParcel );
		$sendXML->formatOutput = true;
		return $sendXML->saveXML();
	}
	
	
	
	public function getError() {
		return $this->errorMessage;
	}
	
	/*** ***/
	
	public function getSendXML() {
		return $this->sendXML;
	}
	
	public function getResponseXML() {
		return $this->responseXML;
	}
	
	public function setCredentials($cpc_no,$length,$width,$height,$weight,$from,$to,$countryFrom,$countryTo)
	{	
		 $this->setMain($cpc_no,$from);
		 $this->setCustomer($to,$countryTo);
		 $this->addProduct($weight,$length,$width,$height);		
		 $this->setPrice(15);	
		 $assoc_Array = $this->getRates('array');

				
				if( $assoc_Array === false ) 
				{	
					return  'Error:';	
				} 
				else 
				{
				
						foreach( $assoc_Array['product'] as $eachProduct )	
							{
								//echo  "<li>".$eachProduct['name'] ." = ". $_SESSION[$eachProduct['name']] = $eachProduct['rate']."</li>";
								//$_SESSION['canada_'.$eachProduct['name']] = $eachProduct['rate'];
								$rateData[] = $eachProduct;
							}

						return $rateData;	
				}
				
	}
}
/////////////////////


			
		
		//$cPost2 = new CanadaPost();
		//$cPost2->setCredentials('CPC_SSSHIPPING',5,4,1,10,'V5Z3A2','K1N9J7');	
		
		
?>