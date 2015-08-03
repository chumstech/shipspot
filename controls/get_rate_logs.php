<style type="text/css">
<!--
.style3 {
	font-size: 12px;
	font-weight: bold;
}

.style4 {font-size: 12px}

.action {
    float: right;
    margin-bottom: 20px;
    margin-right: 3%;
    width: 12%;
}
-->
</style>
  <script>
  $(function() {
    $( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  </script>
<h2>Get Rate Log List</h2> 
	<div class="filter">
    <form method="post" action="" name="filterLog">
    	    <label for="from">From</label><input type="text" id="from" name="from" value="<?php echo @$_POST['from']; ?>"><label for="to">to</label><input type="text" id="to" name="to" value="<?php echo @$_POST['to']; ?>">
            <input type="submit" class="btn btn-primary btn-lg" value="Filter" id="Submit" name="Submit" style="margin-left: 10px;">
    </form>
    </div>    
<div class="notice"><?php echo $msg;?></div>
                   
    <form id="form1" name="form1" method="post" action="">
      <table width="100%" border="1" cellpadding="0" cellspacing="0" id="carriers" class="table table-striped table-bordered">
		<tr>
          <td width="5%"><div align="center"><strong>Sr#</strong></div></td>
          <td width="12%"><div align="center"><strong>User Name</strong></div></td>
          <td width="12%"><div align="center"><strong>Carrier Name</strong></div></td>
          <td width="10%"><div align="center"><strong>Response Type</strong></div></td>
          <td width="35%"><div align="center"><strong>Response</strong></div></td>
          <td width="12%"><div align="center"><strong>Date and Time</strong></div></td>
        </tr>
        <?php 
		if(isset($_POST['Submit']))
		{
		$from = $_POST['from'];
		$to = $_POST['to'];
		
		$fromF = date("Y-m-d H:i:s", strtotime($from));
		$toF = date("Y-m-d H:i:s", strtotime($to));
		
		$QueryString = "select * from api_log Where created_date BETWEEN '".$fromF."' AND '".$toF."' Order by created_date DESC";	
		}
		else
		{
		$QueryString = "select * from api_log Order by created_date DESC";	
		}
  		
		$Query = mysql_query($QueryString,@$cn);
		$count = 1;
		$total = mysql_num_rows($Query);
		if($total > 0)
		{
			while($data = mysql_fetch_array($Query)){
			?>
			<tr>
			  <td><?php echo @$count; ?></td>
			  <td><?php echo getUserName($data['user_id']); ?></td>
			  <td><?php echo @$data['api_name']; ?></td>
			  <td><?php echo @$data['response_short']; ?></td>
			  <td><?php echo @$data['response']; ?></td>
			  <td><?php echo date("j F Y h:i:s A", strtotime($data['created_date'])); ?></td>
			</tr>
			<?php $count++;}
		}
		else
		{?>
		<tr>
			  <td colspan="6" style="text-align:center;"><?php echo "No Log Available!"; ?></td>
			</tr>	
		<?php }
		?>
      </table>
</form>

