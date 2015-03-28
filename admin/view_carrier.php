<style type="text/css">
<!--
.style3 {
	font-size: 12px;
	font-weight: bold;
}

.style4 {font-size: 12px}

-->
</style>
<h2>Carriers</h2>     
<?php echo $msg;?>
                   
    <form id="form1" name="form1" method="post" action="">
      <table width="100%" border="1" cellpadding="0" cellspacing="0">
		<tr>
          <td width="14%"><div align="center"><strong>Name</strong></div></td>
          <td width="8%"><div align="center"><strong>Key / CPCID </strong></div></td>
          <td width="10%"><div align="center"><strong>Password</strong></div></td>
          <td width="20%"><div align="center"><strong>Account Number / Billing Account </strong></div></td>
          <td width="19%"><div align="center"><strong>Shipper / Meter  / Registerd Account Number </strong></div></td>
          <td width="20%"><div align="center"><strong>Owner</strong></div></td>
          <td width="4%"><div align="right" class="style3">
            <div align="center">Delete/Edit</div>
          </div></td>
        </tr>
        <?php 
		$email = @$_GET['Star_User_Email'];
		if($email)
		{
  		$QueryString = "select * from carriers where User_Email = '$email' order by CDate,User_Email,carrier_name ";
		}
		else
		{
  		$QueryString = "select * from carriers order by CDate,User_Email,carrier_name ";
		}
		$Query = mysql_query($QueryString,@$cn);
		while($data = mysql_fetch_array($Query)){
  		?>
        <tr>
          <td><?php echo @$data['carrier_name']; ?></td>
          <td><?php echo @$data['carrier_key']; ?></td>
          <td><?php echo @$data['carrier_password']; ?></td>
          <td><?php echo @$data['carrier_account_number']; ?></td>
          <td><?php echo @$data['carrier_other_number']; ?></td>
          <td><?php echo @$data['User_Email']; ?> </td>
        <td><div align="right" class="style4"> 
          <div align="center"><a href="admin/del_selected_entity.php?Carrier_Id=<?php echo $data['carrierr_Id']; ?>"  onclick="return confirm('Are you sure?');"><img src="images/delete.png" height="25"width="21" title="Delete" alt="delete"/></a><a href="index.php?para=9&Carrier_Id=<?php echo $data['carrierr_Id']; ?>"><img src="images/edit.png" height="25" width="18" title="Edit" alt="edit"/> </a></div>
        </div></td>
        </tr>
        <?php }?>
      </table>
</form>

