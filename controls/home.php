<div class="home">
<div class="leftContent">
	<div class="rates">
    <div class="image_wrapper_rate">
    <h3>Welcome to ShipSpot</h3>
    <div class="homeTxt">
     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent non velit sit amet tellus scelerisque mattis. Donec luctus fringilla odio, id sollicitudin libero molestie vitae. Sed blandit mauris ac nulla sollicitudin vehicula. Nullam in tellus lorem. Nulla ornare nisi arcu, ac volutpat lectus mollis id. Sed et pellentesque tortor. Nam vel enim vehicula, bibendum nunc non, sagittis diam. In hac habitasse platea dictumst. Fusce nunc leo, consectetur eget nisl at, mattis interdum nunc. Nulla sit amet erat viverra sapien tincidunt blandit. Cras consectetur id mi sit amet ultrices. Nulla lacinia, leo in scelerisque mattis, quam nibh vulputate ipsum, ac vehicula turpis neque et est.</p>
<img src="images/steps.png" style="width: 450px; margin: 0% 25%;" alt="Steps"/>
<p>Donec sit amet ultrices magna. Suspendisse ultrices augue nisi, dictum lobortis urna euismod quis. Integer risus mauris, interdum vitae sapien non, rhoncus blandit eros. Praesent quis nisl et dolor tincidunt pellentesque. Cras vitae lorem placerat, ultricies purus id, pellentesque felis. Cras ut nulla ac nulla accumsan pretium. Pellentesque id pellentesque ipsum. Nulla tristique placerat felis, et mattis mauris sollicitudin vel. Suspendisse ultricies condimentum sodales. Donec in orci nisi. Sed nec purus dictum, blandit elit at, dapibus neque. Sed eu fringilla diam. Pellentesque venenatis eu nisl sodales convallis. Curabitur feugiat mauris vel tellus posuere vestibulum. </p>
    </div>
    </div>
</div>
</div>
<div class="rightContent">
	<div class="rates">
    <div class="image_wrapper_rate">
    <h3>How its Works</h3>
    <div class="homeTxt">
     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent non velit sit amet tellus scelerisque mattis. Donec luctus fringilla odio, id sollicitudin libero molestie vitae. Sed blandit mauris ac nulla sollicitudin vehicula. Nullam in tellus lorem. Nulla ornare nisi arcu, ac volutpat lectus mollis id. Sed et pellentesque tortor. Nam vel enim vehicula, bibendum nunc non, sagittis diam. In hac habitasse platea dictumst. Fusce nunc leo, consectetur eget nisl at, mattis interdum nunc. Nulla sit amet erat viverra sapien tincidunt blandit. Cras consectetur id mi sit amet ultrices. Nulla lacinia, leo in scelerisque mattis, quam nibh vulputate ipsum, ac vehicula turpis neque et est.</p>
    </div>
    </div>
</div>
</div>

<div class="rates">
    <div class="image_wrapper_rate">
    <h3>We Offers Shippments For</h3>
    <div id="owl-demo">         
      <div class="item"><img src="images/fedexSlider.gif" alt="FedEx"></div>
      <div class="item"><img src="images/candaPostSlider.jpg" alt="Canada Post"></div>
      <div class="item"><img src="images/dhlSlider.png" alt="DHL"></div>
      <div class="item"><img src="images/upsSlider.png" alt="UPS"></div>
      <div class="item"><img src="images/purolatorSlider.png" alt="Purolator"></div>
      <div class="item"><img src="images/tntSlider.png" alt="TNT"></div>
      <div class="item"><img src="images/loomisSlider.png" alt="Loomis"></div>
    </div>
    </div>
</div>
<?php 
$userObj = "";
if(isset($_SESSION['user'])){
	$userObj = (object)	$_SESSION['user'];
}
?>
<?php if ($userObj->user_type == 1 || $userObj->email) { ?>
	<div class="carriers">
    	  <!--<h2>Carriers</h2>-->
    	  <?php // include('carriers.php'); ?>
    </div>
    <?php } ?>
    <?php if ($userObj->user_type != 1 && $userObj->email == '') { ?>
    <div class="login">
    	<form id="" method="post" action="./controls/login.php">
                   <h2>Login</h2>
                   <div class="message"><?php echo $msg;?></div>
                   <div class="fields">
                   		<div class="field">
                        	<label>User Name:</label>
                       		<input name="txt_Email" type="text" id="txt_Email"/>
                        </div>
                        <div class="field" style="margin-bottom:20px;">
                        	<label>Password:</label>
                         	<input name="txt_Password" type="password" id="txt_Password"/>
                       </div>
                       <div class="field">
                         <input name="ok" type="submit" id="ok" value="Ok" />
                         <input name="cancel" type="reset" id="cancel" value="Cancel" />
                       </div>
                         </div>
                    </div>
                   </div>
			</form>
    </div>
    <?php } ?>
</div>


