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
	$records = mysql_query("select * from admin_users");
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

							$res=mysql_query("select *from users where Email='$Email'",$cn) or die(mysql_error());
							if(mysql_num_rows($res)<1)
							{
								$q = "insert into users 
								(star_owner, First_Name, Last_Name, Address, Country, Email, Password, Phone_Number, `CBy`, `MBy`)
								values('$star_owner','$First_Name','$Last_Name','$Address','$Country','$Email','$Password','$Phone_Number','$CBy','$MBy')";
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
      <td colspan="2"><h2>Sign Up</h2></td>
    </tr>
    <tr>
      <td width="52%">Select Star Owner</td>
      <td width="48%"><select name="starowner">
      <?php while ($starowner = mysql_fetch_array($starOwners)){?>
      <option value="<?php echo $starowner['User_Id']; ?>"><?php echo $starowner['First_Name']." ".$starowner['Last_Name']; ?></option>
		<?php }  ?>
      </select></td>
    </tr>
    <tr>
      <td width="52%">First Name: </td>
      <td width="48%"><input name="txt_Fname" type="text" id="txt_Fname"/></td>
    </tr>
    <tr>
      <td>Last Name : </td>
      <td><input name="txt_Lname" type="text" id="txt_Lname"/></td>
    </tr>
    <tr>
      <td>Address: </td>
      <td><input name="txt_Address" type="text" id="txt_Address"/></td>
    </tr>
    <tr>
      <td>Country: </td>
      <td><select name="txt_Country" id="txt_Country">
          <option value="CA">Canada</option>
          <option value="US">Unites State</option>
      </select></td>
    </tr>
    <tr>
      <td>Phone: </td>
      <td><input name="txt_Phone_number" type="text" id="txt_Phone_number"/></td>
    </tr>
    <tr>
      <td>Email:</td>
      <td><input name="txt_Email" type="text" id="txt_Email"/></td>
    </tr>
    <tr>
      <td>Password</td>
      <td><input name="txt_Password" type="text" id="txt_Password"/></td>
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
      <td height="41">Comments: </td>
      <td><input name="txt_Comments" type="text" id="txt_Comments"/></td>
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
