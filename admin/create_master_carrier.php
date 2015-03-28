<?php
$para = @$_GET['para'];
$carrier_id = @$_GET['Carrier_Id'];
$msg = @$_GET['msg'];
$name = @$_POST['txt_name'];
$user_email = @$_POST['txt_user'];
$key = @$_POST['txt_key'];
$password  = @$_POST['txt_password'];
$account_number  = @$_POST['txt_account_number'];
$shipper_number  = @$_POST['txt_shipper_number'];
$otherinfo  = @$_POST['txt_otherinfo'];
$mby = $_SESSION['Admin_Email'];
$Submit = @$_POST['Submit'];
$Update = @$_POST['Update'];

if(isset($carrier_id))
{
		$QueryString = "select * from carriers where carrierr_Id= '$carrier_id'";
		$Query = mysql_query($QueryString,@$cn);
		$data = mysql_fetch_array($Query);
		
		$v_name = @$data['carrier_name'];
        $v_key = @$data['carrier_key'];
        $v_password = @$data['carrier_password'];
        $v_account = @$data['carrier_account_number'];
        $v_other = @$data['carrier_other_number'];
        $v_otherinfo = @$data['carrier_otherinfo'];
        $v_email = @$data['User_Email'];		
}

if($Update)
{
	   if($key!="")
	   {

							$q=mysql_query("update carriers set  
							carrier_key = '$key', carrier_password = '$password', 
							carrier_account_number = '$account_number', 
							carrier_other_number = '$shipper_number', 
							MBy = '$mby', 
							carrier_otherinfo = '$otherinfo',
							MBy = '$mby'
							where carrierr_Id= '$carrier_id'",$cn);
						
						if($q)
						{					
							@$msg= "Carrier has been updated now!";
							header("location:index.php?para=14&msg=$msg");			
						}
						else
						{						
							@$msg= "Updation failed due to missing information!";
							header("location:index.php?para=14&msg=$msg");			
						}	
											
		}
		else
		{
			@$msg="Name and Key both are require!";
			header("location:index.php?para=9&Carrier_Id=$carrier_id&msg=$msg");					

		}
}	




////////////////////////////////
if($Submit)
{
	   if($name!="" & $key!="")
	   {

							$res=mysql_query("select *from carriers where carrier_name ='$name' and User_Email = '$user_email'",$cn) or die(mysql_error());
							if(mysql_num_rows($res)<1)
							{
								$q = "insert into carriers 
								(carrier_name, carrier_key, carrier_password, carrier_account_number, carrier_other_number, User_Email, carrier_otherinfo,CBy,MBy)
								values('$name','$key','$password','$account_number','$shipper_number','$user_email','$otherinfo','$mby','')" or die(mysql_error());
								$res = mysql_query($q,$cn) ;
										if($res)
										{
											@$msg= "Carrier has been added now!";
											header("location:index.php?para=9&msg=$msg");				
										}
										else
										{
											
											@$msg="All fields are required";
											header("location:index.php?para=9&msg=$msg");					
										}
							}
							else
							{
								@$msg = "Carrier already exist with same name";	
								header("location:index.php?para=9&msg=$msg");					
							}
				
		}
		else
		{
			@$msg="Name and Key both are require!";
			header("location:index.php?para=9&msg=$msg");					

		}
}	


?>

<form id="form1" name="form1" method="post" action="">
  <table width="59%" height="422" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><?php echo @$msg;?></td>
    </tr>
    <tr>
      <td colspan="2"><h2>Create Carriers</h2></td>
    </tr>
    <tr>
      <td width="64%">Carrier Name</td>
      <td width="36%"><?php if(isset($carrier_id)){ echo @$v_name; } else {?>
	  <input name="txt_name" type="text" id="txt_name" value=""/><?php } ?></td>
    </tr>
    <tr>
      <td>Key / CPCID </td>
      <td><input name="txt_key" type="text" id="txt_key" value="<?php echo @$v_key; ?>"/></td>
    </tr>
    <tr>
      <td>Password </td>
      <td><input name="txt_password" type="text" id="txt_password" value="<?php echo @$v_password; ?>"/></td>
    </tr>
    <tr>
      <td> Account Number / Billing Account </td>
      <td><input name="txt_account_number" type="text" id="txt_account_number" value="<?php echo @$v_account; ?>"/></td>
    </tr>
    <tr>
      <td>Shipper Number/ Meter Number / Registerd Account Number </td>
      <td><input name="txt_shipper_number" type="text" id="txt_shipper_number" value="<?php echo @$v_other; ?>"/></td>
    </tr>
    <tr>
      <td>Other Information </td>
      <td><input name="txt_otherinfo" type="text" id="txt_otherinfo" value="<?php echo @$v_otherinfo; ?>"/></td>
    </tr>
    <tr>
      <td>User Email Id </td>
      <td><input name="txt_user" type="text" id="txt_user" value="<?php echo @$v_email; ?>"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><?php if(!isset($carrier_id)){?><input name="Submit" type="submit" id="Submit" value="Submit" /> <?php } else {?>
        <input name="Update" type="submit" id="Update" value="Update" /><?php } ?>
      <input name="cancel" type="reset" id="cancel" value="Cancel" />      </td>
    </tr>
  </table>
</form>
