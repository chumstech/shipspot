<?php

		ini_set('display_errors',0);
		session_start();
		require_once('../connections/db.php');
		require_once("../admin/adminRates.php");
		require_once("../controls/functions.php");
		require_once("Purolator/purolator.php");
		
		
		$countryFrom = $_GET['countryFrom'];
		$countryTo = $_GET['countryTo'];
		$from 	= $_GET['txt_from'];
		$to		= $_GET['txt_to'];
		$weight = $_GET['txt_weight'];
		$length = $_GET['txt_length'];
		$width 	= $_GET['txt_width'];
		$height = $_GET['txt_height'];
		$countryToState = '';
		
		if($countryTo == 'US')
		{
			$countryToZipInfo = get_zip_info($to);
			$countryToState = $countryToZipInfo['state'];
		}
		
		
		$userObj = "";
		if(isset($_SESSION['user'])){
			$userObj = (object)	$_SESSION['user'];
		}
		
		$check_canada 	= $_GET['check_canada'];;
		$check_ups 		= $_GET['check_ups'];
		$check_puro 	= $_GET['check_puro'];
		$check_fedex 	= $_GET['check_fedex'];
		$check_tnt 		= $_GET['check_tnt'];
		$check_dhl 		= $_GET['check_dhl'];
		$packingType 	= $_GET['ship_type'];

		$purolatorRate = new puroRate;
		if($userObj->is_privilege_discount == 1 and $userObj->user_type !=  2){
			$selectClause = "*";
			$starUserDetail = getUserDetailById($userObj->parent_id);
			$starUserDetail = (object) $starUserDetail;
			$whereClause = " name='Purolator' AND user_id = $starUserDetail->id";
			$purolatorDetail = getStarUserCarriers($selectClause,$whereClause);
			if(count($fedexDetail) == 0){
				$selectClause = "*";
				$whereClause = " name='Fedex'";
				$purolatorDetail = getGenrealCarriers($selectClause,$whereClause);
			}
		}else{
			$selectClause = "*";
			$whereClause = " name='Purolator'";
			$purolatorDetail = getGenrealCarriers($selectClause,$whereClause);
		}
		
		$rateData = $purolatorRate->setCredentials($purolatorDetail->api_key,$purolatorDetail->password,$purolatorDetail->account_no,$tntDetail->other_account_no,$from, $to, $length, $width, $height, $weight,$countryFrom,$countryTo,$countryToState);
		if($userObj->user_type == 2){
			$selectClause = '*';
			$whereClause = " name='Purolator' AND user_id = $userObj->id";
			$purolatorDetail = getStarUserCarriers($selectClause,$whereClause);
			$starRateData = $purolatorRate->setCredentials($purolatorDetail->api_key,$purolatorDetail->password,$purolatorDetail->account_no,$tntDetail->other_account_no,$from, $to, $length, $width, $height, $weight,$countryFrom,$countryTo,$countryToState);
		}
		//$purolatorDetail->account_no,$tntDetail->api_key,$tntDetail->password,$tntDetail->other_account_no
// 		if($userObj->user_type == 1) // check if admin login or local user to give an option to select carrier
// 		{
// 				$rateData = $purolatorRate->setCredentials($purolatorDetail->api_key,$purolatorDetail->password,$purolatorDetail->account_no,$tntDetail->other_account_no,$from, $to, $length, $width, $height, $weight,$countryFrom,$countryTo);
// 		}
// 		else
// 		{
// 			if($_SESSION['DB_PUROLATOR']=='Y')
// 			{
// 				$rateData = $purolatorRate->setCredentials($purolatorDetail->api_key,$purolatorDetail->password,$purolatorDetail->account_no,$tntDetail->other_account_no,$from, $to, $length, $width, $height, $weight,$countryFrom,$countryTo);
// 			}
// 		}
		
		$object = (object) array('user_id' => $userObj->id,'carrier_id' => $purolatorDetail->id);
		$carrierDiscounts =  geGenrealCarrierDiscount($object);
		
		foreach($rateData as $canadaRate)
		{
			if($userObj->is_privilege_discount == 1){
					   
					   $canDiscount = $canadaRate['rate'] - ($carrierDiscounts->privilege_discount * $canadaRate['rate'] / 100);
						$canDiscount = round($canDiscount,2);
						
			}else{
			if($userObj->is_discounted_rate == 1) ////check if admin alow a client to see discounted rates? if yes then form an array of posted rates
			{	
				$canDiscount = $canadaRate['rate'] - ($carrierDiscounts->discount* $canadaRate['rate'] / 100 );
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
			$canName = preg_replace('/(?<!\ )[A-Z]/', ' $0', $canName);
			$canName = str_replace("A M","AM",$canName);
			$canName = str_replace("Express","Express ",$canName);
			$canName = str_replace("Ground","Ground ",$canName);
			
			$canDelivery = $canadaRate['deliveryDate'];
			$canShipping = $canadaRate['shippingDate'];
			if($userObj->is_posted_rate == 1 or $userObj->user_type == 2)
			{
				$canRate = $canadaRate['rate'];
			}
			else
			{
				$canRate = 0;
			}
			

			
			$date1=date_create($canDelivery);
			$date2=date_create($canShipping);
			$diff=date_diff($date1,$date2);
			
			$canDelivery = date("F d Y", strtotime($canDelivery));
			$canType = $diff->format("%a");
			
			if($canType == 1)
			{
			$canType = 1; 	
			}
			if($canType == 2)
			{
			$canType = 2; 	
			}
			if($canType > 2)
			{
			$canType = 3;
			}
			
			
			$canadaRates[] = array("canDiscount" => $canDiscount, "canName" => $canName, "canDelivery" => $canDelivery, "canRate" => $canRate, "canType" => $canType);
		} 
			
		echo $_GET['callback'] . "(" . json_encode($canadaRates) . ")";