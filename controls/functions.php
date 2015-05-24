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

function checkCarrierAllowed($carrier_id,$user_id)
{
  $query = "SELECT is_allowed from user_carrier_details where user_id=$user_id AND carrier_id =$carrier_id";
  $ref =  mysql_query($query);
  $row = mysql_fetch_array($ref,MYSQL_ASSOC);
  return $row['is_allowed'] ;
}

function updateCarrierAllowed($carrier_id,$user_id,$value)
{
  $query = "UPDATE user_carrier_details SET is_allowed = $value where user_id=$user_id AND carrier_id =$carrier_id";
  $ref =  mysql_query($query);
}

function checkCarrierDiscount($carrier_id,$user_id)
{
  $query = "SELECT discount from users_discount where user_id=$user_id AND carrier_id =$carrier_id";
  $ref =  mysql_query($query);
  $row = mysql_fetch_array($ref,MYSQL_ASSOC);
  return $row['discount'] ;	
}

function updateCarrierDiscount($carrier_id,$user_id,$discount)
{
  $query = "UPDATE users_discount SET discount = $discount where user_id=$user_id AND carrier_id =$carrier_id";
  $ref =  mysql_query($query);
}

function checkCarrierPriviligedDiscount($carrier_id,$user_id)
{
  $query = "SELECT privilege_discount from users_discount where user_id=$user_id AND carrier_id =$carrier_id";
  $ref =  mysql_query($query);
  $row = mysql_fetch_array($ref,MYSQL_ASSOC);
  return $row['privilege_discount'] ;	
}

function updateCarrierPriviligedDiscount($carrier_id,$user_id,$privilege_discount)
{
  $query = "UPDATE users_discount SET privilege_discount = $privilege_discount where user_id=$user_id AND carrier_id =$carrier_id";
  $ref =  mysql_query($query);
}

/*============DEFAULT FUNCTIONS AFTER USER SIGNUP==================*/

function defaultCarrierAllowed($carrier_id,$user_id,$value)
{
  $query = "INSERT into user_carrier_details (carrier_id,user_id,is_allowed) VALUES ($carrier_id,$user_id,$value)";
  $ref =  mysql_query($query);
}

function defaultDiscountAllowed($carrier_id,$user_id,$value)
{
  $query = "INSERT into users_discount (carrier_id,user_id,discount) VALUES ($carrier_id,$user_id,$value)";
  $ref =  mysql_query($query);
}

function defaultPriviligedDiscountAllowed($carrier_id,$user_id,$value)
{
  $query = "INSERT into users_discount (carrier_id,user_id,privilege_discount) VALUES ($carrier_id,$user_id,$value)";
  $ref =  mysql_query($query);
}
