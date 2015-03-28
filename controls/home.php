<div class="home">
<?php if ((@$_SESSION['Admin_Email']) || (@$_SESSION['Email'])) { ?>
	<div class="carriers">
    	  <!--<h2>Carriers</h2>-->
    	  <?php include('carriers.php'); ?>
    </div>
    <?php } ?>
    <?php if (!(@$_SESSION['Admin_Email']) && !(@$_SESSION['Email'])) { ?>
    <div class="login">
    	<form id="" method="post" action="./controls/login.php">
                   <h2>Login</h2>
                   <div class="message"><?php echo $msg;?></div>
                   <div class="fields">
                   		<div class="field">
                        	<label>User Name:</label>
                       		<input name="txt_Email" type="text" id="txt_Email"/>
                        </div>
                        <div class="field">
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


