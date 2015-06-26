<?php
$para = @$_GET['para'];
$msg = @$_GET['msg'];
$star_owner = @$_POST['starowner'];
$First_Name = @$_POST['txt_Fname'];
$Last_Name  = @$_POST['txt_Lname'];
$Address  = @$_POST['txt_Address'];
$Country  = @$_POST['txt_Country'];
$Phone_Number = @$_POST['txt_Phone_number'];
$Email  = @$_POST['txt_Email'];
$Password = @$_POST['txt_Password'];
$Comments = @$_POST['txt_Comments'];
$CBy =	$_SESSION['Admin_Email'];
@$MBy = '';
$Submit = @$_POST['Submit'];



function getStarUsers()
{
	$records = mysql_query("select * from users where user_type=2");
	return $records;
}

$starOwners = getStarUsers();

if($Submit)
{
	   if($Email!="" & $Password!="")
	   {

						if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  
						{
						
							@$msg = 'Incorrect verification code!' ;
							header("location:index.php?para=2&msg=$msg");					
						}
						else
						{

							$res=mysql_query("select *from users where email='$Email'",$cn) or die(mysql_error());
							if(mysql_num_rows($res)<1)
							{
								$q = "insert into users 
								(parent_id, first_name, last_name, address, country, email, password, contact,user_type)
								values('$star_owner','$First_Name','$Last_Name','$Address','$Country','$Email','$Password','$Phone_Number',3)";
								$res = mysql_query($q,$cn) or die(mysql_error());
										if($res) 
										{
											$userID = mysql_insert_id();
											$carriers = getCarriers();
											while($carrier = mysql_fetch_array($carriers))
											{
												$carrierID = $carrier['id'];
												defaultCarrierAllowed($carrierID,$userID,0);
												defaultDiscountAllowed($carrierID,$userID,0);
												defaultPriviligedDiscountAllowed($carrierID,$userID,0);
											}
											@$msg= "Your are registerd now!";
											header("location:index.php?para=2&msg=$msg");				
										}
										else
										{
											
											@$msg="All fields are required";
											header("location:index.php?para=2&msg=$msg");					
										}
							}
							else
							{
								@$msg = "A user has already signed up with the same email address";	
								header("location:index.php?para=2&msg=$msg");					
			
							}
						}
				
		}
		else
		{
			@$msg="Email and Password both are require!";
			header("location:index.php?para=2&msg=$msg");					

		}
}	

?>
<div class="rates">
<div class="message"><?php echo @$msg;?></div>
<div class="image_wrapper_rate">
<h3>Sign Up</h3>
<form style="padding: 20px 3%;" method="post" action="index.php?para=2">
  	<div class="form-group">
  	  <?php if($userObj->user_type == 1){?>
    	<select name="starowner" style="width:31%;">
        	<option value="">Select Star Owner</option>
            <?php $starOwners = getStarUsers(); ?>
      		<?php while ($starowner = mysql_fetch_array($starOwners)){?>
      		<option value="<?php echo $starowner['id']; ?>"><?php echo $starowner['first_name']." ".$starowner['last_name']; ?></option>
		<?php }  ?>
      	</select>
      	<?php }else{?>
      	 <input type="hidden" name="starowner" value="<?php echo $userObj->id;?>"/>
      	<?php }?>
  	</div>
  	<div class="form-group">
    	<input name="txt_Fname" type="text" placeholder="First Name" class="form-control input-lg" style="width:30%;" id="txt_Fname"/>
  	</div>
    <div class="form-group">
    	<input name="txt_Lname" placeholder="Last Name" class="form-control input-lg" style="width:30%;" type="text" id="txt_Lname"/>
  	</div>
    <div class="form-group">
    	<input name="txt_Phone_number" placeholder="Phone" class="form-control input-lg" style="width:30%;" type="text" id="txt_Phone_number"/>
  	</div>
    <div class="form-group">
    	<input name="txt_Email" placeholder="Email" class="form-control input-lg" style="width:30%;" type="text" id="txt_Email"/>
  	</div>
    <div class="form-group">
    	<input name="txt_Password" placeholder="Password" class="form-control input-lg" style="width:30%;" type="password" id="txt_Password"/>
  	</div>
    <div class="form-group">
    	<input name="txt_Address" placeholder="Address" class="form-control input-lg" style="width:30%;" type="text" id="txt_Address"/>
  	</div>
    <div class="form-group">
    	<select name="txt_Country" style="width:31%;">
        	<option value="">Select Your Country</option>
            <?php $countries = getCountries(); ?>
      		<?php foreach ($countries as $country){?>
      		<option value="<?php echo $country['cid']; ?>"><?php echo $country['name']; ?></option>
		<?php }  ?>
      	</select>
  	</div>
    <div class="form-group">
    	<img src="./images/captcha.php" />
  	</div>
    <div class="form-group">
    	<input name="vercode" placeholder="Please enter above Captcha code here" class="form-control input-lg" style="width:30%;" type="text" id="vercode"/>
  	</div>
    <div class="form-group">
  	<textarea name="txt_Comments" id="txt_Comments" class="" style="width: 50%; height: 145px;" placeholder="Enter Your Comments"></textarea>
  </div>
  <input name="Submit" class="btn btn-primary" type="submit" id="Submit" value="Submit" />
        <span class="button float_r">
        <input name="cancel" class="btn btn-default" type="reset" id="cancel" value="Cancel" />
      </span>
</form>
</div>
</div>