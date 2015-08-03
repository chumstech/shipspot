<?php
ini_set('display_errors',0);
session_start();
if($para != 1 && $para != 11  && $para != 5 && $para != 4 )
{
		$now = time(); // Checking the time now when home page starts.
		//echo $_SESSION['start'];
		//echo $_SESSION['expire'];
        if ($now > $_SESSION['expire']) {
            session_destroy();
			$message = 'Session Expire Please Log in Again!';
            header('Location : ../index.php?para=1&msg='.$message);
			//echo "Your session has expired! <a href='http://localhost/somefolder/login.php'>Login here</a>";
        }
}
require_once('connections/db.php'); 
include('controls/functions.php');
$para = @$_GET['para'];
$msg = @$_GET['msg'];




$userObj = "";
if(isset($_SESSION['user'])){
	$userObj = (object)	$_SESSION['user'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/templatemo_style.css" rel="stylesheet" type="text/css" />
<meta name="keywords" content="Shiping company, UPS, FedEx Rates, Purator Rates" />
<meta name="description" content="Shiping company - UPS, FedEx Rates, Purator Rates" />
<link href="css/jquery.ennui.contentslider.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="css/custom.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-responsive.css" rel="stylesheet" type="text/css" />
<link href="css/owl.transitions.css" rel="stylesheet" type="text/css" />
<link href="css/owl.carousel.css" rel="stylesheet" type="text/css" />
<link href="css/owl.theme.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<!-- <link href="http://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" type="text/css" /> -->

<script src="js/jquery.js"></script> 
<script type="text/javascript" src="js/jqueryui.js"></script>
<script src="js/apiCalls.js" type="text/javascript"></script>
<script src="js/jquery.tablesorter.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/owl.carousel.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.tbltree.js"></script>
<link type="text/css" href="css/jquery.tbltree.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine.js"></script>
<link type="text/css" href="css/validationEngine.jquery.css" rel="stylesheet">
<script type="text/javascript">
jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#create_user").validationEngine();
	jQuery("#form1").validationEngine();
});
$(document).ready(function() {
   $( "#users" ).tbltree();
});
$(document).ready(function() {
 
  $("#owl-demo").owlCarousel({
 
      autoPlay: 3000, //Set AutoPlay to 3 seconds
 
      items : 4,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3]
 
  });
 
});
</script>

 <!-- Site JavaScript -->      	
	
        <script type="text/javascript">
					function hide()
					{
						$(".dm").hide();
						document.getElementById("txt_length").value = 1;
						document.getElementById("txt_width").value = 1;
						document.getElementById("txt_height").value = 1;
					}
					function show()
					{
						$(".dm").show();
						document.getElementById("txt_length").value = "";
						document.getElementById("txt_width").value = "";
						document.getElementById("txt_height").value = "";
					}


					function hideColums()
					{
						document.getElementById("your1").style.display = 'none';
						document.getElementById("your2").style.display ='none';
						document.getElementById("your3").style.display = 'none';
						
					}
					function showColumn()
					{
						//alert("called show");
						document.getElementById("your1").style.display = '';
						document.getElementById("your2").style.display = '';
						document.getElementById("your3").style.display = '';
					}
					function showDisc()
					{
						$('td.discount').show();
						$('th.discount').show();
					}
					function hideDisc()
					{
						$('td.discount').hide();
						$('th.discount').hide();
					}
					function showMenu()
					{
						$('.mobile-menu').toggle();
					}
				</script>
        
</head>
<body> 

	<div id="header">
    	<div class="topBar">
        	 <div class="logo"><a href="index.php"><img src="images/shipspot.png" alt="ShipSpot" /></a>
        </div>
        <div class="mobileBar">
        <a href="javascript:void(0);" onclick="showMenu();"><img style="border-radius: 3px;" src="images/menu.png" alt="Menu" /></a>
        <ul class="list-group mobile-menu" style="display:none;">      
	   		   <li class="list-group-item <?php if($_GET['para']== 1){echo 'active';} ?>"><a href="index.php?para=1">Home</a></li>
               <li class="list-group-item <?php if($_GET['para']== 4){echo 'active';} ?>"><a href="index.php?para=4">Create Shipment</a></li>
               <li class="list-group-item <?php if($_GET['para']== 5){echo 'active';} ?>"><a href="index.php?para=5">Tracking</a></li>
			   <li class="list-group-item <?php if($_GET['para']== 11){echo 'active';} ?>"><a href="index.php?para=11" >Contact</a></li>
			<?php   
			$userObj = "";
              if(isset($_SESSION['user'])){
               $userObj = (object) $_SESSION['user'];
            }
			?>

			  <?php	if ($userObj->user_type == 1)
				{
			?>	
						<li class="list-group-item <?php if($_GET['para']== 7){echo 'active';} ?>"><a href="index.php?para=7" class="current"> Users</a></li>
                        <li class="list-group-item <?php if($_GET['para']== 3){echo 'active';} ?>"><a href="index.php?para=3">Get Rates</a></li>
						<li class="list-group-item <?php if($_GET['para']== 14){echo 'active';} ?>"><a href="index.php?para=14" class="current">Carriers</a></li>
						<!--<li><a href="index.php?para=16" class="current">Discount</a></li>-->
					
			<?php
					}else if ($userObj->email && $userObj->user_type == 2)
					{
					
			?>
            			<li class="list-group-item <?php if($_GET['para']== 3){echo 'active';} ?>"><a href="index.php?para=3">Get Rates</a></li>
						<li class="list-group-item <?php if($_GET['para']== 7){echo 'active';} ?>"><a href="index.php?para=7" class="current">View Users</a></li>
			<?php }else if ($userObj->email && $userObj->user_type == 3)
					{
					
			?>
            			<li class="list-group-item <?php if($_GET['para']== 3){echo 'active';} ?>"><a href="index.php?para=3">Get Rates</a></li>
						<li class="list-group-item <?php if($_GET['para']== 2){echo 'active';} ?>"><a href="index.php?para=2&user_id=<?php echo $userObj->id;?>" class="current">Update Profile</a></li>
			<?php }?>
        </ul>
        </div>
        <div class="menu">
        <ul>      
	   		   <li class="<?php if($_GET['para']== 1){echo 'active';} ?>"><a href="index.php?para=1">Home</a></li>
               <li class="<?php if($_GET['para']== 4){echo 'active';} ?>"><a href="index.php?para=4">Create Shipment</a></li>
               <li class="<?php if($_GET['para']== 5){echo 'active';} ?>"><a href="index.php?para=5">Tracking</a></li>
			   <li class="<?php if($_GET['para']== 11){echo 'active';} ?>"><a href="index.php?para=11" >Contact</a></li>
			<?php   
			$userObj = "";
              if(isset($_SESSION['user'])){
               $userObj = (object) $_SESSION['user'];
            }
			?>

			  <?php	if ($userObj->user_type == 1)
				{
			?>	
						<li class="<?php if($_GET['para']== 7){echo 'active';} ?>"><a href="index.php?para=7" class="current"> Users</a></li>
                        <li class="<?php if($_GET['para']== 3){echo 'active';} ?>"><a href="index.php?para=3">Get Rates</a></li>
						<li class="<?php if($_GET['para']== 14){echo 'active';} ?>"><a href="index.php?para=14" class="current">Carriers</a></li>
                        <li class="<?php if($_GET['para']== 19){echo 'active';} ?>"><a href="index.php?para=19" class="current">Get Rate Log</a></li>
						<!--<li><a href="index.php?para=16" class="current">Discount</a></li>-->
					
			<?php
					}else if ($userObj->email && $userObj->user_type == 2)
					{
					
			?>
            			<li class="<?php if($_GET['para']== 3){echo 'active';} ?>"><a href="index.php?para=3">Get Rates</a></li>
						<li class="<?php if($_GET['para']== 7){echo 'active';} ?>"><a href="index.php?para=7" class="current">View Users</a></li>
			<?php }else if ($userObj->email && $userObj->user_type == 3)
					{
					
			?>
            			<li class="<?php if($_GET['para']== 3){echo 'active';} ?>"><a href="index.php?para=3">Get Rates</a></li>
						<li class="<?php if($_GET['para']== 2){echo 'active';} ?>"><a href="index.php?para=2&user_id=<?php echo $userObj->id;?>" class="current">Update Profile</a></li>
			<?php }?>
    </ul>
    </div>
        <?php if ($userObj->user_type == 1 || isset($userObj->email)) { ?>
    	
        <?php if ($userObj->user_type == 1) {
			 $user_name = $userObj->email;
			} elseif ($userObj->email) { 
			 $user_name = $userObj->email;
			} 
			else
			{
			$user_name = '';	
			} 
			
			if (strpos($user_name,'@') !== false) {
    			$user_name = current(explode("@", $user_name));
			}
			$str = str_replace(array('_', ',', '-', '.'), ' ', $user_name);
			$user_name =  $userObj->first_name." ".$userObj->last_name;
			?>
            <div class="mobile_user_dashboard" style="display:none;">
                <div class="btn-group">
                  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    <img src="images/user.png" alt="user" />
                  </a>
                  <ul class="dropdown-menu">
                    <?php if ($userObj->user_type == 1) { ?>		
                        <li><a tabindex="-1" href="index.php?para=6">Inbox</a></li>
                  		<li><a tabindex="-1" href="./controls/logout.php">Logout</a></li>
                	<?php	} elseif ($userObj->email) {?>
                		<li><a tabindex="-1" href="index.php?para=15">Inbox</a></li>
                  		<li><a tabindex="-1" href="./controls/logout.php">Logout</a></li>
                	<?php } ?>  
                  </ul>
                </div>
             </div>
            <div class="user_dashboard">
                <div class="btn-group">
                  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    Hi <?php echo $user_name; ?>!
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <?php if ($userObj->user_type == 1) { ?>		
                        <li><a tabindex="-1" href="index.php?para=6">Inbox</a></li>
                  		<li><a tabindex="-1" href="./controls/logout.php">Logout</a></li>
                	<?php	} elseif ($userObj->email) {?>
                		<li><a tabindex="-1" href="index.php?para=15">Inbox</a></li>
                  		<li><a tabindex="-1" href="./controls/logout.php">Logout</a></li>
                	<?php } ?>  
                  </ul>
                </div>
             </div>
    		<?php } ?>
        </div>
	
    </div>
		 <div id="content_wrapper">
		     <?php 
		     if(!isset($_SESSION['user'])){
		     	include('controls/home.php'); echo "<title>Shipspot Home</title>"; break ; 
		     }else{
	switch($para)
	{

		case 1 : include('controls/home.php'); echo "<title>Shipspot Home</title>"; break ; 
		case 2 : include('controls/signup.php'); echo  "<title>Shipspot Signup</title>"; break ; 
		case 3 : include('controls/rates.php'); echo "<title>Shipspot Rates</title>"; break ; 
		case 4 : include('controls/shipment.php'); echo "<title>Shipspot Shipment</title>"; break ; 
		case 5 : include('controls/tracking.php'); echo "<title>Shipspot Tracking</title>"; break ; 
		case 6 : include('admin/admin_inbox.php'); echo "<title>Shipspot inbox</title>"; break ; 
		case 7 : include('admin/view_users.php'); echo "<title>Shipspot Set Owner</title>"; break ; 
		case 8 : include('admin/create_star_users.php'); echo "<title>Shipspot Star Users</title>"; break ; 
		case 9 : include('admin/create_master_carrier.php'); echo "<title>Shipspot Master Carriers</title>"; break ; 
		case 10 : include('admin/view_star_usersr.php'); echo "<title>Shipspot View Star Users</title>"; break ;
		case 11 : include('controls/contact.php'); echo "<title>Contact Us</title>"; break ; 
		case 13 : include('admin/set_owner.php'); echo "<title>Shipspot View Set Owner</title>"; break ; 
		case 14 : include('admin/view_carrier.php'); echo "<title>Shipspot View Carrier</title>"; break ; 
		case 15 : include('controls/user_inbox.php'); echo "<title>Shipspot inbox</title>"; break ; 
		case 16 : include('admin/assign_discount.php'); echo "<title>Shipspot Assign Discount </title>"; break ; 
		case 17 : include('admin/update_star_users.php'); echo "<title>Update Star User </title>"; break ;
		case 18 : include('admin/create_carrier_users.php'); echo "<title>Update Profile</title>"; break ;
		case 19 : include('controls/get_rate_logs.php'); echo "<title>Get Rates Log</title>"; break ;
		
		default: 
			echo "<title>ShipSpot Home</title>"; 
			header("location:index.php?para=1");		
	}
	}

?>
		 </div>
         <p>&nbsp;</p>
         <div class="footer">
         All Rights Resevred Shipspot © 2015
         </div>
</body>
</html>