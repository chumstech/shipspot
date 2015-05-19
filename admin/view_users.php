<?php 
function getUsers($cn)
{
	 $queryString = "select * from users where user_type=2 order by id";
	$quesry = mysql_query($queryString,@$cn);
	$userData = array();
	while($data = mysql_fetch_array($quesry,MYSQL_ASSOC)){
		if($data['parent_id'] != ''){
			$queryString2 = "select * from users where parent_id={$data['id']}";
			$quesry2 = mysql_query($queryString2,@$cn);
			while($cdata = mysql_fetch_array($quesry2,MYSQL_ASSOC)){
				$data['child'][] = $cdata;
			}
		}
		$userData[] = $data;
	}
	return $userData;
}
$userData = getUsers($cn);
//echo '<pre>';print_r($userData);
?>
<h2>View Users </h2>
<div class="action">
	<a href="index.php?para=2" class="button btn">Create User</a>
</div>    
<div class="message"><?php echo $msg;?></div>                  
    <form id="form1" name="form1" method="post" action="">
      <table width="96%" border="0" id="users" class="table table-striped table-bordered">
      <thead>
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
        </thead>
        <tbody>
        <?php 
// 		if ($userObj->user_type == 1)
// 		{
// 	  		$queryString = "select * from users order by id";
// 		}
// 		else
// 		{
// 	  		$queryString = "select * from users where owner = '".$userObj->email."' order by User_Id";
// 		}
// 		$quesry = mysql_query($queryString,@$cn);
	//	while($data = mysql_fetch_array($quesry)){
       foreach($userData as $data){
  		?>
        <tr>
          <td><a href="index.php?para=13&User_Id=<?php echo $data['id']; ?>&user_email=<?php echo $data['email']; ?>">
		  <?php echo @$data['id'].' - '.@$data['first_name'].' '.@$data['last_name']; ?></a></td>
          <td><?php echo @$data['address']; ?></td>
          <td><?php echo @$data['country']; ?></td>
          <td><?php echo @$data['contact']; ?></td>
          <td><?php echo @$data['email']; ?></td>
          <td><?php echo @$data['parent_id']; ?>	</td>
		
        <td><a href="admin/del_selected_entity.php?User_Id=<?php echo $data['User_Id']; ?>"  onclick="return confirm('Are you sure?');"> <img src="images/delete.png" width="21" title="Delete" alt="delete"/> </a></td>
        <td><a href="index.php?para=13&User_Id=<?php echo $data['id']; ?>&user_email=<?php echo $data['email']; ?>"> <img src="images/edit.png" width="18" title="Edit" alt="edit"/> </a></td>
        </tr>
           <?php if(isset($data['child']) and count($data['child']) > 0){
           	  foreach($data['child'] as $chalidData){
            ?>
           <tr id="child_detail_<?php echo $chalidData['id']?>">
          <td><a href="index.php?para=13&User_Id=<?php echo $data['id']; ?>&user_email=<?php echo $data['email']; ?>">
		  <?php echo @$chalidData['id'].' - '.@$chalidData['first_name'].' '.@$chalidData['last_name']; ?></a></td>
          <td><?php echo @$chalidData['address']; ?></td>
          <td><?php echo @$chalidData['country']; ?></td>
          <td><?php echo @$chalidData['contact']; ?></td>
          <td><?php echo @$chalidData['email']; ?></td>
          <td><?php echo @$chalidData['parent_id']; ?>	</td>
		
        <td><a href="admin/del_selected_entity.php?User_Id=<?php echo $chalidData['id']; ?>"  onclick="return confirm('Are you sure?');"> <img src="images/delete.png" width="21" title="Delete" alt="delete"/> </a></td>
        <td><a href="index.php?para=13&User_Id=<?php echo $chalidData['User_Id']; ?>&user_email=<?php echo $chalidData['email']; ?>"> <img src="images/edit.png" width="18" title="Edit" alt="edit"/> </a></td>
        </tr>
           <?php 
            }
             }?>
        <?php }?>
        </tbody>
      </table>
</form>
    <div>

</div>
