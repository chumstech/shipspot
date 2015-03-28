<?php
$para = @$_GET['para'];
$msg = @$_GET['msg'];
$First_Name = @$_POST['txt_Fname'];
$Last_Name  = @$_POST['txt_Lname'];
$Address  = @$_POST['txt_Address'];
$Country  = @$_POST['txt_Country'];
$Phone_Number = @$_POST['txt_Phone_number'];
$Email  = @$_POST['txt_Email'];
$Password = @$_POST['txt_Password'];
$Comments = @$_POST['txt_Comments'];
$CBy = @$_POST['txt_Email'];
@$MBy = '';
$Submit = @$_POST['Submit'];

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

							$res=mysql_query("select *from users where Email='$Email'",$cn) or die(mysql_error());
							if(mysql_num_rows($res)<1)
							{
								$q = "insert into users 
								(First_Name, Last_Name, Address, Country, Email, Password, Phone_Number, `CBy`, `MBy`)
								values('$First_Name','$Last_Name','$Address','$Country','$Email','$Password','$Phone_Number','$CBy','$MBy')";
								$res = mysql_query($q,$cn) or die(mysql_error());
										if($res) 
										{
											/*@$email_msg= "To complete your registration, please confirm your e-mail address by clicking this link:";
											@$email_msg.="<a href ="."http://www.dayandnite.fr/v2/admin/confirm.php?pemail=$Email".">Confirm</a>";
											$headers  = 'MIME-Version: 1.0' . "\r\n";
											 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
											 $headers .= 'From: admin <noreply@dayandnite.com>' . "\r\n";
								
											mail($Email,'SS Response ',@$email_msg,$headers);
											@$msg= "Please checkout your inbox for confirmation!";*/
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

<form id="form1" name="form1" method="post" action="index.php?para=2">
  <table width="33%" height="422" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><?php echo @$msg;?></td>
    </tr>
    <tr>
      <td colspan="2"><h2>Carriers</h2></td>
    </tr>
    <tr>
      <td width="52%">Carrier Name</td>
      <td width="48%"><input name="txt_name" type="text" id="txt_name"/></td>
    </tr>
    <tr>
      <td>Carrier Key </td>
      <td><input name="txt_key" type="text" id="txt_key"/></td>
    </tr>
    <tr>
      <td>Carrier Password </td>
      <td><input name="txt_password" type="text" id="txt_password"/></td>
    </tr>
    <tr>
      <td>Carrier Account Number </td>
      <td><input name="txt_account_number" type="text" id="txt_account_number"/></td>
    </tr>
    <tr>
      <td>Carrier Shipper Number </td>
      <td><input name="txt_shipper_number" type="text" id="txt_shipper_number"/></td>
    </tr>
    <tr>
      <td>Carrier Meter Number </td>
      <td><input name="txt_meter_number" type="text" id="txt_meter_number"/></td>
    </tr>
    <tr>
      <td>Other Information </td>
      <td><input name="txt_otherinfo" type="text" id="txt_otherinfo"/></td>
    </tr>
    <tr>
      <td>Star User</td>
      <td><select name="txt_star_user" id="txt_star_user">
          <?php 
  		$QueryString = "select * from admin_users";
		$Query = mysql_query($QueryString,@$cn);
		while($data = mysql_fetch_array($Query)){
  ?>
		  <option value="<?php echo @$data['User_Id']; ?>"><?php echo @$data['Email']; ?></option>
		  <?php }?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><img src="./images/captcha.php" /></td>
    </tr>
    <tr>
      <td height="58">Enter Verification Code like in above black box:</td>
      <td><input name="vercode" type="text" id="vercode"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="Submit" type="submit" id="Submit" value="Submit" />
        <span class="button float_r">
        <input name="cancel" type="reset" id="cancel" value="Cancel" />
      </span></td>
    </tr>
  </table>
</form>
