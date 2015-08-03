<?php
		ini_set('display_errors',0);
		session_start();
		require_once('../connections/db.php');
		require_once("../admin/adminRates.php");
		require_once("../controls/functions.php");
		require_once("UPS/upsRate.php");
		
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
		$packingType 	= $_GET['ship_type'];

		if($userObj->is_privilege_discount == 1 and $userObj->user_type !=  2){
			$selectClause = "*";
			$starUserDetail = getUserDetailById($userObj->parent_id);
			$starUserDetail = (object) $starUserDetail;
			$whereClause = " name='UPS' AND user_id = $starUserDetail->id";
			$upsDetail = getStarUserCarriers($selectClause,$whereClause);
			if(count($fedexDetail) == 0){
				$selectClause = "*";
				$whereClause = " name='UPS'";
				$upsDetail = getGenrealCarriers($selectClause,$whereClause);
			}
		}else{
			$selectClause = "*";
			$whereClause = " name='UPS'";
			$upsDetail = getGenrealCarriers($selectClause,$whereClause);
		}
		
		$upsRate = new upsRate;
		$rateData = $upsRate->setCredentials($upsDetail->account_no,$upsDetail->api_key,$upsDetail->password,$upsRate->other_account_no,$from, $to, $length, $width, $height, $weight, $packingType,$countryFrom,$countryTo);
		if($userObj->user_type == 2){
			$selectClause = '*';
			$whereClause = " name='UPS' AND user_id = $userObj->id";
			$upsDetail = getStarUserCarriers($selectClause,$whereClause);
			$starRateData = $upsRate->setCredentials($upsDetail->account_no,$upsDetail->api_key,$upsDetail->password,$upsRate->other_account_no,$from, $to, $length, $width, $height, $weight, $packingType,$countryFrom,$countryTo);
		}
		
		if(!is_array($rateData)){
			$insertClause = array('user_id' =>$userObj->id,'api_name' => 'UPS','response' => json_encode(array("No Response Return")));
		}else{
			$insertClause = array('user_id' =>$userObj->id,'api_name' => 'UPS','response' => json_encode($rateData));
		}
		addApiLog($insertClause);
		
		$object = (object) array('user_id' => $userObj->id,'carrier_id' => $upsDetail->id);
		$carrierDiscounts =  geGenrealCarrierDiscount($object);
		
		foreach($rateData as $canadaRate)
		{
			       if($userObj->is_privilege_discount == 1){
					   
					   $canDiscount = $canadaRate['rate'] + ($carrierDiscounts->privilege_discount* $canadaRate['rate'] / 100);
						$canDiscount = round($canDiscount,2);
						
				   }else{		   
					if($userObj->is_discounted_rate == 1) ////check if admin alow a client to see discounted rates? if yes then form an array of posted rates
					{	
						$canDiscount = $canadaRate['rate'] - ($carrierDiscounts->discount * $canadaRate['rate'] / 100);
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
			
			if($userObj->is_posted_rate  == 1 or $userObj->user_type == 2)
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
			
		echo $_GET['callback'] . "(" . json_encode($canadaRates) . ")";