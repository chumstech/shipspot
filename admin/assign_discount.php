<?php
require_once('../connections/db.php'); 

$para = @$_GET['para'];
$user_email = @$_GET['user_email'];
$msg = @$_GET['msg'];
$Email  = @$_POST['txt_Email'];
$ups = @$_POST['txt_ups'];
$fedex = @$_POST['txt_fedex'];
$canada = @$_POST['txt_canada'];
$purolator = @$_POST['txt_purolator'];
$tnt = @$_POST['txt_tnt'];
$dhl = @$_POST['txt_dhl'];
$loomis = @$_POST['txt_loomis'];
$CBy =$_SESSION['Admin_Email'];
$Submit = @$_POST['Submit'];
$Update = @$_POST['Update'];
var_dump($Email);
die();
		

/*if(isset($user_email))
{
		$QueryString = "select * from discount where User_Email= '$user_email'";		
		$Query = mysql_query($QueryString,@$cn);
		$data = mysql_fetch_array($Query);
			
			$v_user_email = @$data['User_Email'];
			$v_ups = @$data['UPS'];
			$v_fedex = @$data['Fedex'];
			$v_canada = @$data['Canada_post'];
			$v_purolator = @$data['Purolator'];
			$v_tnt = @$data['TnT'];
			$v_dhl = @$data['DHL'];
			$v_loomis = @$data['Loomis'];
		
}*/

if($Submit)
{
	if($Email!="")
	{
			$QueryString = "select * from discount where User_Email= '$Email'";		
			$Query = mysql_query($QueryString,@$cn) or die(mysql_error());
			if(mysql_num_rows($Query)<1)
			{
						$q = "insert into discount 
						(UPS,Fedex,Canada_post,Purolator,TnT,DHL,Loomis,User_Email,CBy)
						values('$ups','$fedex','$canada','$purolator','$tnt','$dhl','$loomis','$Email','$CBy')";
						$res = mysql_query($q,$cn) or die(mysql_error());
								if($res) 
								{
									@$msg= "Values have been inserted!";
									header("location:../index.php?para=7&msg=$msg");				
								}
			
			}
			else
			{
				@$msg= "You should update information!!!";
				header("location:../index.php?para=16&msg=$msg");	
			}
		}
		else
		{
		@$msg= "User Email required!";
		header("location:../index.php?para=16&msg=$msg");	
		}
}

if($Update)
{
	//die(print_r($_POST));
	if($Email!="")
	{
			$q = "update discount 
			set UPS = '$ups',
			Fedex = '$fedex',
			Canada_post = '$canada',
			Purolator ='$purolator',
			TnT = '$tnt',
			DHL = '$dhl',
			Loomis = '$loomis',
			User_Email = '$Email',
			MBy = '$CBy' where User_Email= '$Email'";
					
			$res = mysql_query($q,$cn) or die(mysql_error());
			@$msg= "Values have been Updated!";
			header("location:../index.php?para=7&msg=$msg");		
	}
	else
	{
		@$msg= "User Email required!";
		header("location:../index.php?para=16&msg=$msg");	
	}
}
?>