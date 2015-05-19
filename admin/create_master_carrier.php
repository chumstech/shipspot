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
<div class="rates">
<div class="message"><?php echo @$msg;?></div>
<div class="image_wrapper_rate">
<h3>Create Carriers</h3>
<form style="padding: 20px 3%;">
  <div class="form-group">
    <?php if(isset($carrier_id)){ echo @$v_name; } else {?>
	  <input name="txt_name" placeholder="Carrier Name" style="width: 30%;" class="form-control input-lg" type="text" id="txt_name" value=""/>
	<?php } ?>
  </div>
  <div class="form-group">
    <input name="txt_key" placeholder="Key / CPCID" style="width: 30%;" type="text" id="txt_key" value="<?php echo @$v_key; ?>"/>
  </div>
  <div class="form-group">
    <input name="txt_password" placeholder="Password" style="width: 30%;" type="text" id="txt_password" value="<?php echo @$v_password; ?>"/>
  </div>
  <div class="form-group">
		<input name="txt_account_number" style="width: 30%;" placeholder="Account Number / Billing Account" type="text" id="txt_account_number" value="<?php echo @$v_account; ?>"/>
  </div>
  <div class="form-group">
    <input name="txt_shipper_number" style="width: 30%;" placeholder="Shipper Number/ Meter Number / Registerd Account Number" type="text" id="txt_shipper_number" value="<?php echo @$v_other; ?>"/>
  </div>
  <div class="form-group">
    <input placeholder="User Email ID" style="width: 30%;" name="txt_user" type="text" id="txt_user" value="<?php echo @$v_email; ?>"/>
  </div>
  <div class="form-group">
  	<textarea name="txt_otherinfo" id="txt_otherinfo" class="" style="width: 50%; height: 145px;" placeholder="Other Information"><?php echo @$v_otherinfo; ?></textarea>
  </div>
  <?php if(!isset($carrier_id)){?><input class="btn btn-primary" name="Submit" type="submit" id="Submit" value="Submit" /> <?php } else {?>
        <input name="Update" class="btn btn-primary" type="submit" id="Update" value="Update" /><?php } ?>
      <input name="cancel" class="btn btn-default" type="reset" id="cancel" value="Cancel" />      
</form>
</div>
</div>