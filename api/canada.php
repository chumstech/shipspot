<?php
		ini_set('display_errors',0);
		session_start();
		require_once('../connections/db.php');
		require_once("../admin/adminRates.php");
		require_once("../controls/functions.php");
		require_once("canadaPost/canadapost.php");
		
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
		
		if($userObj->is_privilege_discount == 1 ){
			$selectClause = "*";
			if($userObj->parent_id != 0 and $userObj->user_type ==  3){
				$starUserDetail = getUserDetailById($userObj->parent_id);
				$starUserDetail = (object) $starUserDetail;
				$whereClause = " name='Canada Post' AND user_id = $starUserDetail->id";
			}else if($userObj->user_type ==  2){
				$whereClause = " name='Canada Post' AND user_id = $userObj->id";
			}
			$canadaDetail = getStarUserCarriers($selectClause,$whereClause);
			if(count($canadaDetail) == 0){
				$selectClause = "*";
				$whereClause = " name='Canada Post'";
				$canadaDetail = getGenrealCarriers($selectClause,$whereClause);
			}
		}else{
			$selectClause = "*";
			$whereClause = " name='Canada Post'";
			$canadaDetail = getGenrealCarriers($selectClause,$whereClause);
		}
		

		$canadaPostRate = new CanadaPost();
		$rateData = $canadaPostRate->setCredentials($canadaDetail->api_key,$length,$width,$height,$weight,$from,$to,$countryFrom,$countryTo);

// 		if($userObj->user_type == 1) // check if admin login or local user to give an option to select carrier
// 		{
// 				$rateData = $canadaPostRate->setCredentials($canadaDetail->api_key,$length,$width,$height,$weight,$from,$to,$countryFrom,$countryTo);
// 		}
// 		else
// 		{
// 			if($_SESSION['DB_CANADAPOST'] == 'Y') //check if this carrier is enabled then call API to get rates
// 			{
// 				$rateData = $canadaPostRate->setCredentials($admin_col1_canada,$length,$width,$height,$weight,$from,$to,$countryFrom,$countryTo);
// 			}
// 		}
		//print_r($rateData);
		$object = (object) array('user_id' => $userObj->id,'carrier_id' => $canadaDetail->id);
		$carrierDiscounts =  geGenrealCarrierDiscount($object);
		foreach($rateData as $canadaRate)
		{
			if($userObj->is_privilege_discount == 1){
					   
					   $canDiscount = $canadaRate['rate'] - ($carrierDiscounts->privilege_discount * $canadaRate['rate'] / 100);
						$canDiscount = round($canDiscount,2);
						
			}else{
				if($userObj->is_discounted_rate) ////check if admin alow a client to see discounted rates? if yes then form an array of posted rates
				{	
					$canDiscount = $canadaRate['rate'] - ($carrierDiscounts->discount * $canadaRate['rate'] / 100 );
					$canDiscount = round($canDiscount,2);
				}
				else
				{
					$canDiscount = 0;
				}
			}
			$canName = "Canada Post ".$canadaRate['name'];
			$canDelivery = $canadaRate['deliveryDate'];
			//$canShipping = $canadaRate['shippingDate'];
			if($userObj->is_posted_rate  == 1)
			{
				$canRate = $canadaRate['rate'];
			}
			else
			{
				$canRate = 0;
			}
			$canShipping = $canadaRate['shippingDate'];
			/*$date1=date_create($canDelivery);
			$date2=date_create($canShipping);
			$diff=date_diff($date1,$date2);
			echo $diff;
			$canDelivery = date("F d Y", strtotime($canDelivery));
			$canType = $diff->format("%a");
			echo $canType;
			if($canType == 1)
			{
			$canType = 1; 	
			}
			if($canType == 2)
			{
			$canType = 2; 	
			}
			if($canType > 2)
			{*/
			$canType = 3;
			/*}*/
			
			
			$canadaRates[] = array("canDiscount" => $canDiscount, "canName" => $canName, "canDelivery" => $canDelivery, "canRate" => $canRate, "canType" => $canType);
		} 
			
		echo $_GET['callback'] . "(" . json_encode($canadaRates) . ")";