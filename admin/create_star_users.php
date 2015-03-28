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
$CBy =$_SESSION['Admin_Email'];
@$MBy = '';
$Submit = @$_POST['Submit'];

if($Submit)
{
	   if($Email!="" & $Password!="")
	   {

						if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  
						{
						
							@$msg = 'Incorrect verification code!' ;
							header("location:index.php?para=8&msg=$msg");					
						}
						else
						{

							$res=mysql_query("select *from admin_users where Email='$Email'",$cn) or die(mysql_error());
							if(mysql_num_rows($res)<1)
							{
								$q = "insert into admin_users 
								(First_Name, Last_Name, Address, Country, Email, Password, Phone_Number,CBy,MBy)
								values('$First_Name','$Last_Name','$Address','$Country','$Email','$Password','$Phone_Number','$CBy','$MBy')";
								$res = mysql_query($q,$cn) or die(mysql_error());

								$name = @$_POST['carrier_name'];
								$col1 = @$_POST['col1'];
								$col2 = @$_POST['col2'];
								$col3 = @$_POST['col3'];
								$col4 = @$_POST['col4'];
								
								for($i=0; $i<7; $i++)
									{
									
										if($col1[$i]!="" || $col2[$i]!="")
										{
											$q1 = "insert into carriers 
											(carrier_name, carrier_key, carrier_password, carrier_account_number, carrier_other_number, User_Email,CBy,MBy)
											values('$name[$i]','$col1[$i]','$col2[$i]','$col3[$i]','$col4[$i]','$Email','$CBy','$MBy')";
											mysql_query($q1,$cn) or die(mysql_error());
										}
									
									}
										if($res) 
										{
											@$msg= "Your are registerd now!";
											header("location:index.php?para=8&msg=$msg");				
										}
										else
										{
											
											@$msg="All fields are required";
											header("location:index.php?para=8&msg=$msg");					
										}
							}
							else
							{
								@$msg = "A user has already signed up with the same email address";	
								header("location:index.php?para=8&msg=$msg");					
			
							}
						}
				
		}
		else
		{
			@$msg="Email and Password both are require!";
			header("location:index.php?para=8&msg=$msg");					

		}
}	


?>

<form id="form1" name="form1" method="post" action="index.php?para=8">
  
  <table width="83%" border="0" align="center" cellpadding="0" cellspacing="0">
	
	<tr>
	  <td colspan="6"><h2>Star Users </h2></td>
    </tr>
	<tr>
	  <td colspan="6"><?php echo @$msg;?></td>
    </tr>
	<tr>
	  <td height="36"><div align="right">First Name: </div></td>
	  <td>        <div align="center">
	    <input name="txt_Fname" type="text" id="txt_Fname"/>      
      </div></td>
	  <td><div align="right">Last Name : </div></td>
	  <td width="22%">
	    <div align="left">
	      <input name="txt_Lname" type="text" id="txt_Lname"/>
          </div></td><td width="8%"><div align="right">Email:</div></td>
	  <td><div align="center">
	    <input name="txt_Email" type="text" id="txt_Email"/>
	  </div></td>
    </tr>
	<tr>
	  <td height="31"><div align="right">Country: </div></td>
	  <td>
	    
        <div align="center">
          <select name="txt_Country" id="txt_Country">
            <option value="">------- SELECT --------</option>
            <option value="CA">Canada</option>
            <option value="US">Unites State</option>
          </select>
        </div></td>
	  <td><div align="right">Phone: </div></td>
	  <td>
	    <div align="left">
	      <input name="txt_Phone_number" type="text" id="txt_Phone_number"/>
          </div></td><td><div align="right">Password:</div></td>
	  <td><div align="center">
	    <input name="txt_Password" type="text" id="txt_Password"/>
	  </div></td>
    </tr>
	<tr>
	  <td height="55"><div align="right">Address</div></td>
	  <td>	    <div align="center">
	    <input name="txt_Address" type="text" id="txt_Address"/>      
      </div></td>
    </tr>
	<tr>
	  <td colspan="6"><h2>Carrier Detail</h2></td>
    </tr>
	<tr>
          <td width="18%"><div align="center"><strong>Name</strong></div></td>
          <td width="15%"><div align="center"><strong>Key / CPCID </strong></div></td>
      <td width="15%"><div align="center"><strong>Password</strong></div></td>
          <td colspan="2"><div align="center"><strong>Account Number / Billing Account </strong></div></td>
      <td width="22%"><div align="center"><strong>Shipper / Meter  / Registerd Account  </strong></div></td>
    </tr>
        <?php 
		
		$QueryString = "select * from carriers where User_Email = 'farhan_admin' order by 1";
		$Query = mysql_query($QueryString,@$cn);
		while($data = mysql_fetch_array($Query)){
  		?>
        <tr>
          <td height="38"><div align="center">
            <input type="text" name="carrier_name[]" value="<?php echo @$data['carrier_name']; ?>" />
          </div></td>
          <td><div align="center">
            <input type="text" name="col1[]" />
          </div></td>
          <td><div align="center">
            <input type="text" name="col2[]" />
          </div></td>
          <td colspan="2"><div align="center">
            <input type="text" name="col3[]" />
          </div></td>
          <td><div align="center">
            <input type="text" name="col4[]"/>
          </div></td>
        </tr>
      <?php
		}			
		?>
		<tr>
		  <td colspan="2">&nbsp;</td>
		  <td><div align="right">Enter Verification Code :</div></td>
		  <td colspan="2">
		    <div align="center">
		      <input name="vercode" type="text" id="vercode"/>
            </div></td>
		  <td valign="baseline"><div align="center"><img src="./images/captcha.php" width="117" height="50" />
	        <input name="Submit" type="submit" id="Submit" value="Submit" />
		  </div></td>
		</tr>
  </table>
</form>
