<?php
		ini_set('display_errors',0);
		session_start();
		require_once('../connections/db.php');
		require_once("../controls/functions.php");
		require_once("FedEx/RateAvailableServices.php");
		
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
        
	  if($userObj->is_privilege_discount == 1 and $userObj->user_type !=  2){
			$selectClause = "*";
		 	$starUserDetail = getUserDetailById($userObj->parent_id);
		 	$starUserDetail = (object) $starUserDetail;
		 	$whereClause = " name='Fedex' AND user_id = $starUserDetail->id";
		    $fedexDetail = getStarUserCarriers($selectClause,$whereClause);
		 if(count($fedexDetail) == 0){
		 	$selectClause = "*";
		 	$whereClause = " name='Fedex'";
		 	$fedexDetail = getGenrealCarriers($selectClause,$whereClause);
		  }
		}else{
			$selectClause = "*";
			$whereClause = " name='Fedex'";
			$fedexDetail = getGenrealCarriers($selectClause,$whereClause);
		}		
		$fedexRate = new FedEx;	
		$rateData = $fedexRate->setCredentials($fedexDetail->api_key,$fedexDetail->password,$fedexDetail->account_no,$fedexDetail->other_account_no,$weight,$height,$width,$length,$from,$to,$countryFrom,$countryTo);
		if($userObj->user_type == 2){
			$selectClause = '*';
			$whereClause = " name='Fedex' AND user_id = $userObj->id";
			$fedexDetail = getStarUserCarriers($selectClause,$whereClause);
	    	$starRateData = $fedexRate->setCredentials($fedexDetail->api_key,$fedexDetail->password,$fedexDetail->account_no,$fedexDetail->other_account_no,$weight,$height,$width,$length,$from,$to,$countryFrom,$countryTo);
		}
//         echo '<pre>';print_r($rateData);
//         echo '<pre>';print_r($starRateData);
		foreach($rateData as $key => $fedexRate)
		{
			$object = (object) array('user_id' => $userObj->id,'carrier_id' => $fedexDetail->id);
			$carrierDiscounts =  geGenrealCarrierDiscount($object);
			if($userObj->is_privilege_discount == 1){
					   
					    $canDiscount = $fedexRate['amount'] - ($carrierDiscounts->privilege_discount * $fedexRate['amount'] / 100);
					  //  var_dump($canDiscount);
					   // var_dump($fedexRate['amount']);
						$canDiscount = round($canDiscount,2);
						
			}else{
			if($userObj->is_discounted_rate == 1) ////check if admin alow a client to see discounted rates? if yes then form an array of posted rates
			{	
				
				$canDiscount = $fedexRate['amount']- ($carrierDiscounts->discount *$fedexRate['amount'] / 100);
				$canDiscount = round($canDiscount,2);
			}
			else
			{
				$canDiscount = 0;
			}
			}
			
			if($userObj->user_type == 2){
				if(isset($starRateData[$key]['amount'])){
				 $canDiscount = $starRateData[$key]['amount'];
				}
			}
			
			$canName = $fedexRate['serviceType'];
			$canName = str_replace('_', ' ', $canName);
			$canName = ucwords(strtolower($canName));
			
			if($userObj->is_posted_rate == 1 or $userObj->user_type == 2)
			{
				$canRate = $fedexRate['amount'];
			}
			else
			{
				$canRate = 0;
			}
			
			
			if(strpos($canName, 'Overnight') !== false || strpos($canName, 'Priority') !== false || strpos($canName, 'First') !== false) 
				{
					$canType = 1;		
				} 
				elseif(strpos($canName, '2 Day') !== false)
				{
					$canName = str_replace('2','2nd',$canName);
					$canType = 2;	
				}
				elseif(strpos($canName, 'Ground') !== false)
				{
					$canType = 3;	
				}
				else
				{
					if($fedexRate['DeliveryTimestamp'])
					{
						$canDelivery = $fedexRate['DeliveryTimestamp'];
						$canDelivery = date("F d Y", strtotime($canDelivery));
						
						$canShipping = date('Y-m-d');
						$date1=date_create($fedexRate['DeliveryTimestamp']);
						$date2=date_create($canShipping);
						$diff=date_diff($date1,$date2);
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
					}
				}
				
						
						if($canDelivery == '' || $canDelivery == 'null' || $canDelivery == ' ')
						{
							$canDelivery = '';
						}
						
						//die($canDelivery);
			
			
			
			$fedexRates[] = array("canDiscount" => $canDiscount, "canName" => $canName, "canDelivery" => $canDelivery, "canRate" => $canRate, "canType" => $canType);
		}
		//echo "NO RECORDS";
		echo $_GET['callback'] . "(" . json_encode($fedexRates) . ")";