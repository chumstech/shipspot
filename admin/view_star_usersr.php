<style>
.action {
    float: right;
    margin-bottom: 20px;
    margin-right: 3%;
    width: 12%;
}
</style>
<h2>Star Users </h2>
<div class="action">
	<a href="index.php?para=8" class="button btn">Create Star Users</a>
</div>
                      
    <table width="99%" border="0" id="starusers" class="table table-striped table-bordered">
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
  		$QueryString = "select * from users where user_type=2";
		$Query = mysql_query($QueryString,@$cn);
		while($data = mysql_fetch_array($Query)){
  ?>
      <tr>
        <td><a href="index.php?para=14&Star_User_Email=<?php echo $data['email']; ?>"><?php echo @$data['id'].' - '.@$data['first_name'].' '.@$data['last_name']; ?></a></td>
        <td><?php echo @$data['address']; ?></td>
        <td><?php echo @$data['country']; ?></td>
        <td><?php echo @$data['contact']; ?></td>
        <td><?php echo @$data['email']; ?></td>
        <td><?php echo @$data['parent_id']; ?></td>
        <td><a href="admin/del_selected_entity.php?Star_User_Id=<?php echo $data['id']; ?>"  onclick="return confirm('Are you sure?');"> <img src="images/delete.png" width="19" title="Delete" alt="delete"/> </a></td>
      </tr>
      <?php }?>
    </table>
    <div>

</div>
