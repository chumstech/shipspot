<?php
		ini_set('display_errors',0);
		session_start();
		require_once('../connections/db.php');
		require_once("../admin/adminRates.php");
		require_once("TnT/TnT.php");
		
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
		
		if(isset($_SESSION['Admin_Email'])) // check if admin login or local user to give an option to select carrier
		{
				$rateData = $tntRate->setCredentials($admin_col1_tnt,$admin_col2_tnt,$admin_col3_tnt,$length,$width,$height,$weight,$from,$to,$countryFrom,$countryTo);
		}
		else
		{		
			if($_SESSION['DB_TNT'] =='Y')
			{
			$rateData = $tntRate->setCredentials($admin_col1_tnt,$admin_col2_tnt,$admin_col3_tnt,$length,$width,$height,$weight,$from,$to,$countryFrom,$countryTo);
			}
		}
		$check = array();
		foreach($rateData as $canadaRate)
		{
			
			if (!(in_array($canadaRate['name'], $check )))
			{
				// not in array
				if($canadaRate['rate'])
				{
					  if($_SESSION['Pri_Disc_Rate_Flag']=='Y'){
					   
					   $canDiscount = $canadaRate['rate'] + ($_SESSION['privilege_discount_tnt'] * $canadaRate['rate']);
						$canDiscount = round($canDiscount,2);
						
				   }else{
					if($_SESSION['Disc_Rate_Flag']=='Y') ////check if admin alow a client to see discounted rates? if yes then form an array of posted rates
					{	
						$canDiscount =$canadaRate['rate']- ($_SESSION['discount_tnt'] * $canadaRate['rate']);
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
			}
			$check[] = $canadaRate['name']; 
		}
		//print_r($canadaRates);
		echo $_GET['callback'] . "(" . json_encode($canadaRates) . ")";
		