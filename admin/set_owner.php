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

$Update = @$_POST['Update'];

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
									DHL 	= '$userdhl',	
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

	$res = mysql_query($QueryString,$cn) or die(mysql_error());
	
	//die(print_r($_POST));
	if($Email!="")
	{
			$q = "update privilege_discount 
			set UPS = '$aups',
			Fedex = '$afedex',
			Canada_post = '$acanada',
			Purolator ='$apurolator',
			TnT = '$atnt',
			DHL = '$adhl',
			Loomis = '$aloomis',
			User_Email = '$Email',
			MBy = '$aCBy' where User_Email= '$Email'";
					
			$res = mysql_query($q,$cn) or die(mysql_error());
			@$msg= "Values have been Updated!";
		//	header("location:../index.php?para=7&msg=$msg");		
	}
	else
	{
		@$msg= "User Email required!";
		header("location:index.php?para=13&msg=$msg");	
	}

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
			//header("location:../index.php?para=7&msg=$msg");		
	}
	else
	{
		@$msg= "User Email required!";
		header("location:index.php?para=16&msg=$msg");	
	}

}


$user_email = @$_GET['user_email'];
if(isset($user_email))
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
		
}


if(isset($user_email))
{
		$QueryStringP = "select * from privilege_discount where User_Email= '$user_email'";		
		$QueryP = mysql_query($QueryStringP,@$cn);
		$dataP = mysql_fetch_array($QueryP);
			
			$p_user_email = @$dataP['User_Email'];
			$p_ups = @$dataP['UPS'];
			$p_fedex = @$dataP['Fedex'];
			$p_canada = @$dataP['Canada_post'];
			$p_purolator = @$dataP['Purolator'];
			$p_tnt = @$dataP['TnT'];
			$p_dhl = @$dataP['DHL'];
			$p_loomis = @$dataP['Loomis'];
		
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
}


?>

<form id="" name="form1" method="post" action="">
<div id="form1">
  <table width="100%" height="454" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><?php echo @$msg;?></td>
    </tr>
    <tr>
      <td colspan="2"><h2>Client Configuration  </h2></td>
    </tr>
    <tr>
      <td width="52%">First Name: </td>
      <td width="48%"><?php echo @$First_Name; ?></td>
    </tr>
    <tr>
      <td>Last Name : </td>
      <td><?php echo @$Last_Name; ?></td>
    </tr>
    <tr>
      <td>Address: </td>
      <td><?php echo @$Address; ?></td>
    </tr>
    <tr>
      <td>Country: </td>
      <td><?php echo @$Country;?></td>
    </tr>
    <tr>
      <td>Phone: </td>
      <td><?php echo @$Phone_Number;?></td>
    </tr>
    <tr>
      <td>Email:</td>
      <td><?php echo @$Email;?></td>
    </tr>
    <tr>
      <td height="41">Owner : </td>
      <td> 
	  <?php if ($userObj->user_type == 3 && $userObj->email) 
		{
	  ?>
	  <select name="txt_owner" id="txt_owner" >  
	  <?php
	  	$QueryString = "select distinct * from users where user_type = 2";
		$Query = mysql_query($QueryString);
		while($data = mysql_fetch_array($Query)){
	   ?>
          <option value="<?php echo @$data['id'];?>" ><?php echo @$data['first_name']." ".@$data['last_name'];?></option>
		<?php
		}
		?>
      </select><?php }?>
      <?php if ($userObj->user_type == 1 && $userObj->email) 
		{
	  ?>
	  <select name="txt_owner" id="txt_owner" >
 		  <option selected="<?php echo @$owner;?>"><?php echo getUserName($owner);?></option>	   
      </select><?php }?>
      </td>
    </tr>
    <tr>
      <td>Show Posted Rates : </td>
      <td><select name="show_posted" id="show_posted">  
        <option <?php if($Posted_Rates == '1') { echo 'selected="selected"';}?> value="1">Yes</option>
        <option <?php if($Posted_Rates == '0') { echo 'selected="selected"';}?> value="0">No</option>
      </select>      </td>
    </tr>
    <tr>
      <td>Show Discounted Rates : </td>
      <td><select name="show_disc" id="show_disc">   
        <option <?php if($Discounted_Rates == '1') { echo 'selected="selected"';}?> value="1">Yes</option>
        <option <?php if($Discounted_Rates == '0') { echo 'selected="selected"';}?> value="0">No</option>
      </select></td>
    </tr>
    <tr>
      <td>Privilege Discount Enable: </td>
      <td><select name="privilege_discount" id="privilege_discount">	   
        <option <?php if($privilege_discount == '1') { echo 'selected="selected"';}?> value="1">Yes</option>
        <option <?php if($privilege_discount == '0') { echo 'selected="selected"';}?> value="0">No</option>
      </select></td>
    </tr>
    <?php $carriers = getCarriers();
	$carriersOptions = '';
		while($carrier = mysql_fetch_array($carriers))
		{
			if($DB_UPS =='1'){ $checked = 'checked="checked"'; } else { $checked = '';}
			$carriersOptions .= '<tr>';
			  $carriersOptions .= '<td>'.$carrier['name'].' Enabled : </td>';
			  $carriersOptions .= '<td><input type="checkbox" name="'.str_replace(' ', '_', strtolower($carrier['name'])).'" value="1" '.$checked.'/></td>';
			$carriersOptions .= '</tr>';
		}
		echo $carriersOptions;
	?>
  </table>
  </div>


<!--<form id="form_discount" name="form_discount" method="post" action="admin/assign_discount.php">-->
<div id="form_discount">
  <table width="100%" border="0" align="center">
    <tr>
      <td colspan="2"><h2>Assign Discounts to the Users</h2></td>
    </tr>
	    <tr>
      <td colspan="2"><div align="center"><?php //echo @$msg; ?></div></td>
    </tr>
    <tr>
      <td width="48%">User Email </td>
      <td width="52%"> <input name="txt_Email" type="text" id="txt_Email" value="<?php echo @$user_email; ?>" /> </td>
    </tr>

        <tr>
          <td height="38">UPS</td>
          <td><input name="txt_ups" type="text" id="txt_ups" value="<?php echo @$v_ups; ?>" />
          %          </td>
        </tr>
        <tr>
          <td height="38">FedEx</td>
          <td><input name="txt_fedex" type="text" id="txt_fedex" value="<?php echo  @$v_fedex; ?>" />
          % </td>
        </tr>
        <tr>
          <td height="38">Canada Post </td>
          <td><input name="txt_canada" type="text" id="txt_canada" value="<?php echo @ $v_canada; ?>" />
          % </td>
        </tr>
        <tr>
          <td height="38">Purolator Express </td>
          <td><input name="txt_purolator" type="text" id="txt_purolator" value="<?php echo @$v_purolator; ?>" />
          % </td>
        </tr>
        <tr>
          <td height="38">TnT Express </td>
          <td><input name="txt_tnt" type="text" id="txt_tnt" value="<?php echo @$v_tnt; ?>" />
          % </td>
        </tr>
        <tr>
          <td height="38">DHL</td>
          <td><input name="txt_dhl" type="text" id="txt_dhl" value="<?php echo @$v_dhl; ?>" />
          % </td>
        </tr>
        <tr>
          <td>Loomis</td>
          <td><input name="txt_loomis" type="text" id="txt_loomis" value="<?php echo @$v_loomis; ?>" />
          %</td>
        </tr>
<!--    <tr>
      <td>&nbsp;</td>
      <td> <?php if(@$v_user_email){ ?>
	  <input name="Update" type="submit" id="Update" value="Update" />
	  <?php }else{?>
	  <input name="Submit" type="submit" id="Submit" value="Submit" /> 
      <?php }?>
      <input type="reset" name="Submit2" value="Reset" />
	  
	  </td>
    </tr>-->
  </table>
  </div>
<!--</form>-->


<!--<form id="form_privilege_discount" name="form_privilege_discount" method="post" action="admin/assign_privilege_discount.php">-->
<div id="form_privilege_discount">
<!-- <input type="hidden"  name="atxt_Email" id="atxt_Email" value="<?php echo @$user_email; ?>"/> -->
  <table width="100%" border="0" align="center">
    <tr>
      <td colspan="2"><h2>Assign Privilege Discounts to the Users</h2></td>
    </tr>
	    <tr>
      <td colspan="2"><div align="center"><?php //echo @$msg; ?></div></td>
    </tr>
<!--    <tr>
      <td width="48%">User Email </td>
      <td width="52%"> <input name="txt_Email" type="text" id="txt_Email" value="<?php echo @$user_email; ?>" /> </td>
    </tr>-->

        <tr>
          <td height="38">UPS</td>
          <td><input name="atxt_ups" type="text" id="atxt_ups" value="<?php echo @$p_ups; ?>" />
          %          </td>
        </tr>
        <tr>
          <td height="38">FedEx</td>
          <td><input name="atxt_fedex" type="text" id="atxt_fedex" value="<?php echo  @$p_fedex; ?>" />
          % </td>
        </tr>
        <tr>
          <td height="38">Canada Post </td>
          <td><input name="atxt_canada" type="text" id="atxt_canada" value="<?php echo @ $p_canada; ?>" />
          % </td>
        </tr>
        <tr>
          <td height="38">Purolator Express </td>
          <td><input name="atxt_purolator" type="text" id="atxt_purolator" value="<?php echo @$p_purolator; ?>" />
          % </td>
        </tr>
        <tr>
          <td height="38">TnT Express </td>
          <td><input name="atxt_tnt" type="text" id="atxt_tnt" value="<?php echo @$p_tnt; ?>" />
          % </td>
        </tr>
        <tr>
          <td height="38">DHL</td>
          <td><input name="atxt_dhl" type="text" id="atxt_dhl" value="<?php echo @$p_dhl; ?>" />
          % </td>
        </tr>
        <tr>
          <td>Loomis</td>
          <td><input name="atxt_loomis" type="text" id="atxt_loomis" value="<?php echo @$p_loomis; ?>" />
          %</td>
        </tr>
    <tr>
      <td>&nbsp;</td>
      <td> 
    <!--  <input type="reset" name="Submit2" value="Reset" />-->
	  
	  </td>
    </tr>
  </table>
  </div>
  <div style="float:right;width:90px;margin-top:10px;margin-bottom:10px;margin-right:25px">
  <?php if(@$p_user_email){ ?>
	  <input name="Update" type="submit" id="submit" value="Update" i />
	  <?php }else{?>
	  <input name="Submit" type="submit" id="Submit" value="Submit" /> 
      <?php }?>
      </div>
  </form>
<!--</form>-->

<style>

h2 {
    color: #000;
    font-size: 20px;
    font-weight: normal;
    line-height: 30px;
    margin: 0 0 30px;
    padding: 0;
}

#form1 {
    border: 1px solid #666 !important;
    float: left;
    padding: 5px 2% !important;
    width: 27% !important;
}
#form_discount {
    border: 1px solid #666 !important;
    float: left;
    margin-left: 2%;
    min-height: 455px;
    padding: 5px 2% !important;
    width: 27% !important;
}


#form_privilege_discount {
    border: 1px solid #666 !important;
    float: left;
    margin-left: 2%;
    min-height: 455px;
    padding: 5px 2% !important;
    width: 27% !important;
}
</style>

