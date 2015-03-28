<?php

		class FedEx
		{
		 function setCredentials($col1,$col2,$col3,$col4,$weight,$height,$width,$length,$from,$to,$countryFrom,$countryTo) // 
		 {
		 $path_to_wsdl = APP_PATH."api/FedEx/RateService_v14.wsdl";
		 //var_dump($path_to_wsdl);
		 ini_set("soap.wsdl_cache_enabled", "1");
    	$client = new SoapClient($path_to_wsdl, array('trace' => 1)); 
		//var_dump($client);
				$request['WebAuthenticationDetail'] = array(
													'UserCredential' => array(
																	'Key' => $col1, 
																	'Password' => $col2
																			)
															); 
				$request['ClientDetail'] = array(
											'AccountNumber' => $col3, 
											'MeterNumber' => $col4
												);

				$request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Available Services Request v14 using PHP ***');
				$request['Version'] = array(
									'ServiceId' => 'crs', 
									'Major' => '14', 
									'Intermediate' => '0', 
									'Minor' => '0'
											);
											
				$request['ReturnTransitAndCommit'] = true;
				$request['RequestedShipment']['DropoffType'] = 'REQUEST_COURIER'; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
				$request['RequestedShipment']['ShipTimestamp'] = date('c');
				$request['RequestedShipment']['PackagingType'] = 'YOUR_PACKAGING'; // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
				$request['RequestedShipment']['Shipper'] = array(
																'Address'=>array(
																'StreetLines' => array(''),
																'City' => '',
																'StateOrProvinceCode' => '',
																'PostalCode' => $from ,
																'CountryCode' => $countryFrom
    																				)
																);
				$request['RequestedShipment']['Recipient'] = array(
																'Address'=>array(
																'StreetLines' => array(''),
																'City' => '',
																'StateOrProvinceCode' => '',
																'PostalCode' => $to,
																'CountryCode' => $countryTo
																					)
																);
														
				$request['RequestedShipment']['RateRequestTypes'] = 'ACCOUNT'; 
				$request['RequestedShipment']['RateRequestTypes'] = 'LIST'; 
				$request['RequestedShipment']['PackageCount'] = '1';
				$request['RequestedShipment']['RequestedPackageLineItems'] = array(
																			'0' => array(
																						'SequenceNumber' => 1,
																						'GroupPackageCount' => 1,
																						'Weight' => array(
																						'Value' => $weight,
																						'Units' => 'LB'
																						),
																				'Dimensions' => array(
																									'Length' => $length,
																									'Width' => $width,
																									'Height' => $height,
																									'Units' => 'IN'
																									)
																						)
																					);
																					
																					
					$response = $client->getRates($request);
					if(is_array($response -> RateReplyDetails))
					{
						
						foreach ($response -> RateReplyDetails as $rateReply)
								{
									$serviceType = $rateReply ->ServiceType;
									$amount = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;
									$DeliveryTimestamp = $rateReply ->DeliveryTimestamp;
									/*if(array_key_exists('DeliveryTimestamp',$rateReply))
									{
										$deliveryDate= $rateReply->DeliveryTimestamp ;
									}
									else
									{
										$deliveryDate= $rateReply->TransitTime ;
									}*/
									//$_SESSION['fedex_'.$serviceType] =  $amount;
									
									$rateData[] = array("serviceType" => $serviceType, "amount" => $amount, "DeliveryTimestamp" =>$DeliveryTimestamp);
								}
							return $rateData;
						}
			}
				
				
}	 	
?>