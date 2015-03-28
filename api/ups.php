<?php
		ini_set('display_errors',0);
		session_start();
		require_once('../connections/db.php');
		require_once("../admin/adminRates.php");
		require_once("UPS/upsRate.php");
		
		$countryFrom = $_GET['countryFrom'];
		$countryTo = $_GET['countryTo'];
		
		$from 	= $_GET['txt_from'];
		$to		= $_GET['txt_to'];
		$weight = $_GET['txt_weight'];
		$length = $_GET['txt_length'];
		$width 	= $_GET['txt_width'];
		$height = $_GET['txt_height'];
		$packingType 	= $_GET['ship_type'];

		$upsRate = new upsRate;
		
		if(isset($_SESSION['Admin_Email'])) // check if admin login or local user to give an option to select carrier
		{
				$rateData = $upsRate->setCredentials($admin_col3_ups,$admin_col1_ups,$admin_col2_ups,$admin_col4_ups,$from, $to, $length, $width, $height, $weight, $packingType,$countryFrom,$countryTo);
		}
		else
		{
			if($_SESSION['DB_UPS'] == 'Y')
			{
				$rateData = $upsRate->setCredentials($admin_col3_ups,$admin_col1_ups,$admin_col2_ups,$admin_col4_ups,$from, $to, $length, $width, $height, $weight, $packingType,$countryFrom,$countryTo);
			}
		}
		
		foreach($rateData as $canadaRate)
		{
			       if($_SESSION['Pri_Disc_Rate_Flag']=='Y'){
					   
					   $canDiscount = $canadaRate['rate'] + ($_SESSION['privilege_discount_ups'] * $canadaRate['rate']);
						$canDiscount = round($canDiscount,2);
						
				   }else{		   
					if($_SESSION['Disc_Rate_Flag']=='Y') ////check if admin alow a client to see discounted rates? if yes then form an array of posted rates
					{	
						$canDiscount = $canadaRate['rate'] - ($_SESSION['discount_ups'] * $canadaRate['rate']);
						$canDiscount = round($canDiscount,2);
					}
					else
					{
						$canDiscount = 0;
					} 
				   }
			$canName = $canadaRate['name'];
			
			if($_SESSION['Posted_Rate_Flag']== 'Y')
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