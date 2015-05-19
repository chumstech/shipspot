<?php
session_start();
require_once('../connections/db.php'); 
$Email=$_POST["txt_Email"];
$Password=$_POST["txt_Password"];
if(isset($_SESSION['Email']))
{
	$msg =  "You are already loged in with user name ".$_SESSION['Email']." !";
	header("location:../index.php?para=1&msg=$msg");
}
else if(isset($_SESSION['Admin_Email']))
{
	$msg =  "You are already loged in with user name ".$_SESSION['Admin_Email']." !";
	header("location:../index.php?para=1&msg=$msg");
}
else if($Email!="" or $Password!="")
{
	$rs = mysql_query("select  * from users where Email='$Email' AND Password='$Password' ",$cn)or die(mysql_error());
	$row = mysql_fetch_array($rs,MYSQL_ASSOC);
	
      if(!$row)
		{
			$msg ="Invalid User Name or Password";
			header("location:../index.php?para=1&msg=$msg");
	
		}
		elseif($Password != $row['password'])
		{
			$msg =  "Your Password is Not Match...!";
			header("location:../index.php?para=1&msg=$msg");
		}
		else
		{
			   $_SESSION['user'] = $row;
				header("location:../index.php?para=3");
		}
}
else
{
	$msg =  "Email and Password both are required for login...!";
	header("location:../index.php?para=1&msg=$msg");
}
	
	function setSession($dbowner,$Email,$cn)
	{
		
		         
				$c1 = mysql_query("select * from carriers where User_Email='$dbowner' and carrier_name = 'UPS' ",@$cn)or die(mysql_error());
				$c2 = mysql_query("select * from carriers where User_Email='$dbowner' and carrier_name = 'Fedex' ",@$cn)or die(mysql_error());
				$c3 = mysql_query("select * from carriers where User_Email='$dbowner' and carrier_name = 'Canada Post' ",@$cn)or die(mysql_error());
				$c4 = mysql_query("select * from carriers where User_Email='$dbowner' and carrier_name = 'Purolator' ",@$cn)or die(mysql_error());
				$c5 = mysql_query("select * from carriers where User_Email='$dbowner' and carrier_name = 'TnT' ",@$cn)or die(mysql_error());
				$c8 = mysql_query("select * from discount where User_Email='$Email'",@$cn)or die(mysql_error());
				$c9 = mysql_query("select * from privilege_discount where User_Email='$Email'",@$cn)or die(mysql_error());
				//echo "select * from discount where User_Email='".$Email."' ";
				/*$c5 = mysql_query("select * from carriers where User_Email='$Email' and carrier_name = 'TnT' ",$cn)or die(mysql_error());
				$c6 = mysql_query("select * from carriers where User_Email='$Email' and carrier_name = 'DHL' ",$cn)or die(mysql_error());
				$c7 = mysql_query("select * from carriers where User_Email='$Email' and carrier_name = 'Loomis' ",$cn)or die(mysql_error());*/
							
				$C1row = mysql_fetch_array($c1);
				$C2row = mysql_fetch_array($c2);
				$C3row = mysql_fetch_array($c3);
				$C4row = mysql_fetch_array($c4);
				$C5row = mysql_fetch_array($c5);
				/*$C6row = mysql_fetch_array($c6);
				$C7row = mysql_fetch_array($c7);*/
				$C8row = mysql_fetch_array($c8);
				$C9row = mysql_fetch_array($c9);
				//print_r($C8row);
				//die();
				
				$_SESSION['col1_ups'] = $C1row['carrier_key'];
				$_SESSION['col2_ups'] = $C1row['carrier_password'];
				$_SESSION['col3_ups'] = $C1row['carrier_account_number'];
				$_SESSION['col4_ups'] = $C1row['carrier_other_number'];
				$_SESSION['discount_ups'] = $C8row['UPS']/100;
				$_SESSION['privilege_discount_ups'] = $C9row['UPS']/100;
				
					
				$_SESSION['col1_fedex'] = $C2row['carrier_key'];
				$_SESSION['col2_fedex'] = $C2row['carrier_password'];
				$_SESSION['col3_fedex'] = $C2row['carrier_account_number'];
				$_SESSION['col4_fedex'] = $C2row['carrier_other_number'];
				$_SESSION['discount_fedex'] = $C8row['Fedex']/100;
				$_SESSION['privilege_discount_fedex'] = $C9row['Fedex']/100;
					
				$_SESSION['col1_canada'] = $C3row['carrier_key'];
				$_SESSION['col2_canada'] = $C3row['carrier_password'];
				$_SESSION['col3_canada'] = $C3row['carrier_account_number'];
				$_SESSION['col4_canada'] = $C3row['carrier_other_number'];
				$_SESSION['discount_canada'] = $C8row['Canada_post'];
				$_SESSION['privilege_discount_canada_post'] = $C9row['Canada_post']/100;
					
				$_SESSION['col1_purolator'] = $C4row['carrier_key'];
				$_SESSION['col2_purolator'] = $C4row['carrier_password'];
				$_SESSION['col3_purolator'] = $C4row['carrier_account_number'];
				$_SESSION['col4_purolator'] = $C4row['carrier_other_number'];
				$_SESSION['discount_purolator'] = $C8row['Purolator']/100;	
				$_SESSION['privilege_discount_purolator'] = $C9row['Purolator']/100;
				
				$_SESSION['col1_tnt'] = $C5row['carrier_key'];
				$_SESSION['col2_tnt'] = $C5row['carrier_password'];
				$_SESSION['col3_tnt'] = $C5row['carrier_account_number'];
				$_SESSION['col4_tnt'] = $C5row['carrier_other_number'];
				$_SESSION['discount_tnt'] = $C8row['TnT']/100;	
				$_SESSION['privilege_discount_tnt'] = $C9row['TnT']/100;

					
				/*$_SESSION['col1_dhl'] = $C6row['carrier_key'];
				$_SESSION['col2_dhl'] = $C6row['carrier_password'];
				$_SESSION['col3_dhl'] = $C6row['carrier_account_number'];
				$_SESSION['col4_dhl'] = $C6row['carrier_other_number'];
					
				$_SESSION['col1_loomis'] = $C7row['carrier_key'];
				$_SESSION['col2_loomis'] = $C7row['carrier_password'];
				$_SESSION['col3_loomis'] = $C7row['carrier_account_number'];
				$_SESSION['col4_loomis'] = $C7row['carrier_other_number'];*/
				
	}
	
?>