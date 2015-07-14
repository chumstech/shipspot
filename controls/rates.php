<?php
require_once("functions.php");
		    $selectedCarriers = array();
			$object = (object) array('user_id' => $userObj->id);
			$selectedCarriers = getUserSelectedCarriers($object);
			$countries = getCountries();

?>
<style>
table thead {
    color: #666;
}
</style>
<div class="rates">
	<div class="loadingList">
    	<!--<div class="item loadingUps"><img src="images/loading.gif" />Loading UPS Rates</div>
        <div class="item loadingFedex"><img src="images/loading.gif" />Loading Fedex Rates</div>
        <div class="item loadingPurolator"><img src="images/loading.gif" />Loading Purolator Rates</div>-->
    </div>
	<?php // echo '<pre>';print_r($userObj); ?>
	<div id="loading-image" style="display:none;">
	<img src="images/loading.gif" alt="Loading..." />
	</div>
  <form name="get_rates" enctype="multipart/form-data" method="post" action="index.php?para=3">
  <div class="image_wrapper_rate">
  <h3>Get Rates</h3>
  		<div class="rates-data">
        <div class="inter"> 
        <label class="shippingMode">International / Domestic ?</label>
        <input name="ship_mode" type="radio" class="ship_mode" value="int" /><label>International</label>
        <input name="ship_mode" type="radio" class="ship_mode" value="dom" checked="checked"/><label>Domestic</label>
        </div>
        <div class="country cDrop" style="display:none;">
        <div class="left">
    <label>Country From:</label>
    <select name="countryFrom" id="countryFrom">
     <?php 
     foreach($countries as $country)
     {?>
     <option value="<?php echo $country['cid'];?>" <?php if($country['cid'] == 'CA'){ echo 'selected="selected"';} ?>><?php echo $country['name'];?></option>
     <?php }
  ?>
    </select>
    </div>
        <div class="right">
         <label>Country To:</label>
        <select name="countryTo" id="countryTo">
         <?php 
         foreach($countries as $country)
         {?>
         <option value="<?php echo $country['cid'];?>" <?php if($country['cid'] == 'CA'){ echo 'selected="selected"';} ?>><?php echo $country['name'];?></option>
         <?php }
      ?>
        </select>
      	</div>
    	</div>
        <div class="ratesOptions" style="float: left; width: 85%;">
    		<div class="left-rates">
            <input placeholder="Postal Code From" name="txt_from" type="text" id="txt_from" value="<?php echo $from;?>" size="10"/>
            </div>
            <div class="right-rates">
            <input placeholder="Postal Code To" name="txt_to" type="text" id="txt_to" value="<?php echo $to;?>" size="10" />
            </div>
            <div class="left-data">
                    <div class="boxs boxleft" style="width:50%; float:left;">
                    <label>Shipment Types :</label>
                    <br />
                    <input name="ship_type" type="radio" value="02" checked="checked" onclick="show()"/>
                  <label>Custom Package</label>
                  <br />
                  <input name="ship_type" type="radio" value="01"  onclick="hide()"/>
                <label>Courier Envelope</label>
                </div>
                <?php if($userObj->is_discounted_rate == 1) { ?>
                <div class="boxs boxright" style="float:left;">
                    <label>Show Discount ?</label>
                    <br />
                    <input name="show_disc" class="show_disc" type="radio" value="1" checked="checked" onclick="showDisc()"/>
                  <label>Yes</label>
                  <br />
                  <input name="show_disc" class="show_disc" type="radio" value="0"  onclick="hideDisc()"/>
                <label>No</label>
                </div>
                <?php  } ?>
            </div>
            <div class="right-data pakageDetail">
            	 <div class="boxs">
               <input placeholder="Weight" name="txt_weight" type="text" id="txt_weight" size="10"  value="<?php echo $weight;?>" />
               </div>
               <div class="boxs dm">
               <input placeholder="Length" name="txt_length" type="text" id="txt_length" size="10"  value="<?php echo $length;?>"/>
                </div>
               <div class="boxs dm">
                <input placeholder="Width" name="txt_width" type="text" id="txt_width" size="10" value="<?php echo $width;?>" />
                 </div>
               <div class="boxs dm">
                <input placeholder="Height" name="txt_height" type="text" id="txt_height" size="10"  value="<?php echo $height;?>"/>      
               </div>
           <!--     <div class="" style="margin-top: 10px;float: left">
                <a href="javascript:;"> <img src="images/icn_plus01.png"/> </a>     
               </div>
               <div class="" style="float: left; margin-top: 10px; margin-left: 5px;">
                <a href="javascript:;"> <img src="images/icn_minus.png"/> </a>     
               </div>--> 
		 </div>
		 
        </div>    
            
            
    
  	 </div>
     <div class="carrier">
    <?php if($userObj->user_type == 2)
	 {?>
     	<div class="carier">
		<h3>Carriers:</h3>
        	<div class="left">
           <input type="checkbox" id="check_canada"  class="selectedCarriers" carrier_selected_id ="1" name="check_canada"  onclick="return updateUserSelectedCarriers();" value="yes" <?php if(in_array(1,$selectedCarriers)){ ?> checked="checked"<?php }?>  /> 
           <label>Canada Post</label> 
          <br />
           <input type="checkbox" id="check_fedex"  class="selectedCarriers" carrier_selected_id ="2" name="check_fedex" onclick="return updateUserSelectedCarriers();" value="yes" <?php if(in_array(2,$selectedCarriers)){ ?> checked="checked"<?php }?>/>
            <label>FeDex</label>  
          <br />
           <input type="checkbox" id="check_ups"  class="selectedCarriers" carrier_selected_id ="3" name="check_ups" onclick="return updateUserSelectedCarriers();" value="yes"  <?php if(in_array(3,$selectedCarriers)) { ?> checked="checked"<?php }?> />
            <label>UPS</label>	  
           	</div>
            <div class="right">
           <input type="checkbox" id="check_puro" class="selectedCarriers" carrier_selected_id ="4" name="check_puro" onclick="return updateUserSelectedCarriers();" value="yes" <?php if(in_array(4,$selectedCarriers)){ ?> checked="checked"<?php }?> /> 
           <label>Purolator</label>
          <br />
           <input type="checkbox" id="check_tnt" class="selectedCarriers" carrier_selected_id ="5" name="check_tnt" onclick="return updateUserSelectedCarriers();" value="yes" <?php if(in_array(5,$selectedCarriers)){ ?> checked="checked"<?php }?> />
            <label>TnT</label>
           <br />
           <input type="checkbox" id="check_dhl"  class="selectedCarriers" carrier_selected_id ="6"  onclick="return updateUserSelectedCarriers();" name="check_dhl" value="yes" <?php if(in_array(6,$selectedCarriers)){ ?> checked="checked"<?php }?> />
           <label>DHL</label>
           </div>
         </div>
	 <?php }?>    
          </div>
          <div class="submit">
            <input name="loginType" type="hidden" id="loginType"  value="<?php if($userObj->user_type == 1) { echo "admin";} else { echo "user"; } ?>" />
          <input name="checkCanada" type="hidden" id="checkCanada" value="0" />
          <input name="checkFedex" type="hidden" id="checkFedex" value="1" />
          <input name="checkPur" type="hidden" id="checkPur" value="0" />
          <input name="checkUps" type="hidden" id="checkUps" value="0" />
          <input name="checkTnt" type="hidden" id="checkTnt" value="0" />
          <input name="checkPostRates" type="hidden" id="checkPostRates" value="<?php echo $userObj->is_posted_rate;?>" />
          <input name="checkDiscountRates" type="hidden" id="checkDiscountRates" value="<?php echo $userObj->is_discounted_rate;?>" />
           <input name="star_user_id" type="hidden" id="star_user_id" value="<?php echo $userObj->id?>" />
             <input name="submit" class="btn btn-primary" type="button" id="submit" onclick="return getRates();" value="Get Rates" />
         	</div>
  </div>
</form>
<div class="mainRecords" style="display:none;">
	<div class="box firstBox">
    	<div class="heading"><h3>First Day Rates</h3></div>
        <table class="tablesorter" cellspacing="1">             
        <thead>
            <tr> 
                <th class="service">Service</th> 
                <th class="rate">Rate</th> 
                <th class="discount">Yours</th> 
                <th class="date">Delivery Date</th> 
            </tr> 
        </thead> 
        <tbody>
        	<tr>
            	<td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody> 
		</table>
	</div>
    <div class="box secondBox">
    	<div class="heading"><h3>Second Day Rates</h3></div>
        <table class="tablesorter" cellspacing="1">             
        <thead>
            <tr> 
                <th class="service">Service</th> 
                <th class="rate">Rate</th> 
                <th class="discount">Yours</th> 
                <th class="date">Delivery Date</th> 
            </tr> 
        </thead> 
         <tbody>
        	<tr>
            	<td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody> 
		</table>
	</div>
    <div class="box thirdBox">
    	<div class="heading"><h3>Ground (1 to 10 Days)</h3></div>
        <table class="tablesorter" cellspacing="1">             
        <thead>
            <tr> 
                <th class="service">Service</th> 
                <th class="rate">Rate</th> 
                <th class="discount">Yours</th> 
                <th class="date">Delivery Date</th> 
            </tr> 
        </thead> 
        <tbody>
        	<tr>
            	<td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody> 
		</table>
	</div>
</div>
</br>
<?php if($sub){?>
</div>

<?php }?>
</div>
<script>
jQuery(window).load(function() {
	//jQuery('#loading-image').hide();
});
$(document).ready(function() { 
    $("table").tablesorter( {sortList: [[1,0]]} ); 
});          
</script>
