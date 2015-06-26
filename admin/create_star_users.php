<?php
$countries = getCountries();
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
								$carrier_ids = @$_POST['carrier_ids'];
								for($i=0; $i<count($name); $i++)
									{
										$createdDate = date('Y-m-d H:i:s');
										if($col1[$i]!="" || $col2[$i]!="")
										{
											$q1 = "insert into star_user_carriers 
											(name, api_key, password, account_no, other_account_no,user_id,created_date,is_active,carrier_id)
											values('$name[$i]','$col1[$i]','$col2[$i]','$col3[$i]','$col4[$i]',$used_id,'$createdDate',1,$carrier_ids[$i])";
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
  
	<h2>Star Users </h2>
    <div class="msg"><?php echo @$msg;?></div>
    <div class="fields">
    	<div class="title">First Name: </div>
		<input name="txt_Fname" type="text" id="txt_Fname"/>
    </div>
    <div class="fields">
    	<div class="title">Last Name: </div>
        <input name="txt_Lname" type="text" id="txt_Lname"/>
    </div>
    <div class="fields">
    	<div class="title">Email: </div>
        <input name="txt_Email" type="text" id="txt_Email"/>
    </div>
    <div class="fields">
    	<div class="title">Country: </div>
        <select name="txt_Country" id="txt_Country">
            <option value="">------- SELECT --------</option>
           <?php foreach($countries as $country){?>
            <option value="<?php echo $country['cid'];?>"><?php echo $country['name'];?></option>
            <?php }?>
          </select>
    </div>
    <div class="fields">
    	<div class="title">Phone: </div>
        <input name="txt_Phone_number" type="text" id="txt_Phone_number"/>
    </div>
    <div class="fields">
        <div class="title">Password: </div>
        <input name="txt_Password" type="text" id="txt_Password"/>
    </div>
    <div class="fields">
        <div class="title">Address: </div>
        <input name="txt_Address" type="text" id="txt_Address"/> 
    </div>
	<h2>Carrier Detail</h2>
    <table>
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
  		?>
        <tr>
         <input type="hidden" name="carrier_ids[]" value="<?php echo $data['id']?>"/>
          <td height="38"><div align="center">
            <input type="text" name="name[]" value="<?php echo @$data['name']; ?>" />
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
  </table>
  <div class="fields">
  	<div class="title" style="width:100%;">Enter Verification Code: </div>
    <img style="float: left; clear: both; margin-left: 0%; margin-right: 75%;" src="./images/captcha.php" width="117" height="50" />
	<input name="vercode" type="text" id="vercode"/>
  </div>
  <div class="fields">
  	<input name="Submit" type="submit" id="Submit" value="Submit" class="btn btn-primary"/>
  </div>
</form>

