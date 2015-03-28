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
	$row = mysql_fetch_array($rs);
	$dbemail=$row["Email"];
	$dbpass=$row["Password"];
	$dbowner=$row["owner"];
	$dbposted_rates =$row["Posted_Rates"];
	$dbdisc_rates =$row["Discounted_Rates"];
	$dbpridisc_rates =$row["privilege_discount"];
	
	//for admin site
	/*$rs_admin = mysql_query("select User_Id,Email,Password,Owner,Posted_Rates,Discounted_Rates from admin_users where Email='$Email' AND Password='$Password' ",$cn)or die(mysql_error());
	$row_admin = mysql_fetch_array($rs_admin);
	$admin_dbemail=$row_admin["Email"];
	$admin_dbpass=$row_admin["Password"];
	$admin_dbOwner=$row_admin["Owner"];
	$admin_dbposted_rates =$row_admin["Posted_Rates"];
	$admin_dbdisc_rates =$row_admin["Discounted_Rates"];
	$admin_dbpridisc_rates =$row["privilege_discount"];*/
		
	
		if($dbemail==$Email && $dbpass==$Password )  // there should be a confirm  user
		{
				$_SESSION['Email'] = $Email;
				$_SESSION['Password'] = $Password;
				$_SESSION['Posted_Rate_Flag'] = $dbposted_rates;
				$_SESSION['Disc_Rate_Flag'] = $dbdisc_rates;
				$_SESSION['Pri_Disc_Rate_Flag'] = $dbpridisc_rates;
				$_SESSION['DB_UPS']  = @$row['UPS'];	  
				$_SESSION['DB_FEDEX']  = @$row['FEDEX'];	  
				$_SESSION['DB_CANADAPOST']  = @$row['CANADAPOST'];	  
				$_SESSION['DB_PUROLATOR']  = @$row['PUROLATOR'];	  
				$_SESSION['DB_TNT']  = @$row['TNT'];	  
				$_SESSION['DB_LOOMIS']  = @$row['LOOMIS'];	  
				$_SESSION['DB_DHL'] =  @$row['DHL'];
				setSession($dbowner,$Email,$cn);				//set accounts variable for each carrier for login client 
				$msg =  "Welcome User!";
				header("location:../index.php?para=15&msg=$msg");					
		}
		else if($admin_dbemail == $Email&& $admin_dbpass==$Password) 
		{
				$_SESSION['Admin_Email'] = $Email;
				$_SESSION['Owner'] = $admin_dbOwner;
				$_SESSION['Posted_Rate_Flag'] = $admin_dbposted_rates;
				$_SESSION['Disc_Rate_Flag'] = $admin_dbdisc_rates;
				$_SESSION['Pri_Disc_Rate_Flag'] = $admin_dbpridisc_rates;
				$_SESSION['User_Id'] = $row_admin['User_Id'];
				
				//$_SESSION['discount']= $admin_dbdiscount;
				setSession($admin_dbOwner,$Email,$cn);					//set accounts variable for each carrier for admin or star user 

				$msg =  "Welcome Admin!";
				header("location:../index.php?para=6&msg=$msg");			
		}	
		else if(!$row)
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