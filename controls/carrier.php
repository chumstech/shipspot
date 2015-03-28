<?php
require_once('../connections/db.php'); 

if(isset($_POST['cerrier_id'])){
$object = new stdClass();
$object->selectedCarrierIds = implode(',',$_POST['cerrier_id']);
$object->starUserId = $_POST['uId'];
updateStarUserSelectedCarriers($object);
}
function updateStarUserSelectedCarriers($object)
{
	$selecteQuery = "SELECT * FROM star_user_carrier_selected WHERE   star_user_id= {$object->starUserId}";
	$res = @mysql_query($selecteQuery);
	$row  = mysql_fetch_array($res);
	if(is_array($row) and count($row) > 0){
	 $query = "UPDATE star_user_carrier_selected SET selected_carrier ='{$object->selectedCarrierIds}' WHERE star_user_id = {$object->starUserId}";
	}else{
		$query = "INSERT INTO star_user_carrier_selected  (selected_carrier,star_user_id)  VALUES ('{$object->selectedCarrierIds}', {$object->starUserId})";
	}
	$result = @mysql_query($query);
	if($result){
		echo json_encode(array('status' => 'success'));
	}else{
		echo json_encode(array('status' => 'error'));
	}
}
?>