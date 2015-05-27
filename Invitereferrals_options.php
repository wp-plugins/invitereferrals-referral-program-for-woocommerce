<style type="text/css">
.Invitereferrals_button {
	background: #F9745F;
	padding: 13px 15px;
	border-radius: 4px;
	margin-top: -13px;
	font-weight: bold;
	border: 0;
	cursor: pointer;
	-webkit-transition: all 0.2s ease-in;
	-moz-transition: all 0.2s ease-in;
	-o-transition: all 0.2s ease-in;
	transition: all 0.2s ease-in;
	color: #FFF;
}
.Invitereferrals_button:hover {
	background: #6DBDDC;
}
.Invitereferrals_col {
	width: 50%;
	float: left;
}
.Invitereferrals_desc {
	float: right;
	width: 40%;
	margin-top: 20px;
	background: #FFF;
	padding: 10px;
	border-radius: 10px;
}
.Invitereferrals_logo {
	width: 96px;
	margin: 0 auto;
}
.Invitereferlas_line2{
	font-weight: bold;
	
}
</style>
<div class="wrap">
	<div class="Invitereferrals_col">
	    <h2>Invitereferrals Campaign Settings</h2>
	    <hr/>
	    <?php
	    $this->get_Invitereferrals_options();
	    
	    if(isset($_POST['submit']))
	    {
	    	$this->options['Invitereferrals_key'] = $_POST['Invitereferrals_key'];
	    	$this->options['Invitereferrals_id'] = $_POST['Invitereferrals_id'];
	    	$this->options['Invitereferrals_enable'] = $_POST['Invitereferrals_enable'];
	   		$this->update_Invitereferrals_options();
	   		echo '<div class="updated"><p><strong>Options saved.</strong></p></div>';
	    }

	    // Check if WooCommerce is active
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	    ?>

	    <form name="<?php echo $this->plugin_id;?>_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	        <table cellpadding="5" cellspacing="5">
	        	<tr>
	        		<td>
	        			<label><strong>Invitereferrals Encrypted Key:</strong></label>
	        		</td>
	        		<td>
	        			<input style="width:100%; height: 35px; border-radius:5px;" type="text" name="Invitereferrals_key" value="<?php echo $this->options['Invitereferrals_key']; ?>" placeholder="Invitereferrals Encrypted Key">
	        		</td>
	        	</tr>
				
				
				<tr>
	        		<td>
	        			<label><strong>Invitereferrals Brand ID:</strong></label>
	        		</td>
	        		<td>
	        			<input style="width:100%; height: 35px; border-radius:5px;" type="text" name="Invitereferrals_id" value="<?php echo $this->options['Invitereferrals_id']; ?>" placeholder="Invitereferrals Brand ID">
	        		</td>
	        	</tr>
				
				
				
				
				
				
	        	<tr>
	        		<td></td>
	        		<td>
	        			<small>(You first need to Sign Up on Invitereferrals.com to get <strong>BrandID</strong> and <strong>Encrypted Key</strong>. Set-up your campaign. <a href="http://www.invitereferrals.com/campaign/brand/register" target="_blank">Click here</a> to sign up.)</small>
	        			<hr/>
	        		</td>
	        	</tr>
	        	<tr>
	        		<td style="padding-bottom: 20px">
	        			<label><strong>Enable Campaign:</strong></label>
	        		</td>
	        		<td>
	        			<input type="checkbox" name="Invitereferrals_enable" <?php if($this->options['Invitereferrals_enable'] == 'on') echo 'checked'; ?> >
	        			<hr/>
	        		</td>
	        	</tr>
	        	<tr>
	        		<td></td>
	        		<td>
	        			<p class="submit"><input class="Invitereferrals_button" type="submit" name="submit" value="Update Options" /></p>
	        		</td>
	        	</tr>
	        </table>        
	    </form>
		<?php
		}
	    else
	        echo '<div class="wrap"><h3 style="color:#F36969">Either WooCommerce is not installed or it is not active.</h3></div>';
	   	?>
	</div>
	<div class="Invitereferrals_desc">
		<div></div>
		<hr/>
		<h3 style="text-align: center;">Simplest Referral Marketing Software.</h3> 
		<div style="text-align: justify;">Start your Custom Referrral Program. <a target="_blank" href="http://www.invitereferrals.com/campaign/brand/register">Sign Up Here </a>
		<br>For Queries Contact: <strong>support@tagnpin.com</strong>
		<br>For Documentation <a target="_blank" href="http://www.invitereferrals.com/campaign/documentation/home">Click Here </a>
		<br>Invitereferrlas WooCommerce Page <a target="_blank" href="http://www.invitereferrals.com/campaign/documentation/plugins">Click Here </a></div> 
	</div>
</div>