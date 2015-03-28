<?php
ini_set('display_errors',1);
session_start();
require_once('connections/db.php'); 
$para = @$_GET['para'];
$msg = @$_GET['msg'];
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
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="js/apiCalls.js" type="text/javascript"></script>
<script src="js/jquery.tablesorter.js" type="text/javascript"></script>
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
					
				</script>
        
</head>
<body> 

	<div id="BodyHeader"> 
	 <ul>      
	   		   <li><a href="index.php?para=1">Home</a></li>
               <li><a href="index.php?para=4">Create Shipment</a></li>
               <li><a href="index.php?para=5">Tracking</a></li>
			   <li><a href="index.php?para=1" >Contact</a></li>
			  
					

			  <?php	if (@$_SESSION['Admin_Email'] && @$_SESSION['Owner'] == "self")
					{
			?>	
						<li><a href="index.php?para=7" class="current"> Users</a></li>
                        <li><a href="index.php?para=3">Get Rates</a></li>
						<li><a href="index.php?para=10" class="current"> Star Users</a></li>
						<li><a href="index.php?para=9" class="current">Create Carriers</a></li>
						<!--<li><a href="index.php?para=16" class="current">Discount</a></li>-->
					
			<?php
					}else if (@$_SESSION['Admin_Email'] && @$_SESSION['Owner'] != "self")
					{
					
			?>
            			<li><a href="index.php?para=3">Get Rates</a></li>
						<li><a href="index.php?para=7" class="current">View Users</a></li>
			<?php }?>
			
<!--					<?php if (@$_SESSION['Admin_Email']) { ?>
							
                    <li><a href="index.php?para=6" class="current"> Inbox</a></li>
                    <li><a href="./controls/logout.php" class="current"> Logout</a></li>
					<?php	} elseif (@$_SESSION['Email']) {?>-->
                    <li><a href="index.php?para=3">Get Rates</a></li>
                    <!--<li><a href="index.php?para=15" class="current"> Inbox</a></li>
                    <li><a href="./controls/logout.php" class="current"> Logout</a></li>
					<?php } ?>-->
    </ul>
    
	<?php if (@$_SESSION['Admin_Email'] || @$_SESSION['Email']) { ?>
    	
        <?php if (@$_SESSION['Admin_Email']) {
			 $user_name = @$_SESSION['Admin_Email'];
			} elseif (@$_SESSION['Email']) { 
			 $user_name = @$_SESSION['Email'];
			} 
			else
			{
			$user_name = '';	
			} 
			
			if (strpos($user_name,'@') !== false) {
    			$user_name = current(explode("@", $user_name));
			}
			$str = str_replace(array('_', ',', '-', '.'), ' ', $user_name);
			$user_name =  $str;
			?>
    			
	<div class="user_dashboard">
    	<h3>Welcome <?php echo $user_name; ?></h3>
    	<div class="left">
        	<img alt="user" src="images/user.png" style="width:100%;" />
        </div>
        <div class="right">
				<?php if (@$_SESSION['Admin_Email']) { ?>		
                    <a href="index.php?para=6" class="current"> Inbox</a>
                    <a href="./controls/logout.php" class="current"> Logout</a>
					<?php	} elseif (@$_SESSION['Email']) {?>
                    <a href="index.php?para=15" class="current"> Inbox</a>
                    <a href="./controls/logout.php" class="current"> Logout</a>
				<?php } ?>
        </div>
    </div>
    <?php } ?>
	
    </div>
    <?php // print_r($_SESSION); ?>
		 <div id="content_wrapper">
		     <?php 

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
		case 13 : include('admin/set_owner.php'); echo "<title>Shipspot View Set Owner</title>"; break ; 
		case 14 : include('admin/view_carrier.php'); echo "<title>Shipspot View Carrier</title>"; break ; 
		case 15 : include('controls/user_inbox.php'); echo "<title>Shipspot inbox</title>"; break ; 
		case 16 : include('admin/assign_discount.php'); echo "<title>Shipspot Assign Discount </title>"; break ; 
		default: 
			echo "<title>ShipSpot Home</title>"; 
			header("location:index.php?para=1");		
	}

?>
		 </div>
         <p>&nbsp;</p>
</body>
</html>