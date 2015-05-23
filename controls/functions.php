<?php
function getUserSelectedCarriers($object)
{
	$selectedCarrier = mysql_query("select * from star_user_carrier_selected where star_user_id='$object->user_id' ")or die(mysql_error());
	$selectedCarriers = mysql_fetch_array($selectedCarrier,MYSQL_ASSOC);
	if(is_array($selectedCarriers) and count($selectedCarriers) > 0){
	  return explode(',',$selectedCarriers['selected_carrier']);
	}else{
		return array();
	}
}

function getCountries()
{
   $query = mysql_query("select * from countries")or die(mysql_error());
	while($country = mysql_fetch_array($query,MYSQL_ASSOC)){
		$countries[] = $country;
	}
	return $countries;
}

function getGenrealCarriers($selectClause = '*',$whereClause = "")
{
  $query = "SELECT {$selectClause} from genreal_carriers WHERE {$whereClause}" ;
  $ref =  mysql_query($query);
  $row = (object) mysql_fetch_array($ref,MYSQL_ASSOC);
  return $row;
}

function geGenrealCarrierDiscount(&$object)
{
	echo $query = "SELECT * from  users_discount WHERE user_id={$object->user_id} AND carrier_id={$object->carrier_id}" ;
	$ref =  mysql_query($query);
	$row = (object) mysql_fetch_array($ref,MYSQL_ASSOC);
	return $row;
}
/*function getUsers()
{
	return 'i m here';
}*/

function getCarriers()
{
  $query = "SELECT id,name from genreal_carriers";
  $ref =  mysql_query($query);
  $row = mysql_fetch_array($ref,MYSQL_ASSOC);
  return $ref;
}

function getUserName($id)
{
  $query = "SELECT last_name,first_name from users where id='".$id."' ";
  $ref =  mysql_query($query);
  $row = mysql_fetch_array($ref,MYSQL_ASSOC);
  return $row['first_name']." ".$row['last_name'] ;
}

function getUserEmail($id)
{
  $query = "SELECT email from users where id=$id ";
  $ref =  mysql_query($query);
  $row = mysql_fetch_array($ref,MYSQL_ASSOC);
  return $row['email'] ;
}