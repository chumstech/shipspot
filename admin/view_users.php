<?php 
function getUsers($cn)
{
	 $queryString = "select * from users where user_type =2 order by id";
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

function getUserInfo($cn,$userObj)
{
	$queryString = "select * from users where id=$userObj->id";
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
if($userObj->user_type == 2){
	$userData = getUserInfo($cn,$userObj);
}else{
	$userData = getUsers($cn);
}
//echo '<pre>';print_r($userData);
?>
<h2>View Users </h2>
<div class="action">
	<?php if(isset($userObj) && $userObj->user_type == 1) { ?>
    	 <div class="btn-group">
  			<button type="button" class="btn btn-primary" onclick="window.location ='index.php?para=8';">Create Star User</button>
  			<button type="button" class="btn btn-primary" onclick="window.location ='index.php?para=2';">Create User</button>
		</div>
    <?php } elseif(isset($userObj) && $userObj->user_type == 2) { ?>
    	<div class="btn-group">
  			<button type="button" class="btn btn-primary" onclick="window.location ='index.php?para=2';">Create User</button>
		</div>
    <?php } ?>
</div>    
<div class="message"><?php echo $msg;?></div>                  
    <form id="form1" name="form1" method="post" action="">
      <table width="96%" border="0" id="users" class="table table-striped table-bordered">
      <thead>
		<tr>
          <td width="14%"><strong>Name</strong></td>
          <td class="hideMobile" width="15%"><strong>Address</strong></td>
          <td class="hideMobile" width="12%"><strong>Country</strong></td>
          <td class="hideMobile"><strong>Phone</strong></td>
          <td width="19%"><strong>Email</strong></td>
          <td class="hideMobile"><strong>Owner</strong></td>
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
        <tr row-id="<?php echo $data['id']; ?>">
          
          <td><a href="index.php?para=13&user_dd=<?php echo $data['id']; ?>&user_email=<?php echo $data['email']; ?>">
		  <?php echo @$data['id'].' - '.@$data['first_name'].' '.@$data['last_name']; ?></a></td>
          <td class="hideMobile"><?php echo @$data['address']; ?></td>
          <td class="hideMobile"><?php echo @$data['country']; ?></td>
          <td class="hideMobile"><?php echo @$data['contact']; ?></td>
          <td><?php echo @$data['email']; ?></td>
          <td class="hideMobile"><?php echo getUserName($data['parent_id']); ?>	</td>
		
        <td><a href="admin/del_selected_entity.php?user_id=<?php echo $data['id']; ?>"  onclick="return confirm('Are you sure?');"> <img src="images/delete.png" width="21" title="Delete" alt="delete"/> </a></td>
        <?php if($data['user_type'] == 2){?> 
        <td><a href="index.php?para=17&user_id=<?php echo $data['id']; ?>&user_email=<?php echo $data['email']; ?>"> <img src="images/edit.png" width="18" title="Edit" alt="edit"/> </a></td>
        <?php }else{?>
        <td><a href="index.php?para=13&user_id=<?php echo $data['id']; ?>&user_email=<?php echo $data['email']; ?>"> <img src="images/edit.png" width="18" title="Edit" alt="edit"/> </a></td>
        <?php }?>
        </tr>
           <?php if(isset($data['child']) and count($data['child']) > 0){
           	  foreach($data['child'] as $chalidData){
            ?>
           <tr id="child_detail_<?php echo $chalidData['id']?>" row-id="<?php echo $chalidData['id']?>" parent-id="<?php echo $data['id']; ?>">
          <td><a href="index.php?para=13&user_id=<?php echo $chalidData['id']; ?>&user_email=<?php echo $chalidData['email']; ?>">
		  <?php echo @$chalidData['id'].' - '.@$chalidData['first_name'].' '.@$chalidData['last_name']; ?></a></td>
          <td><?php echo @$chalidData['address']; ?></td>
          <td><?php echo @$chalidData['country']; ?></td>
          <td><?php echo @$chalidData['contact']; ?></td>
          <td><?php echo @$chalidData['email']; ?></td>
          <td><?php echo getUserName($chalidData['parent_id']); ?>	</td>
		
        <td><a href="admin/del_selected_entity.php?user_id=<?php echo $chalidData['id']; ?>"  onclick="return confirm('Are you sure?');"> <img src="images/delete.png" width="21" title="Delete" alt="delete"/> </a></td>
        <td><a href="index.php?para=13&user_id=<?php echo $chalidData['id']; ?>&user_email=<?php echo $chalidData['email']; ?>"> <img src="images/edit.png" width="18" title="Edit" alt="edit"/> </a></td>
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
