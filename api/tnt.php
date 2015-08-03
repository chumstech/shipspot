<?php
		ini_set('display_errors',0);
		session_start();
		require_once('../connections/db.php');
		require_once("../admin/adminRates.php");
		require_once("../controls/functions.php");
		require_once("TnT/TnT.php");
		
		$userObj = "";
		if(isset($_SESSION['user'])){
			$userObj = (object)	$_SESSION['user'];
		}
		
		$countryFrom = $_GET['countryFrom'];
		$countryTo = $_GET['countryTo'];

		$from 	= $_GET['txt_from'];
		$to		= $_GET['txt_to'];
		$weight = $_GET['txt_weight'];
		$length = $_GET['txt_length'];
		$width 	= $_GET['txt_width'];
		$height = $_GET['txt_height'];
		
		$check_canada 	= $_GET['check_canada'];;
		$check_ups 		= $_GET['check_ups'];
		$check_puro 	= $_GET['check_puro'];
		$check_fedex 	= $_GET['check_fedex'];
		$check_tnt 		= $_GET['check_tnt'];
		$check_dhl 		= $_GET['check_dhl'];
		$packingType 	= $_GET['ship_type'];
		
		$tntRate = new tnt;
		
	  if($userObj->is_privilege_discount == 1 and $userObj->user_type !=  2){
			$selectClause = "*";
		 	$starUserDetail = getUserDetailById($userObj->parent_id);
		 	$starUserDetail = (object) $starUserDetail;
		 	$whereClause = " name='TnT' AND user_id = $starUserDetail->id";
		    $tntDetail = getStarUserCarriers($selectClause,$whereClause);
		 if(count($fedexDetail) == 0){
		 	$selectClause = "*";
		 	$whereClause = " name='TnT'";
		 	$tntDetail = getGenrealCarriers($selectClause,$whereClause);
		  }
		}else{
			$selectClause = "*";
			$whereClause = " name='TnT'";
			$tntDetail = getGenrealCarriers($selectClause,$whereClause);
		}
		
		$rateData = $tntRate->setCredentials($tntDetail->api_key,$tntDetail->password,$tntDetail->account_no,$length,$width,$height,$weight,$from,$to,$countryFrom,$countryTo);
		if($userObj->user_type == 2){
			$selectClause = '*';
			$whereClause = " name='TnT' AND user_id = $userObj->id";
			$tntDetail = getStarUserCarriers($selectClause,$whereClause);
			$starRateData = $tntRate->setCredentials($tntDetail->api_key,$tntDetail->password,$tntDetail->account_no,$length,$width,$height,$weight,$from,$to,$countryFrom,$countryTo);
		}
		if(!is_array($rateData)){
			$insertClause = array('user_id' =>$userObj->id,'api_name' => 'TnT','response' => json_encode(array("No Response Return")));
		}else{
			$insertClause = array('user_id' =>$userObj->id,'api_name' => 'TnT','response' => json_encode($rateData));
		}
		addApiLog($insertClause);
		$object = (object) array('user_id' => $userObj->id,'carrier_id' => $tntDetail->id);
		$carrierDiscounts =  geGenrealCarrierDiscount($object);
		
		$check = array();
		foreach($rateData as $canadaRate)
		{
			
			if (!(in_array($canadaRate['name'], $check )))
			{
				// not in array
				if($canadaRate['rate'])
				{
					  if($userObj->is_privilege_discount == 1){
					   
					   $canDiscount = $canadaRate['rate'] + ($carrierDiscounts->privilege_discount * $canadaRate['rate'] / 100 );
						$canDiscount = round($canDiscount,2);
						
				   }else{
					if($userObj->is_discounted_rate == 1) ////check if admin alow a client to see discounted rates? if yes then form an array of posted rates
					{	
						$canDiscount =$canadaRate['rate']- ($carrierDiscounts->discount* $canadaRate['rate'] / 100 );
						$canDiscount = round($canDiscount,2);
					}
					else
					{
						$canDiscount = 0;
					} 
				   }
				if(isset($starRateData[$key]['amount'])){
				 $canDiscount = $starRateData[$key]['amount'];
				}
				$canName = $canadaRate['name'];
					if($userObj->is_posted_rate == 1 or $userObj->user_type == 2)
					{
						$canRate = $canadaRate['rate'];
					}
					else
					{
						$canRate = 0;
					}
				$canType = $canadaRate['serviceType'];
				
				
				$canadaRates[] = array("canDiscount" => $canDiscount, "canName" => $canName, "canRate" => $canRate, "canType" => $canType);
				}
			}
			$check[] = $canadaRate['name']; 
		}
		//print_r($canadaRates);
		echo $_GET['callback'] . "(" . json_encode($canadaRates) . ")";
		