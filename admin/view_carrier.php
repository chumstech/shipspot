<style type="text/css">
<!--
.style3 {
	font-size: 12px;
	font-weight: bold;
}

.style4 {font-size: 12px}

.action {
    float: right;
    margin-bottom: 20px;
    margin-right: 3%;
    width: 12%;
}
-->
</style>
<h2>Carriers</h2> 
<div class="action">
	<?php if(isset($userObj)) { ?>
    	 <div class="btn-group">
  			<button type="button" class="btn btn-primary" onclick="window.location ='index.php?para=9';">Create General Carrier</button>
		</div>
    <?php } ?>
</div>      
<div class="notice"><?php echo $msg;?></div>
                   
    <form id="form1" name="form1" method="post" action="">
      <table width="100%" border="1" cellpadding="0" cellspacing="0" id="carriers" class="table table-striped table-bordered">
		<tr>
          <td width="14%"><div align="center"><strong>Name</strong></div></td>
          <td width="8%"><div align="center"><strong>Key / CPCID </strong></div></td>
          <td width="10%"><div align="center"><strong>Password</strong></div></td>
          <td width="20%"><div align="center"><strong>Account Number / Billing Account </strong></div></td>
          <td width="19%"><div align="center"><strong>Shipper / Meter  / Registerd Account Number </strong></div></td>
          <td width="4%"><div align="right" class="style3">
            <div align="center">Edit</div>
          </div></td>
        </tr>
        <?php 
		if(isset($userObj) && $userObj->user_type == 2)
		{
			$user_id = $userObj->user_id;
		}
		else
		{
			$user_id = '';
		}
		
		if($user_id)
		{
  		$QueryString = "select * from star_user_carriers where user_id = '$user_id' order by created_date,user_id,name ";
		}
		else
		{
  		$QueryString = "select * from genreal_carriers order by created_date,name ";
		}
		$Query = mysql_query($QueryString,@$cn);
		while($data = mysql_fetch_array($Query)){
  		?>
        <tr>
          <td><?php echo @$data['name']; ?></td>
          <td><?php echo @$data['api_key']; ?></td>
          <td><?php echo @$data['password']; ?></td>
          <td><?php echo @$data['account_no']; ?></td>
          <td><?php echo @$data['other_account_no']; ?></td>
          
        <td><div align="right" class="style4"> 
          <div align="center">
          <!--<a href="admin/del_selected_entity.php?Carrier_Id=<?php echo $data['id']; ?>"  onclick="return confirm('Are you sure?');"><img src="images/delete.png" height="25"width="21" title="Delete" alt="delete"/></a>-->
          <a href="index.php?para=9&Carrier_Id=<?php echo $data['id']; ?>"><img src="images/edit.png" height="25" width="18" title="Edit" alt="edit"/> </a></div>
        </div></td>
        </tr>
        <?php }?>
      </table>
</form>

