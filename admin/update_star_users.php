<?php

$countries = getCountries();
$user_id = @$_GET['user_id'];
$para = @$_GET['para'];
$msg = @$_GET['msg'];
$first_name = @$_POST['txt_Fname'];
$last_name  = @$_POST['txt_Lname'];
$address  = @$_POST['txt_Address'];
$country  = @$_POST['txt_Country'];
$phone_number = @$_POST['txt_Phone_number'];
$email  = @$_POST['txt_Email'];
$password = @$_POST['txt_Password'];
$user_type = 2;
$created_by = $_SESSION['user']['id'];
$Submit = @$_POST['Submit'];

$query = "SELECT * from users where id={$user_id}";
$res = mysql_query($query,$cn) or die(mysql_error());
$userDetail = mysql_fetch_array($res,MYSQL_ASSOC);
$userDetail = (object) $userDetail;
if($Submit)
{
	   if($email!="" & $password!="")
	   {
						if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  
						{
						
							@$msg = 'Incorrect verification code!' ;
							header("location:index.php?para=8&msg=$msg");					
						}
						else
						{

							$res=mysql_query("select *from users where email='$email'",$cn) or die(mysql_error());
							if(mysql_num_rows($res)<1)
							{
								$user_created_date = date('Y-m-d H:i:s');
								 $q = "insert into users 
								(first_name, last_name, address, country, email, password, contact,user_type,created_date,created_by,status)
								values('$first_name','$last_name','$address','$country','$email','$password','$phone_number',$user_type,'$user_created_date',$created_by,1)";
								$res = mysql_query($q,$cn) or die(mysql_error());
								$used_id = mysql_insert_id($cn);
								$name = @$_POST['name'];
								$col1 = @$_POST['col1'];
								$col2 = @$_POST['col2'];
								$col3 = @$_POST['col3'];
								$col4 = @$_POST['col4'];
								for($i=0; $i<count($name); $i++)
									{
										$createdDate = date('Y-m-d H:i:s');
										if($col1[$i]!="" || $col2[$i]!="")
										{
											$q1 = "insert into star_user_carriers 
											(name, api_key, password, account_no, other_account_no,user_id,created_date,is_active)
											values('$name[$i]','$col1[$i]','$col2[$i]','$col3[$i]','$col4[$i]',$used_id,'$createdDate',1)";
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
	    <input name="txt_Fname" type="text" id="txt_Fname" value="<?php echo $userDetail->first_name;?>"/>      
      </div></td>
	  <td><div align="right">Last Name : </div></td>
	  <td width="22%">
	    <div align="left">
	      <input name="txt_Lname" type="text" id="txt_Lname" value="<?php echo $userDetail->last_name;?>"/>
          </div></td><td width="8%"><div align="right">Email:</div></td>
	  <td><div align="center">
	    <input name="txt_Email" type="text" id="txt_Email" value="<?php echo $userDetail->email;?>"/>
	  </div></td>
    </tr>
	<tr>
	  <td height="31"><div align="right">Country: </div></td>
	  <td>
	    
        <div align="center">
          <select name="txt_Country" id="txt_Country">
            <option value="">------- SELECT --------</option>
            <?php foreach($countries as $country){
              if($country['cid'] == $userDetail->country){
              $selected = 'selected:selected';
              }else{
              $selected = '';
              }
            	?>
            <option <?php echo $selected;?> value="<?=$country['cid'];?>"><?=$country['name'];?></option>
            <?php }?>
          </select>
        </div></td>
	  <td><div align="right">Phone: </div></td>
	  <td>
	    <div align="left">
	      <input name="txt_Phone_number" type="text" id="txt_Phone_number" value="<?php echo $userDetail->contact;?>"/>
          </div></td><td><div align="right">Password:</div></td>
    </tr>
	<tr>
	  <td height="55"><div align="right">Address</div></td>
	  <td>	    <div align="center">
	    <input name="txt_Address" type="text" id="txt_Address" value="<?php echo $userDetail->address;?>"/>      
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
		
		$QueryString = "select * from genreal_carriers";
		$Query = mysql_query($QueryString,@$cn);
		while($data = mysql_fetch_array($Query)){
           $queryString = "select * from star_user_carriers where carrier_id={$data['id']}";
           $res = mysql_query($queryString,@$cn);
           $row = mysql_fetch_array($res,MYSQL_ASSOC);
  		?>
        <tr>
          <td height="38"><div align="center">
            <input type="text" name="name[]" value="<?php echo @$data['name']; ?>" readonly="readonly"/>
          </div></td>
          <td><div align="center">
            <input type="text" name="col1[]" value="<?php if(count($row) > 0){ echo $row['api_key'];}?>"/>
          </div></td>
          <td><div align="center">
            <input type="text" name="col2[]" value="<?php if(count($row) > 0){ echo $row['password'];}?>"/>
          </div></td>
          <td colspan="2"><div align="center">
            <input type="text" name="col3[]" value="<?php if(count($row) > 0){echo $row['account_no'];}?>"/>
          </div></td>
          <td><div align="center">
            <input type="text" name="col4[]" value="<?php if(count($row) > 0){echo $row['other_account_no'];}?>"/>
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
	        <input name="Submit" type="submit" id="Submit" value="Submit" class="btn btn-primary"/>
		  </div></td>
		</tr>
  </table>
</form>
