<?php
		$rs_carrier = mysql_query("select * from  genreal_carriers order by name",$cn)or die(mysql_error());
		while($row_carrier = mysql_fetch_array($rs_carrier))
		{
			$_SESSION['admin_col1'][] = $row_carrier['carrier_key'];
			$_SESSION['admin_col2'][] = $row_carrier['carrier_password'];
			$_SESSION['admin_col3'][] = $row_carrier['carrier_account_number'];
			$_SESSION['admin_col4'][] = $row_carrier['carrier_other_number'];
		}
				
		$admin_col1_canada = $_SESSION['admin_col1'][0];
		//$admin_col2_canada  = $_SESSION['admin_col2'][0];
		//$admin_col3_canada  = $_SESSION['admin_col3'][0];
		//$admin_col4_canada  = $_SESSION['admin_col4'][0];	
					
		$admin_col1_dhl = $_SESSION['admin_col1'][1];
		$admin_col2_dhl  = $_SESSION['admin_col2'][1];
		$admin_col3_dhl  = $_SESSION['admin_col3'][1];
		$admin_col4_dhl  = $_SESSION['admin_col4'][1];
			
		$admin_col1_fedex = $_SESSION['admin_col1'][2];
		$admin_col2_fedex  = $_SESSION['admin_col2'][2];
		$admin_col3_fedex  = $_SESSION['admin_col3'][2];
		$admin_col4_fedex  = $_SESSION['admin_col4'][2];
			
		$admin_col1_loomis = $_SESSION['admin_col1'][3];
		$admin_col2_loomis  = $_SESSION['admin_col2'][3];
		$admin_col3_loomis  = $_SESSION['admin_col3'][3];
		$admin_col4_loomis  = $_SESSION['admin_col4'][3];
			
		$admin_col1_purolator = $_SESSION['admin_col1'][4];
		$admin_col2_purolator  = $_SESSION['admin_col2'][4];
		$admin_col3_purolator  = $_SESSION['admin_col3'][4];
		$admin_col4_purolator  = $_SESSION['admin_col4'][4];
			
		$admin_col1_tnt = $_SESSION['admin_col1'][5];
		$admin_col2_tnt  = $_SESSION['admin_col2'][5];
		$admin_col3_tnt = $_SESSION['admin_col3'][5];
				
		$admin_col1_ups = $_SESSION['admin_col1'][6];
		$admin_col2_ups = $_SESSION['admin_col2'][6];
		$admin_col3_ups = $_SESSION['admin_col3'][6];
		$admin_col4_ups = $_SESSION['admin_col4'][6];
		
		


?>