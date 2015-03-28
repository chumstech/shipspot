<style>
   .left{
          display: block;
          float:left; 
          width:26%;
    }
	   .your{
          display: block;
          float:left; 
		  text-align:left;
          width:5%;
		  padding-bottom:8px;
		  padding-right:25px;
    }
	.smallCell
	{
	 display: block;
     float:left; 
     width:70%;
	 padding-bottom:8px;
	}
	.smallCell2
	{
	 display: block;
     float:left; 
     width:3%;
	 padding-bottom:8px;

	}
	.clear
	{
		clear:both;
	}
#accordion 
{
   width:100%;
   height: 60px;
   background-color:#EAEAEA;
   
 }
#accordion div 
{
   float: left;
   width:100%;
   height: 20px;
   
 }
#accordion:hover div:hover 
{
   width:100%;
   height: 60px;
   background-color:#EAEAEA;
 } 
 </style>
<?php
		ini_set('display_errors',1);
		require_once("admin/adminRates.php");
		
		$from 	= @$_POST['txt_from'];
		$to		= @$_POST['txt_to'];
		$weight = @$_POST['txt_weight'];
		$length = @$_POST['txt_length'];
		$width 	= @$_POST['txt_width'];
		$height = @$_POST['txt_height'];
		$sub 	= @$_POST['submit'];
		$clear 	= @$_POST['clear'];
		
		$check_canada 	= @$_POST['check_canada'];;
		$check_ups 		= @$_POST['check_ups'];
		$check_puro 	= @$_POST['check_puro'];
		$check_fedex 	= @$_POST['check_fedex'];
		$check_tnt 		= @$_POST['check_tnt'];
		$check_dhl 		= @$_POST['check_dhl'];
		$packingType 	= @$_POST['ship_type'];

		require_once("./canadaPost/canadapost.php");
		require_once("./FedEx/RateAvailableServices.php");
		require_once("./Purolator/purolator.php");
		require_once("./UPS/upsRate.php");
		require_once("./TnT/TnT.php");

		$canadaPostRate = new CanadaPost();
		$fedexRate = new FedEx;
		$purolatorRate = new puroRate;
		$upsRate = new upsRate;
		$tntRate = new tnt;
	
	
	if($sub)
	{
	?> 
	<style> #loading-image{display:block !important;}</style>
    <?php 
	if(isset($_SESSION['Admin_Email'])) // check if admin login or local user to give an option to select carrier
	{
		if($check_canada == 'yes')
		{	
			$_SESSION['check_canada'] = 'yes';
			$canadaPostRate->setCredentials($admin_col1_canada,$length,$width,$height,$weight,$from,$to);
		}
		if($check_canada !== 'yes')
		{	
			unset($_SESSION['check_canada'],$_SESSION['canada_Priority'],$_SESSION['canada_Xpresspost'],$_SESSION['canada_Regular'],$_SESSION['canada_Expedited']);
		}
		if($check_fedex == 'yes')
		{
			$_SESSION['check_fedex'] = 'yes';
			$fedexRate->setCredentials($admin_col1_fedex,$admin_col2_fedex,$admin_col3_fedex,$admin_col4_fedex,$weight,$height,$width,$length,$from,$to);
		}
		if($check_fedex != 'yes')
		{
unset($_SESSION['check_fedex'],$_SESSION['fedex_PRIORITY_OVERNIGHT'],$_SESSION['fedex_FIRST_OVERNIGHT'],$_SESSION['fedex_FEDEX_EXPRESS_SAVER'],$_SESSION['fedex_FEDEX_GROUND'],$_SESSION['fedex_FEDEX_2_DAY']);
		}
		if($check_puro == 'yes')
		{
			$_SESSION['check_puro'] = 'yes';
			$purolatorRate->setCredentials($admin_col1_purolator,$admin_col2_purolator,$admin_col3_purolator,$admin_col4_purolator,$from, $to, $length, $width, $height, $weight);
		}
		if($check_puro != 'yes')
		{
			unset($_SESSION['check_puro'],$_SESSION['purolator_PurolatorExpress'],$_SESSION['purolator_PurolatorExpress9AM'],$_SESSION['purolator_PurolatorExpress10:30AM'],$_SESSION['purolator_PurolatorGround'],$_SESSION['purolator_PurolatorGround9AM'],$_SESSION['purolator_PurolatorGround10:30AM']);
		}
		if($check_ups == 'yes')
		{
			$_SESSION['check_ups'] = 'yes';
			$upsRate->setCredentials($admin_col3_ups,'$admin_col1_ups','$admin_col2_ups','$admin_col4_ups',$from, $to, $length, $width, $height, $weight, $packingType);
		}
		if($check_ups != 'yes')
		{
			unset($_SESSION['check_ups'],$_SESSION['ups_01'],$_SESSION['ups_13'],$_SESSION['ups_14'],$_SESSION['ups_02'],$_SESSION['ups_03']);
		}
		if($check_tnt == 'yes')
		{
			$_SESSION['check_tnt'] = 'yes';
			$tntRate->setCredentials();
			//$tntRate->setCredentials($admin_col1_tnt,$admin_col2_tnt,$admin_col3_tnt,$weight,$height,$width,$length,$from,$to);
		}
		if($check_tnt != 'yes')
		{
			unset($_SESSION['check_tnt'],$_SESSION['48N'],$_SESSION['15N'],$_SESSION['12N']);
		}
		
		//echo "<style> #loading-image{display:none !important;}</style>";
    } //end of checking is admin login
	else
	{
		if($_SESSION['DB_CANADAPOST'] == 'Y') //check if this carrier is enabled then call API to get rates
		{
			$canadaPostRate->setCredentials($admin_col1_canada,$length,$width,$height,$weight,$from,$to);
		}
		if($_SESSION['DB_FEDEX'] == 'Y')
		{
			$fedexRate->setCredentials($admin_col1_fedex,$admin_col2_fedex,$admin_col3_fedex,$admin_col4_fedex,$weight,$height,$width,$length,$from,$to);
		}
		if($_SESSION['DB_PUROLATOR']=='Y')
		{
			$purolatorRate->setCredentials($admin_col1_purolator,$admin_col2_purolator,$admin_col3_purolator,$admin_col4_purolator,$from, $to, $length, $width, $height, $weight);
		}
		if($_SESSION['DB_UPS'] == 'Y')
		{
			$upsRate->setCredentials($admin_col3_ups,'$admin_col1_ups','$admin_col2_ups','$admin_col4_ups',$from, $to, $length, $width, $height, $weight, $packingType);
		}
		if($_SESSION['DB_TNT'] =='Y')
		{
			$tntRate->setCredentials();
		//$tntRate->setCredentials($admin_col1_tnt,$admin_col2_tnt,$admin_col3_tnt,$weight,$height,$width,$length,$from,$to);
		}
	}
if($_SESSION['Posted_Rate_Flag']== 'Y') //check if admin alow a client to see posted rates? if yes then form an array of posted rates
{
	$first_day_rates = array(
					"Purolator Express" => $_SESSION['purolator_PurolatorExpress'],
					"Fedex Express Saver" => $_SESSION['fedex_FEDEX_EXPRESS_SAVER'],
					"Purolator Express 10:30AM" => $_SESSION['purolator_PurolatorExpress10:30AM'],
					"Purolator Express 9AM" => $_SESSION['purolator_PurolatorExpress9AM'],
					"UPS Next Day Air Saver(12.30 Noon)"  => $_SESSION['ups_13'],
					"UPS Next Day Air 10.30 AM" => $_SESSION['ups_01'],
					"Fedex Priority Over Night" => $_SESSION['fedex_PRIORITY_OVERNIGHT'],
					"Canada Post Priority" => $_SESSION['canada_Priority'],
					"Fedex First Over Night"  => $_SESSION['fedex_FIRST_OVERNIGHT'],
					"UPS Next Day Air (8.30 AM)" => $_SESSION['ups_14'], 
			  		"TnT Economy Express" => $_SESSION['48N'],
					"TnT 9:00 Express"  => $_SESSION['15N'],
					"TnT 12:00 Express"  => $_SESSION['12N']
						);
												
	$second_day_rates = array(
					"UPS 2nd Day Air" => $_SESSION['ups_02'], 
					"Canada Xpresspost"  => $_SESSION['canada_Xpresspost'],
					"Fedex 2nd DAY" => $_SESSION['fedex_FEDEX_2_DAY']
						);			
						
	$third_day_rates = array(
					"UPS Ground"  => $_SESSION['ups_03'],
					"Fedex Ground"  => $_SESSION['fedex_FEDEX_GROUND'],
					"Canada Post Regular"  => $_SESSION['canada_Regular'],
					"Canada Expedited"  => $_SESSION['canada_Expedited'],
					"Purolator Ground"  => $_SESSION['purolator_PurolatorGround'],
					"Purolator Ground 10:30AM" => $_SESSION['purolator_PurolatorGround10:30AM'],
					"Purolator Ground 9AM" => $_SESSION['purolator_PurolatorGround9AM']
						);

}
/////////////////////////////////////////////////////////////////////
if($_SESSION['Disc_Rate_Flag']=='Y') ////check if admin alow a client to see discounted rates? if yes then form an array of posted rates
{
	$first_day_disc_rates = array(
					"purolator_PurolatorExpress" => $_SESSION['purolator_PurolatorExpress']- $_SESSION['discount_purolator']*$_SESSION['purolator_PurolatorExpress9AM'],
					"fedex_FEDEX_EXPRESS_SAVER" => $_SESSION['fedex_FEDEX_EXPRESS_SAVER']- ($_SESSION['discount_fedex'] *$_SESSION['fedex_FEDEX_EXPRESS_SAVER']),
			"purolator_PurolatorExpress10:30AM" => $_SESSION['purolator_PurolatorExpress10:30AM']- $_SESSION['discount_purolator']*$_SESSION['purolator_PurolatorExpress10:30AM'],
					"purolator_PurolatorExpress9AM" => $_SESSION['purolator_PurolatorExpress9AM']- $_SESSION['discount_purolator']*$_SESSION['purolator_PurolatorExpress9AM'],
					"UPS_Next_Day_Air_Saver"  => $_SESSION['ups_13']- ($_SESSION['discount_ups']*$_SESSION['ups_13']),
					"UPS_Next_Day_Air" => $_SESSION['ups_01']- ($_SESSION['discount_ups']*$_SESSION['ups_01']),
					"fedex_PRIORITY_OVERNIGHT" => $_SESSION['fedex_PRIORITY_OVERNIGHT']- ($_SESSION['discount_fedex'] *$_SESSION['fedex_PRIORITY_OVERNIGHT']),
					"canada_Priority" => $_SESSION['canada_Priority']- ($_SESSION['discount_canada']/100 * $_SESSION['canada_Priority']),
					"fedex_FIRST_OVERNIGHT"  => $_SESSION['fedex_FIRST_OVERNIGHT']- ($_SESSION['discount_fedex'] *$_SESSION['fedex_FIRST_OVERNIGHT']),
					"UPS_Next_Day_Air_(early_AM)" => $_SESSION['ups_14']- ($_SESSION['discount_ups']*$_SESSION['ups_14']), 
			  		"TnT_Economy_Express" => $_SESSION['48N']- ($_SESSION['discount_tnt'] * $_SESSION['48N']),
			  		"TnT 9:00 Express" => $_SESSION['15N']- ($_SESSION['discount_tnt'] * $_SESSION['15N']),
			  		"TnT Express 12:00" => $_SESSION['12N']- ($_SESSION['discount_tnt'] * $_SESSION['12N'])
						);
						
	$second_day_disc_rates = array(
					"UPS_2nd_Day_Air" => $_SESSION['ups_02']- ($_SESSION['discount_ups']*$_SESSION['ups_02']), 
					"canada_Xpresspost"  => $_SESSION['canada_Xpresspost']- ($_SESSION['discount_canada']/100 * $_SESSION['canada_Xpresspost']),
					"fedex_FEDEX_2_DAY" => $_SESSION['fedex_FEDEX_2_DAY']- ($_SESSION['discount_fedex'] *$_SESSION['fedex_FEDEX_2_DAY'])
						);			
						
	$third_day_disc_rates = array(
					"UPS_Ground" => $_SESSION['ups_03']- ($_SESSION['discount_ups']*$_SESSION['ups_03']),
					"fedex_FEDEX_GROUND" => $_SESSION['fedex_FEDEX_GROUND']- ($_SESSION['discount_fedex'] *$_SESSION['fedex_FEDEX_GROUND']),
					"canada_Regular" => $_SESSION['canada_Regular']- ($_SESSION['discount_canada']/100 * $_SESSION['canada_Regular']),
					"canada_Expedited" => $_SESSION['canada_Expedited']- ($_SESSION['discount_canada']/100 * $_SESSION['canada_Expedited']),
					"purolator_PurolatorGround" => $_SESSION['purolator_PurolatorGround']- $_SESSION['discount_purolator']*$_SESSION['purolator_PurolatorGround'],
				"purolator_PurolatorGround10:30AM" => $_SESSION['purolator_PurolatorGround10:30AM']- $_SESSION['discount_purolator']*$_SESSION['purolator_PurolatorGround10:30AM'],
				"purolator_PurolatorGround9AM" => $_SESSION['purolator_PurolatorGround9AM']- $_SESSION['discount_purolator']*$_SESSION['purolator_PurolatorGround9AM']
							);
}
?>
<style> #loading-image{display:none !important;}</style>
<?php }?>
	<?php // print_r($_SESSION); ?>
	<div id="loading-image" style="display:none;">
	<img src="images/loading.gif" alt="Loading..." />
	</div>
   <h3>Get Rates</h3>
  <form name="get_rates" enctype="multipart/form-data" method="post" action="index.php?para=3">
  <div class="image_wrapper_rate">
  	<div>
    	International / Domestic ?
        <input name="ship_mode" type="radio" class="ship_mode" value="int" />International
        <input name="ship_mode" type="radio" class="ship_mode" value="dom" checked="checked"/>Domestic
    </div>
    <div class="cDrop" style="display:none;">
    Country From:
    <select name="countryFrom" id="countryFrom">
    	<?php $query = mysql_query("select * from countries",$cn)or die(mysql_error());
					while($countries = mysql_fetch_array($query))
					{?>
					<option value="<?php echo $countries['cid'];?>" <?php if($countries['cid'] == 'CA'){ echo 'selected="selected"';} ?>><?php echo $countries['name'];?></option>
					<?php }
		?>
    </select>
     Country To:
    <select name="countryTo" id="countryTo">
    	<?php $query = mysql_query("select * from countries",$cn)or die(mysql_error());
					while($countries = mysql_fetch_array($query))
					{?>
					<option value="<?php echo $countries['cid'];?>" <?php if($countries['cid'] == 'CA'){ echo 'selected="selected"';} ?>><?php echo $countries['name'];?></option>
					<?php }
		?>
    </select>
    		
    </div>
    <table width="99%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="10%" height="52">Postal Code From : </td>
        <td width="7%"><input name="txt_from" type="text" id="txt_from" value="<?php echo $from;?>" size="10"/></td>
        <td width="3%"><div align="right">To : </div></td>
        <td width="8%"><input name="txt_to" type="text" id="txt_to" value="<?php echo $to;?>" size="10" />        </td>
        <td width="10%">Shipment Types : </td>
        <td width="10%"><input name="ship_type" type="radio" value="02" checked="checked" onclick="show()"/>
          Custom Package
          <input name="ship_type" type="radio" value="01"  onclick="hide()"/>
        Courier Envelope</td>
        <td width="6%"><div align="right">Weight :</div></td>
        <td width="6%"><div align="right">
            <input name="txt_weight" type="text" id="txt_weight" size="10"  value="<?php echo $weight;?>" />
        </div></td>
        <td width="36%" colspan="2"><div id="dm">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="16%"><div align="right">Length:</div></td>
                <td width="19%"><div align="right">
                    <input name="txt_length" type="text" id="txt_length" size="10"  value="<?php echo $length;?>"/>
                </div></td>
                <td width="14%"><div align="right">Width:</div></td>
                <td width="21%">
                  <div align="left">
                    <input name="txt_width" type="text" id="txt_width" size="10" value="<?php echo $width;?>" />
                  </div></td>
                <td width="11%"><div align="right">Height:</div></td>
                <td width="19%"><input name="txt_height" type="text" id="txt_height" size="10"  value="<?php echo $height;?>"/></td>
              </tr>
            </table>
        </div></td>
      </tr>
      <tr>
	 <td colspan="8" valign="top">
	 <?php if(isset($_SESSION['Admin_Email']))
	 {?>
	 <div id="accordion">
            <div align="left"><b>Carriers:</b>
           Canada Post
             <input type="checkbox" id="check_canada" name="check_canada" value="yes" <?php if($_SESSION['check_canada'] =='yes'){ ?> checked="checked"<?php }?>  />  
           FeDex
           <input type="checkbox" id="check_fedex" name="check_fedex" value="yes" <?php if($_SESSION['check_fedex'] =='yes'){ ?> checked="checked"<?php }?>/>  
           UPS
           <input type="checkbox" id="check_ups" name="check_ups" value="yes" <?php if($_SESSION['check_ups'] =='yes'){ ?> checked="checked"<?php }?> />	  
           Purolator
           <input type="checkbox" id="check_puro" name="check_puro" value="yes" <?php if($_SESSION['check_puro'] =='yes'){ ?> checked="checked"<?php }?> /> 
           TnT
           <input type="checkbox" id="check_tnt" name="check_tnt" value="yes" <?php if($_SESSION['check_tnt'] =='yes'){ ?> checked="checked"<?php }?> />
           DHL
           <input type="checkbox" id="check_dhl" name="check_dhl" value="yes" <?php if($_SESSION['check_dhl'] =='yes'){ ?> checked="checked"<?php }?> />
         <b>Discounted Rate :</b>
			Show<input name="disc" type="radio" value="02"  checked="checked" onclick="showColumn()"/>
			Hide<input name="disc" type="radio" value="01"   onclick="hideColums()"/>
	 </div> </td>	 <?php }?>

	     
      <td valign="top"><div align="right">
        <input name="submit" type="button" id="submit" onclick="return getRates();" value="Get Rates Ajax" />
        <input name="submit" type="submit" id="submit" value="Get Rates" />
        <input name="clear" type="submit" id="star" value="Clear" />
      </div></td>
      </tr>
    </table>
  </div>
  <input name="loginType" type="hidden" id="loginType"  value="<?php if(isset($_SESSION['Admin_Email'])) { echo "admin";} else { echo "user"; } ?>" />
  <input name="checkCanada" type="hidden" id="checkCanada" value="<?php if($_SESSION['DB_CANADAPOST'] == 'Y') { echo 1;}?>" />
  <input name="checkFedex" type="hidden" id="checkFedex" value="<?php if($_SESSION['DB_FEDEX'] == 'Y') { echo 1;}?>" />
  <input name="checkPur" type="hidden" id="checkPur" value="<?php if($_SESSION['DB_PUROLATOR'] == 'Y') { echo 1;}?>" />
  <input name="checkUps" type="hidden" id="checkUps" value="<?php if($_SESSION['DB_UPS'] == 'Y') { echo 1;}?>" />
  <input name="checkTnt" type="hidden" id="checkTnt" value="<?php if($_SESSION['DB_TNT'] == 'Y') { echo 1;}?>" />
</form>
<div class="mainRecords" style="display:none;">
	<div class="box firstBox">
    	<div class="heading"><h3>First Day Rates</h3></div>
        <ul>
        	<li class="head">
            	<span class="service">Service</span>
                <span class="rate">Rate</span>
                <span class="discount">Yours</span>
                <span class="date">Delivery Date</span>
           	</li>
        </ul>
	</div>
    <div class="box secondBox">
    	<div class="heading"><h3>Second Day Rates</h3></div>
        <ul>
        	<li class="head">
            	<span class="service">Service</span>
                <span class="rate">Rate</span>
                <span class="discount">Yours</span>
                <span class="date">Delivery Date</span>
           	</li>
        </ul>
	</div>
    <div class="box thirdBox">
    	<div class="heading"><h3>Ground (1 to 10 Days)</h3></div>
        <ul>
        	<li class="head">
            	<span class="service">Service</span>
                <span class="rate">Rate</span>
                <span class="discount">Yours</span>
                <span class="date">Delivery Date</span>
           	</li>
        </ul>
	</div>
</div>
</br>
<?php if($sub){?>

<table>
<div>

<div class="left"> <h3 style="border-bottom:#666666 solid 1px">First Day</h3>
<?php
	echo "<div class='smallCell'><b>Services</div>"."<div class='smallCell2'>Rates($)</b></div><br/><div class='clear'></div>";
	foreach($first_day_rates as $name => $value) // ship code /service_code
	{
		if($value>0)
		{
		$cls = '';
		if (strpos($name, 'Canada') !== false) {
			$cls = 'Canada';
		}
		elseif (strpos($name, 'Fedex') !== false) {
			$cls = 'Fedex';
		}
		elseif (strpos($name, 'Purolator') !== false) {
			$cls = 'Purolator';
		}
		elseif (strpos($name, 'UPS') !== false) {
			$cls = 'UPS';
		}
		elseif (strpos($name, 'TnT') !== false) {
			$cls = 'TnT';
		}
		echo "<div class='".$cls."'><div class='smallCell'>".$name."</div>"."<div class='smallCell2'>".round($value,3)."</div></div><br/><div class='clear'></div>";
		}
 	}?>
</div>
<div class="your" id="your1"><h3 style="border-bottom:#666666 solid 1px">.</h3>
<?php
	echo "<div class='smallCell2'><b>Your($)</b></div><br/><div class='clear'></div>";
	foreach($first_day_disc_rates as $name => $value) // ship code /service_code
	{
		if($value>0)
		{
		echo "<div class='smallCell2'>".round($value,3)."</div><br/><div class='clear'></div>";
		}
 	}
	?>
</div>

<div class="left"> <h3 style="border-bottom:#666666 solid 1px">Second Day</h3>
<?php
	echo "<div class='smallCell'><b>Services</div>"."<div class='smallCell2'>Rates($)</b></div><br/><div class='clear'></div>";
	foreach($second_day_rates as $name => $value) // ship code /service_code
	{
	if($value>0)
		{
		$cls = '';
		if (strpos($name, 'Canada') !== false) {
			$cls = 'Canada';
		}
		elseif (strpos($name, 'Fedex') !== false) {
			$cls = 'Fedex';
		}
		elseif (strpos($name, 'Purolator') !== false) {
			$cls = 'Purolator';
		}
		elseif (strpos($name, 'UPS') !== false) {
			$cls = 'UPS';
		}
		elseif (strpos($name, 'TnT') !== false) {
			$cls = 'TnT';
		}
		echo "<div class='".$cls."'><div class='smallCell'>".$name."</div>"."<div class='smallCell2'>".round($value,3)."</div></div><br/><div class='clear'></div>";
 		}
	}?>
</div>
<div class="your" id="your2"><h3 style="border-bottom:#666666 solid 1px">.</h3>
<?php
	echo "<div class='smallCell2'><b>Your($)</b></div><br/><div class='clear'></div>";
	foreach($second_day_disc_rates as $name => $value) // ship code /service_code
	{
		if($value>0)
		{
		echo "<div class='smallCell2'>".round($value,3)."</div><br/><div class='clear'></div>";
 		}
	}
	?></div>
<div class="left"><h3 style="border-bottom:#666666 solid 1px">Ground (1 to 10 Days)</h3>
<?php
	echo "<div class='smallCell'><b>Services</div>"."<div class='smallCell2'>Rates($)</b></div><br/><div class='clear'></div>";
	foreach($third_day_rates as $name => $value) // ship code /service_code
	{
	if($value>0)
		{
		$cls = '';
		if (strpos($name, 'Canada') !== false) {
			$cls = 'Canada';
		}
		elseif (strpos($name, 'Fedex') !== false) {
			$cls = 'Fedex';
		}
		elseif (strpos($name, 'Purolator') !== false) {
			$cls = 'Purolator';
		}
		elseif (strpos($name, 'UPS') !== false) {
			$cls = 'UPS';
		}
		elseif (strpos($name, 'TnT') !== false) {
			$cls = 'TnT';
		}
		echo "<div class='".$cls."'><div class='smallCell'>".$name."</div>"."<div class='smallCell2'>".round($value,3)."</div></div><br/><div class='clear'></div>";
 		}
	}?>
</div>

<div class="your" id="your3"><h3 style="border-bottom:#666666 solid 1px">.</h3>
<?php
	echo "<div class='smallCell2'><b>Your($)</b></div><br/><div class='clear'></div>";
	foreach($third_day_disc_rates as $name => $value) // ship code /service_code
	{
	if($value>0)
		{
		echo "<div class='smallCell2'>".round($value,3)."</div><br/><div class='clear'></div>";
 		}
	}
	?></div>

</div></table>
<?php }?>

<script>
jQuery(window).load(function() {
	//jQuery('#loading-image').hide();
});
</script>
