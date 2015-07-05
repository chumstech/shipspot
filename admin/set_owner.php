<?php
$userObj = "";
if(isset($_SESSION['user'])){
	$userObj = (object)	$_SESSION['user'];
}
$para = @$_GET['para'];
$msg = @$_GET['msg'];
$user_id = @$_GET['user_id'];

$owner_posted = @$_POST['txt_owner'];
$show_posted = @$_POST['show_posted'];
$show_disc = @$_POST['show_disc'];
$mby = $_SESSION['Admin_Email'];
$Submit = @$_POST['Submit'];

$userups 	= @$_POST['ups'];
$userfedex 	= @$_POST['fedex'];
$usercanada = @$_POST['canada'];
$userpurolator = @$_POST['purolator'];
$usertnt 	= @$_POST['tnt'];
$userdhl 	= @$_POST['dhl'];
$userloomis = @$_POST['loomis'];
$userprivilege_discount = @$_POST['privilege_discount'];

$Update = isset($_POST['Update']);

/********** assign privillege discount fields *****************/

//$aEmail  = @$_POST['atxt_Email'];
$aups = @$_POST['atxt_ups'];
$afedex = @$_POST['atxt_fedex'];
$acanada = @$_POST['atxt_canada'];
$apurolator = @$_POST['atxt_purolator'];
$atnt = @$_POST['atxt_tnt'];
$adhl = @$_POST['atxt_dhl'];
$aloomis = @$_POST['atxt_loomis'];
$aCBy =$_SESSION['Admin_Email'];

/********** assign discount fields *****************/

$Email  = @$_POST['txt_Email'];
$ups = @$_POST['txt_ups'];
$fedex = @$_POST['txt_fedex'];
$canada = @$_POST['txt_canada'];
$purolator = @$_POST['txt_purolator'];
$tnt = @$_POST['txt_tnt'];
$dhl = @$_POST['txt_dhl'];
$loomis = @$_POST['txt_loomis'];
$CBy =$_SESSION['Admin_Email'];





if($Submit)
{

	$privilege_discount = @$_POST['privilege_discount'];
 if (@$_SESSION['Admin_Email'] && @$_SESSION['Owner'] == "self")
		{
	$QueryString = "update users set 
									owner ='$owner_posted',
									Posted_Rates ='$show_posted', 
									Discounted_Rates = '$show_disc', 
									privilege_discount = '$privilege_discount',
									UPS 	= '$userups',
									FEDEX 	= '$userfedex',
									CANADAPOST 	= '$usercanada',
									PUROLATOR 	= '$userpurolator',
									TNT 	= '$usertnt',
									DHL 	= '$dhl',	
									LOOMIS	= '$userloomis',
									MBy = '$usermby' 
					where User_Id= '$User_Id'";
		}
		else
		{
		$QueryString = "update users set 
									Posted_Rates ='$show_posted', 
									Discounted_Rates = '$show_disc', 
									privilege_discount = '$privilege_discount',
									UPS 	= '$userups',
									FEDEX 	= '$userfedex',
									CANADAPOST 	= '$usercanada',
									PUROLATOR 	= '$userpurolator',
									TNT 	= '$usertnt',
									DHL 	= '$userdhl',	
									LOOMIS	= '$userloomis',
									MBy = '$usermby' 
					where User_Id= '$User_Id'";
		
		}
	$Query = mysql_query($QueryString,@$cn) 
	or 
	die(mysql_error());
	$msg = "Values has been updated for $Email".$UPS;
		
	
	
	
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
									//header("location:../index.php?para=7&msg=$msg");				
								}
			
			}
			else
			{
				@$msg= "You should update information!!!";
				//header("location:../index.php?para=16&msg=$msg");	
			}
		}
		else
		{
		@$msg= "User Email required!";
		//header("location:../index.php?para=16&msg=$msg");	
		}

			

	if($Email!="")
	{
			$QueryString = "select * from privilege_discount where User_Email= '$Email'";		
			$Query = mysql_query($QueryString,@$cn) or die(mysql_error());
			if(mysql_num_rows($Query)<1)
			{
						$q = "insert into privilege_discount 
						(UPS,Fedex,Canada_post,Purolator,TnT,DHL,Loomis,User_Email,CBy)
						values('$aups','$afedex','$acanada','$apurolator','$atnt','$adhl','$aloomis','$Email','$aCBy')";
						$res = mysql_query($q,$cn) or die(mysql_error());
								if($res) 
								{
									@$msg= "Values have been inserted!";
									//header("location:index.php?para=16&msg=$msg");				
								}
			
			}
			else
			{
				@$msg= "You should update information!!!";
			//	header("location:index.php?para=16&msg=$msg");	
			}
		}
		else
		{
		@$msg= "User Email required!";
		header("location:index.php?para=16&msg=$msg");	
	//	header("location:../index.php?para=16&msg=$msg");	
		}
       header("location:index.php?para=7&msg=$msg");				

}

if($Update)
{
$parent_id = @$_POST['txt_owner'];
$is_posted_rate = @$_POST['show_posted'];
$is_discounted_rate = @$_POST['show_disc'];
$is_privilege_discount = @$_POST['privilege_discount'];
	

	$QueryString = "update users set parent_id =$parent_id, is_posted_rate =$is_posted_rate, is_discounted_rate = $is_discounted_rate, is_privilege_discount = $is_privilege_discount where id= $user_id";
	
	$res = mysql_query($QueryString,$cn) or die(mysql_error());
	
	//updating General Carriers Allowed
	if($res)
	{
		$carriers = getCarriers();
		while($carrier = mysql_fetch_array($carriers))
		{
			$carrierName = str_replace(' ', '_', strtolower($carrier['name']));
			$carrierId = $carrier['id'];
			$value = $_POST[$carrierName];
			if($value != 1)
			{
				$value = 0;
			}
			//echo $carrierId." ".$value;
			//die();
			updateCarrierAllowed($carrierId,$user_id,$value);
		}
			
		//UPDATEING Users Discounts for Carriers;
		$carriers = getCarriers();
		while($carrier = mysql_fetch_array($carriers))
		{
			$carrierName = str_replace(' ', '_', strtolower($carrier['name']))."_discount";
			$carrierId = $carrier['id'];
			$discount = $_POST[$carrierName];
			updateCarrierDiscount($carrierId,$user_id,$discount);
		}
		
		//UPDATEING Users Privileged Discounts for Carriers;
		$carriers = getCarriers();
		while($carrier = mysql_fetch_array($carriers))
		{
			$carrierName = str_replace(' ', '_', strtolower($carrier['name']))."_p_discount";
			$carrierId = $carrier['id'];
			$privilege_discount = $_POST[$carrierName];
			updateCarrierPriviligedDiscount($carrierId,$user_id,$privilege_discount);
		}
		
		@$msg= "User Data Updated Successfully!";
		header("location:index.php?para=7&msg=$msg");		
	}
			
}


$QueryString = "select * from users where id= '$user_id'";
$Query = mysql_query($QueryString,@$cn);
while($data = mysql_fetch_array($Query))
{
	$First_Name = @$data['first_name'];
	$Last_Name  =@$data['last_name']; 
	$Address  =@$data['address'];
	$Country  = @$data['country'];
	$Phone_Number = @$data['contact'];
	$Email  = @$data['email'];
	$owner  = @$data['parent_id'];	  
	$Posted_Rates  = @$data['is_posted_rate'];
	$privilege_discount = @$data['is_privilege_discount'];	  
	$Discounted_Rates  = @$data['is_discounted_rate'];
  	$DB_UPS  = @$data['UPS'];	  
  	$DB_FEDEX  = @$data['FEDEX'];	  
  	$DB_CANADAPOST  = @$data['CANADAPOST'];	  
  	$DB_PUROLATOR  = @$data['PUROLATOR'];	  
  	$DB_TNT  = @$data['TNT'];	  
  	$DB_LOOMIS  = @$data['LOOMIS'];	  
	$DB_DHL =  @$data['DHL'];
	$parentId =  @$data['parent_id'];
}


?>
<style>
label {
  float: left;
  line-height: 25px;
  margin-right: 5px;
}
select {
  width: auto;
  background-color: #fff;
  border: 1px solid #ccc;
}
input, textarea, .uneditable-input {
  width: auto;
}
</style>
<form id="" name="form1" method="post" action="">
	<div class="container-fluid">
    	<h2 style="margin-bottom: 5px;">User Personal Info</h2>
        <div class="row-fluid">
    		<div class="span6">
        		<?php echo @$First_Name." ".@$Last_Name."<br/>"; ?>
                <?php echo @$Address." ".getCountryByCode(@$data['country'])."<br/>"; ?>
 				<?php echo "Phone : ".@$Phone_Number."<br/>"; ?>
    			<?php echo "Email : ".@$Email."<br/>"; ?>
                <div class="form-group">
            		<label style="">User Owner</label>
                  	  <?php if ($userObj->user_type == 1 && $userObj->email) 
						{
					  ?>
					  <select name="txt_owner" id="txt_owner" >  
					  <?php
						$QueryString = "select distinct * from users where user_type = 2";
						$Query = mysql_query($QueryString);
						while($data = mysql_fetch_array($Query)){
							if($parentId == $data['id']){
							  $selected = 'selected="selected"';
							}else{
							  $selected = '';
							}
					   ?>
						  <option <?php echo $selected;?> value="<?php echo @$data['id'];?>" ><?php echo @$data['first_name']." ".@$data['last_name'];?></option>
						<?php
						}
						?>
					  </select><?php }?>
					  <?php if ($userObj->user_type == 2 && $userObj->email) 
						{
					  ?>
					  <input type="hidden" name="txt_owner" value="<?php echo @$owner; ?>"/>
						  <?php echo getUserName($owner);?>  
					  <?php }?>
              </div>
         	</div>
        </div>
		<div class="row-fluid">
            <div class="span4">
            <h2 style="margin-bottom: 5px;margin-top: 15px;width: 100%;">User Settings</h2>
            	<div class="form-group">
            		<label style="min-width:160px;">Show Posted Rates</label>
            		<select class="form-control" name="show_posted" id="show_posted">  
                        <option <?php if($Posted_Rates == '1') { echo 'selected="selected"';}?> value="1">Yes</option>
                        <option <?php if($Posted_Rates == '0') { echo 'selected="selected"';}?> value="0">No</option>
                     </select>
            	</div>
                <div class="form-group">
            		<label style="min-width:160px;">Show Discounted Rates</label>
            		<select class="form-control" name="show_disc" id="show_disc">   
                        <option <?php if($Discounted_Rates == '1') { echo 'selected="selected"';}?> value="1">Yes</option>
                        <option <?php if($Discounted_Rates == '0') { echo 'selected="selected"';}?> value="0">No</option>
                      </select>
            	</div>
                <div class="form-group">
            		<label style="min-width:160px;">Privilege Discount Enable</label>
            		<select class="form-control" name="privilege_discount" id="privilege_discount">	   
                        <option <?php if($privilege_discount == '1') { echo 'selected="selected"';}?> value="1">Yes</option>
                        <option <?php if($privilege_discount == '0') { echo 'selected="selected"';}?> value="0">No</option>
                      </select>
            	</div>
            	<?php $carriers = getCarriers();
				$carriersOptions = '';
					while($carrier = mysql_fetch_array($carriers))
					{
						//var_dump($carrier);
						$DB_Carrier = checkCarrierAllowed($carrier['id'],$user_id);
						if($DB_Carrier =='1'){ $checked = 'checked="checked"'; } else { $checked = '';}
						$carriersOptions .= '<div class="form-group" style="float:left; width:100%;">';
						  $carriersOptions .= '<label style="min-width:140px;">'.$carrier['name'].' Enabled</label>';
						  $carriersOptions .= '<td><input type="checkbox" style="margin-top: 5px;" class="form-control" name="'.str_replace(' ', '_', strtolower($carrier['name'])).'" value="1" '.$checked.'/></td>';
						$carriersOptions .= '</div>';
					}
					echo $carriersOptions;
				?>
         	</div>
            <div class="span4">
        		<h2 style="margin-bottom: 5px;margin-top: 15px;width: 100%;">Assign Discounts</h2>
            	<?php $carriers = getCarriers();
					$carriersOptions = '';
						while($carrier = mysql_fetch_array($carriers))
						{
							$DB_Carrier_Discount = checkCarrierDiscount($carrier['id'],$user_id);
							$carriersDiscountOptions .= '<div class="form-group">';
								$carriersDiscountOptions .= '<label style="min-width:100px;">'.$carrier['name'].' %</label>';
								$carriersDiscountOptions .= '<input style="max-width:50px" name="'.str_replace(' ', '_', strtolower($carrier['name'])).'_discount" type="text" id="'.str_replace(' ', '_', strtolower($carrier['name'])).'_discount" class="form-control" value="'.$DB_Carrier_Discount.'" />';
							$carriersDiscountOptions .= '</div>';
						}
						echo $carriersDiscountOptions;
					?>
         	</div>
            <div class="span4">
        		<h2 style="margin-bottom: 5px;margin-top: 15px;width: 100%;">Assign Privilege Discounts</h2>
                <?php $carriers = getCarriers();
					$carriersOptions = '';
						while($carrier = mysql_fetch_array($carriers))
						{
							//var_dump($carrier);
							$DB_Carrier_P_Discount = checkCarrierPriviligedDiscount($carrier['id'],$user_id);
							$carriersPDiscountOptions .= '<div class="form-group">';
								$carriersPDiscountOptions .= '<label style="min-width:100px;">'.$carrier['name'].' %</label>';
								$carriersPDiscountOptions .= '<td><input style="max-width:50px" name="'.str_replace(' ', '_', strtolower($carrier['name'])).'_p_discount" type="text" id="'.str_replace(' ', '_', strtolower($carrier['name'])).'_discount" class="form-control" value="'.$DB_Carrier_P_Discount.'" /></td>';
							$carriersPDiscountOptions .= '</div>';
						}
						echo $carriersPDiscountOptions;
				?>
            </div>
         </div>
         <div class="row-fluid">
    		<div class="span6">
            	<div class="form-group" style="margin-top:10px;">
				  <?php if(isset($_GET['user_id'])){ ?>
                  <input name="Update" class="btn btn-primary" type="submit" id="submit" value="Update" i />
                  <?php }else{?>
                  <input name="Submit" class="btn btn-primary" type="submit" id="Submit" value="Submit" /> 
                  <?php }?>
                 </div>
      		</div>
      	</div>
  	</div>
  </form>
<!--</form>-->

<style>
@media (max-width: 859px) and (min-width: 540px)
{
#content_wrapper .span4 h2 {
  background: grey none repeat scroll 0 0;
  border-radius: 3px;
  color: rgb(255, 255, 255);
  font-size: 15px !important;
  line-height: 20px;
  margin: 0 0 20px;
  padding: 10px 0 10px 3%;
  width: 97%;
}
}
h2 {
    color: #000;
    font-size: 20px;
    font-weight: normal;
    line-height: 30px;
    margin: 0 0 30px;
    padding: 0;
}
</style>

