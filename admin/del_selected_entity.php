<?php
session_start();
require_once('../connections/db.php'); 
$p_User_Id = @$_GET['user_id'];
$p_Star_User_Id = @$_GET['Star_User_Id'];
$p_carrierr_Id = @$_GET['Carrier_Id'];


if($p_User_Id)
{
	$query = "delete from users where id = '$p_User_Id'" or die(mysql_error());
	mysql_query($query,$cn) or die(mysql_error());
	$msg = "User with ID= ".$p_User_Id." has been deleted";
	header("location:../index.php?para=7&msg=$msg");
}

if($p_Star_User_Id)
{
	$query = "delete from admin_users where id = '$p_Star_User_Id' and Owner!='self'" or die(mysql_error());
	mysql_query($query,$cn) or die(mysql_error());
	$msg = "User with ID= ".$p_Star_User_Id." has been deleted";
	header("location:../index.php?para=10&msg=$msg");
}

if($p_carrierr_Id)
{
	$query = "delete from  carriers where carrierr_Id = '$p_carrierr_Id'" or die(mysql_error());
	mysql_query($query,$cn) or die(mysql_error());
	$msg = "Carrier with ID= ".$p_carrierr_Id." has been deleted";
	header("location:../index.php?para=14&msg=$msg");
}


?>