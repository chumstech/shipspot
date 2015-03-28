<h2>Star Users </h2>
<div class="action">
	<a href="index.php?para=8" class="button">Create Star Users</a>
</div>
                      
    <table width="99%" border="0">
      <tr>
        <?php echo @$msg;?>
      </tr>
      <tr>
        <td width="16%"><strong>Name</strong></td>
        <td width="14%"><strong>Address</strong></td>
        <td width="14%"><strong>Country</strong></td>
        <td width="13%"><strong>Phone</strong></td>
        <td width="18%"><strong>Email</strong></td>
        <td width="19%"><strong>Owner</strong></td>
        <td width="6%"><strong>Delete</strong></td>
      </tr>
      <?php 
  		$QueryString = "select * from admin_users order by 1";
		$Query = mysql_query($QueryString,@$cn);
		while($data = mysql_fetch_array($Query)){
  ?>
      <tr>
        <td><a href="index.php?para=14&Star_User_Email=<?php echo $data['Email']; ?>"><?php echo @$data['User_Id'].' - '.@$data['First_Name'].' '.@$data['Last_Name']; ?></a></td>
        <td><?php echo @$data['Address']; ?></td>
        <td><?php echo @$data['Country']; ?></td>
        <td><?php echo @$data['Phone_Number']; ?></td>
        <td><?php echo @$data['Email']; ?></td>
        <td><?php echo @$data['Owner']; ?></td>
        <td><a href="admin/del_selected_entity.php?Star_User_Id=<?php echo $data['User_Id']; ?>"  onclick="return confirm('Are you sure?');"> <img src="images/delete.png" width="19" title="Delete" alt="delete"/> </a></td>
      </tr>
      <?php }?>
    </table>
    <div>

</div>
