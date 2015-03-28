<?php
		ini_set('display_errors',0);
		session_start();
		require_once('../connections/db.php');
		require_once("../admin/adminRates.php");
		require_once("Purolator/purolator.php");
		
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

		$purolatorRate = new puroRate;
		
		if(isset($_SESSION['Admin_Email'])) // check if admin login or local user to give an option to select carrier
		{
				$rateData = $purolatorRate->setCredentials($admin_col1_purolator,$admin_col2_purolator,$admin_col3_purolator,$admin_col4_purolator,$from, $to, $length, $width, $height, $weight,$countryFrom,$countryTo);
		}
		else
		{
			if($_SESSION['DB_PUROLATOR']=='Y')
			{
				$rateData = $purolatorRate->setCredentials($admin_col1_purolator,$admin_col2_purolator,$admin_col3_purolator,$admin_col4_purolator,$from, $to, $length, $width, $height, $weight,$countryFrom,$countryTo);
			}
		}
		
		foreach($rateData as $canadaRate)
		{
			if($_SESSION['Pri_Disc_Rate_Flag']=='Y'){
					   
					   $canDiscount = $canadaRate['rate'] + ($_SESSION['privilege_discount_purolator'] * $canadaRate['rate']);
						$canDiscount = round($canDiscount,2);
						
			}else{
			if($_SESSION['Disc_Rate_Flag']=='Y') ////check if admin alow a client to see discounted rates? if yes then form an array of posted rates
			{	
				$canDiscount = $canadaRate['rate'] - $_SESSION['discount_purolator'] * $canadaRate['rate'];
				$canDiscount = round($canDiscount,2);
			}
			else
			{
				$canDiscount = 0;
			} 
			}
			
			
			$canName = $canadaRate['name'];
			$canName = preg_replace('/(?<!\ )[A-Z]/', ' $0', $canName);
			$canName = str_replace("A M","AM",$canName);
			$canName = str_replace("Express","Express ",$canName);
			$canName = str_replace("Ground","Ground ",$canName);
			
			$canDelivery = $canadaRate['deliveryDate'];
			$canShipping = $canadaRate['shippingDate'];
			if($_SESSION['Posted_Rate_Flag']== 'Y')
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