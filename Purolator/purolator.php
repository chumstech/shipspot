<?PHP
/*ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);
ini_set('error_log','script_errors.log');
ini_set('log_errors','On');*/

class puroRate
{
	var $PRODUCTION_KEY;
	var $PRODUCTION_PASS;
	var $BILLING_ACCOUNT;
	var $REGISTERED_ACCOUNT;
	
	
	 function setCredentials($key,$pass,$billingAccount,$registerAccount,$postalCode,$dest_zip,$length,$width,$height,$weight)
	 {
		$this->PRODUCTION_KEY = $key;
		$this->PRODUCTION_PASS = $pass;
		$this->BILLING_ACCOUNT = $billingAccount;	
		$this->REGISTERED_ACCOUNT = $registerAccount;
		$this->From = $postalCode; 
		$this->To= $dest_zip; 
		$this->Disc = $disc;
		$this->Weight = $weight; 
		$this->getRates();
	}

	function createPWSSOAPClient()
	{
  		$client1 = new SoapClient( "EstimatingService.wsdl", 
                            array	(
                                    'trace'			=>	true,
                                    'location'	=>	"https://devwebservices.purolator.com/PWS/V1/Estimating/EstimatingService.asmx",
									'uri'				=>	"http://purolator.com/pws/datatypes/v1",
                                    'login'			=>	$this->PRODUCTION_KEY,
                                    'password'	=>	$this->PRODUCTION_PASS
                                  )
                          );
  		$headers[] = new SoapHeader ( 'http://purolator.com/pws/datatypes/v1', 
                                'RequestContext', 
                                array (
                                        'Version'           =>  '1.3',
                                        'Language'          =>  'en',
                                        'GroupID'           =>  'xxx',
                                        'RequestReference'  =>  'Rating Example'
                                      )
                              ); 
 		$client1->__setSoapHeaders($headers);
		return $client1;
	}

	function getRates()
	{
		$client1 = $this->createPWSSOAPClient();
		$request1->BillingAccountNumber = $this->BILLING_ACCOUNT;
		$request1->SenderPostalCode = $this->From;
		$request1->ReceiverAddress->Country = "CA";
		$request1->ReceiverAddress->PostalCode = $this->To;  
		$request1->PackageType = "CustomerPackaging";
		$request1->TotalWeight->Value = $this->Weight;
		$request1->TotalWeight->WeightUnit = "lb";
		$request1->Shipment->PickupInformation->PickupType = "DropOff";
		$request1->ShowAlternativeServicesIndicator = "true";
		
		$response = $client1->GetQuickEstimate($request1);
		
		if($response && $response->ShipmentEstimates->ShipmentEstimate)
		{
		
		 foreach($response->ShipmentEstimates->ShipmentEstimate as $estimate)
			  {
				//echo "<li>$estimate->ServiceID is available for $ $estimate->TotalPrice</li>";
				//echo "<li>".$estimate->ServiceID." = $".$_SESSION[$estimate->ServiceID] = $estimate->TotalPrice."</li>";
				$_SESSION['purolator_'.$estimate->ServiceID] = $estimate->TotalPrice;
			  }		
		}
	}
	
}	

?>
         