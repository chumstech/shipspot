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

function addApiLog($insertClause)
{
    $query = "INSERT INTO api_log (".implode(',',array_keys($insertClause)).") VALUES ('".implode("','",$insertClause)."')";
	$ref =  mysql_query($query);
}
function getCountries()
{
   $query = mysql_query("select * from countries")or die(mysql_error());
	while($country = mysql_fetch_array($query,MYSQL_ASSOC)){
		$countries[] = $country;
	}
	return $countries;
}

function getCountryByCode($code)
{
   $query = mysql_query("select * from countries where cid='".$code."' ")or die(mysql_error());
	$country = mysql_fetch_array($query,MYSQL_ASSOC);
	return $country['name'];
}

function getGenrealCarriers($selectClause = '*',$whereClause = "")
{
  $query = "SELECT {$selectClause} from genreal_carriers WHERE {$whereClause}" ;
  $ref =  mysql_query($query);
  $row = (object) mysql_fetch_array($ref,MYSQL_ASSOC);
  return $row;
}

function getStarUserCarriers($selectClause = '*',$whereClause = "")
{
	$query = "SELECT {$selectClause} from star_user_carriers WHERE {$whereClause}" ;
	$ref =  mysql_query($query);
	$row = mysql_fetch_array($ref,MYSQL_ASSOC);
	if(count($row) > 0){
		return (object) $row;
	}else{
		return array();
	}
}

function geGenrealCarrierDiscount(&$object)
{
	$query = "SELECT * from  users_discount WHERE user_id={$object->user_id} AND carrier_id={$object->carrier_id}" ;
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
  $q = "SELECT * FROM user_carrier_details where user_id=$user_id AND carrier_id =$carrier_id";
  $r =  mysql_query($q);
  $count = mysql_num_rows($r);
  if($count > 0)
  {
	$query = "UPDATE user_carrier_details SET is_allowed = $value where user_id=$user_id AND carrier_id =$carrier_id";
  	$ref =  mysql_query($query);  
  }
  else
  {
	 
    $query = "INSERT INTO user_carrier_details (carrier_id,user_id,is_allowed) VALUES ($carrier_id,$user_id,$value)";
  	$ref =  mysql_query($query);    
  }
}

function checkCarrierDiscount($carrier_id,$user_id)
{
  $query = "SELECT discount from users_discount where user_id=$user_id AND carrier_id =$carrier_id";
  $ref =  mysql_query($query);
  $row = mysql_fetch_array($ref,MYSQL_ASSOC);
  return $row['discount'] ;	
}
function getUserDetailById($id)
{
	$query = "SELECT * from users where id=$id ";
	$ref =  mysql_query($query);
	$row = mysql_fetch_array($ref,MYSQL_ASSOC);
	return $row ;
}
function updateCarrierDiscount($carrier_id,$user_id,$discount)
{
  $q = "SELECT * FROM users_discount where user_id=$user_id AND carrier_id =$carrier_id";
  $r =  mysql_query($q);
  $count = mysql_num_rows($r);
  if($count > 0)
  {
	$query = "UPDATE users_discount SET discount = $discount where user_id=$user_id AND carrier_id =$carrier_id";
  	$ref =  mysql_query($query);
  }
  else
  {
	 
	echo $query = "INSERT INTO users_discount (carrier_id,user_id,discount) VALUES ($carrier_id,$user_id,$discount)";
  	$ref =  mysql_query($query);    
  }
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
  $q = "SELECT * FROM users_discount where user_id=$user_id AND carrier_id =$carrier_id";
  $r =  mysql_query($q);
  $count = mysql_num_rows($r);
  if($count > 0)
  {
  $query = "UPDATE users_discount SET privilege_discount = $privilege_discount where user_id=$user_id AND carrier_id =$carrier_id";
  $ref =  mysql_query($query);
  }
  else
  {
	 
	echo $query = "INSERT INTO users_discount (carrier_id,user_id,privilege_discount) VALUES ($carrier_id,$user_id,$privilege_discount)";
  	$ref =  mysql_query($query);    
  }

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


		function get_zip_info($zip) { 
		//Function to retrieve the contents of a webpage and put it into $pgdata
		  $pgdata =""; //initialize $pgdata
		// Open the url based on the user input and put the data into $fd:
		  $fd = fopen("http://zipinfo.com/cgi-local/zipsrch.exe?zip=$zip","r"); 
		  while(!feof($fd)) {//while loop to keep reading data into $pgdata till its all gone
			$pgdata .= fread($fd, 1024); //read 1024 bytes at a time
		  }
		  fclose($fd); //close the connection
		  if (preg_match("/is not currently assigned/", $pgdata)) {
			$city = "N/A";
			$state = "N/A";
		  } else {
			$citystart = strpos($pgdata, "Code</th></tr><tr><td align=center>");
			$citystart = $citystart + 35;
			$pgdata    = substr($pgdata, $citystart);
			$cityend   = strpos($pgdata, "</font></td><td align=center>");
			$city      = substr($pgdata, 0, $cityend);
		  
			$statestart = strpos($pgdata, "</font></td><td align=center>");
			$statestart = $statestart + 29;
			$pgdata     = substr($pgdata, $statestart);
			$stateend   = strpos($pgdata, "</font></td><td align=center>");
			$state      = substr($pgdata, 0, $stateend);
		  }
		  $zipinfo['zip']   = $zip;
		  $zipinfo['city']  = $city;
		  $zipinfo['state'] = $state;
		  return $zipinfo;
		}
