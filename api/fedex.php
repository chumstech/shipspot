<?php
		ini_set('display_errors',0);
		session_start();
		require_once('../connections/db.php');
		require_once("../admin/adminRates.php");
		require_once("FedEx/RateAvailableServices.php");
		
		$countryFrom = $_GET['countryFrom'];
		$countryTo = $_GET['countryTo'];
		
		$from 	= $_GET['txt_from'];
		$to		= $_GET['txt_to'];
		$weight = $_GET['txt_weight'];
		$length = $_GET['txt_length'];
		$width 	= $_GET['txt_width'];
		$height = $_GET['txt_height'];

		
		$fedexRate = new FedEx;
		
		if(isset($_SESSION['Admin_Email'])) // check if admin login or local user to give an option to select carrier
		{
			$rateData = $fedexRate->setCredentials($admin_col1_fedex,$admin_col2_fedex,$admin_col3_fedex,$admin_col4_fedex,$weight,$height,$width,$length,$from,$to,$countryFrom,$countryTo);
		}
		else
		{
			if($_SESSION['DB_FEDEX'] == 'Y')
			{
			$rateData = $fedexRate->setCredentials($admin_col1_fedex,$admin_col2_fedex,$admin_col3_fedex,$admin_col4_fedex,$weight,$height,$width,$length,$from,$to,$countryFrom,$countryTo);
			}
		}
	
		foreach($rateData as $canadaRate)
		{
			if($_SESSION['Pri_Disc_Rate_Flag']=='Y'){
					   
					   $canDiscount = $canadaRate['rate'] + ($_SESSION['privilege_discount_fedex'] * $canadaRate['rate']);
						$canDiscount = round($canDiscount,2);
						
			}else{
			if($_SESSION['Disc_Rate_Flag']=='Y') ////check if admin alow a client to see discounted rates? if yes then form an array of posted rates
			{	
				$canDiscount = $canadaRate['amount']- ($_SESSION['discount_fedex'] *$canadaRate['amount']);
				$canDiscount = round($canDiscount,2);
			}
			else
			{
				$canDiscount = 0;
			}
			}
			
			$canName = $canadaRate['serviceType'];
			$canName = str_replace('_', ' ', $canName);
			$canName = ucwords(strtolower($canName));
			
			if($_SESSION['Posted_Rate_Flag']== 'Y')
			{
				$canRate = $canadaRate['amount'];
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
					if($canadaRate['DeliveryTimestamp'])
					{
						$canDelivery = $canadaRate['DeliveryTimestamp'];
						$canDelivery = date("F d Y", strtotime($canDelivery));
						
						$canShipping = date('Y-m-d');
						$date1=date_create($canadaRate['DeliveryTimestamp']);
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
			
			
			
			$canadaRates[] = array("canDiscount" => $canDiscount, "canName" => $canName, "canDelivery" => $canDelivery, "canRate" => $canRate, "canType" => $canType);
		}
		//echo "NO RECORDS";
		echo $_GET['callback'] . "(" . json_encode($canadaRates) . ")";