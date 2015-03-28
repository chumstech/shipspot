<h2>View Users </h2>
<div class="action">
	<a href="index.php?para=2" class="button">Create User</a>
</div>    
<div class="message"><?php echo $msg;?></div>                  
    <form id="form1" name="form1" method="post" action="">
      <table width="96%" border="0">
		<tr>
          <td width="14%"><strong>Name</strong></td>
          <td width="15%"><strong>Address</strong></td>
          <td width="12%"><strong>Country</strong></td>
          <td width="12%"><strong>Phone</strong></td>
          <td width="19%"><strong>Email</strong></td>
          <td width="20%"><strong>Owner</strong></td>
          <td width="4%"><strong>Delete</strong></td>
          <td width="4%"><strong>Edit</strong></td>
        </tr>
        <?php 
		if (@$_SESSION['Admin_Email'] && @$_SESSION['Owner'] == "self")
		{
	  		$QueryString = "select * from users order by User_Id";
		}
		else
		{
	  		$QueryString = "select * from users where owner = '".$_SESSION['Admin_Email']."' order by User_Id";
		}
		$Query = mysql_query($QueryString,@$cn);
		while($data = mysql_fetch_array($Query)){
  		?>
        <tr>
          <td><a href="index.php?para=13&User_Id=<?php echo $data['User_Id']; ?>&user_email=<?php echo $data['Email']; ?>">
		  <?php echo @$data['User_Id'].' - '.@$data['First_Name'].' '.@$data['Last_Name']; ?></a></td>
          <td><?php echo @$data['Address']; ?></td>
          <td><?php echo @$data['Country']; ?></td>
          <td><?php echo @$data['Phone_Number']; ?></td>
          <td><?php echo @$data['Email']; ?></td>
          <td><?php echo @$data['owner']; ?>	</td>
		
        <td><a href="admin/del_selected_entity.php?User_Id=<?php echo $data['User_Id']; ?>"  onclick="return confirm('Are you sure?');"> <img src="images/delete.png" width="21" title="Delete" alt="delete"/> </a></td>
        <td><a href="index.php?para=13&User_Id=<?php echo $data['User_Id']; ?>&user_email=<?php echo $data['Email']; ?>"> <img src="images/edit.png" width="18" title="Edit" alt="edit"/> </a></td>
        </tr>
        <?php }?>
      </table>
</form>
    <div>

</div>
