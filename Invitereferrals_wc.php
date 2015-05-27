<?php
/**
* Plugin Name: Invitereferrals - Referral Marketing Software For WooCommerce
* Plugin URI: http://www.Invitereferrals.com
* Description: Launch Your WooCommerce Referral Program which boost your sales and traffic. Invitereferrlas provides detailed tracking of each sales conversion through referral campaign. We have helped businesses to grow revenue by up to 25% by enabling trusted customer friend referrals.
* Version: 1.0
* Author: Invitereferrals
* Author URI: http://www.Invitereferrals.com
* License: GPLv2
**/

// Version check
global $wp_version;
if(!version_compare($wp_version, '3.0', '>='))
{
    echo "Invitereferrals requires WordPress 3.0 or above. <a href='http://codex.wordpress.org/Upgrading_WordPress'>Please update WordPress to latest Version!</a>";
}
// END - Version check

else
{
	// Check if class exists already.\
	if(!class_exists('Invitereferrals_wc')) { 

		class Invitereferrals_wc
		{
			private $plugin_id; // Plugin's id
			private $order_id;  // store the current order id
			private $options;

			// Defining Constructor
			public function __construct($id) {
				// Start Session
				session_start();
				$this->plugin_id = $id;
				$this->options = array('Invitereferrals_key' => '', 'Invitereferrals_enable' => 'on' );
				$this->options = array('Invitereferrals_id' => '', 'Invitereferrals_enable' => 'on' );

				register_activation_hook(__FILE__, array(&$this, 'update_Invitereferrals_options'));

				// Initiallizing plugin admin options
				add_action('admin_init', array(&$this, 'init'));
				// Add admin menu item
				add_action('admin_menu', array(&$this, 'Invitereferrals_admin_options'));

				// Check if WooCommerce is active
				if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
					// Execute Invitereferrals_inovice if order processed
					add_action('woocommerce_checkout_order_processed', array(&$this, 'Invitereferrals_invoice'));
					// Add plugin's code at wp_head
					add_action('wp_head', array(&$this, 'Invitereferrals_campaign_script'));
				}
			}

			// Initiallize
			public function init()
			{
				register_setting($this->plugin_id.'_options', $this->plugin_id);
			}

			// Update new options in Database
			public function update_Invitereferrals_options()
			{
				update_option($this->plugin_id, $this->options);
			}

			// Get options from Database
			private function get_Invitereferrals_options()
			{
				$this->options = get_option($this->plugin_id);
			}

			// Add order_id in session variable
			public function Invitereferrals_invoice($order_id) {
				// Start Session
				session_start();
				$_SESSION['Invitereferrals_invoice'] = $order_id;
			}

			// Add script at wp_head
			public function Invitereferrals_campaign_script() {
				$this->get_Invitereferrals_options();
				if($this->options['Invitereferrals_enable'] == 'on' && $this->options['Invitereferrals_key'] != '')
				{
					$flag = false;
					// Script Javascript Code
					//echo '<script>';
					//echo 'var apiKey="'.$this->options['Invitereferrals_key'].'";';
					
					
					// If order processed
					if(isset($_SESSION['Invitereferrals_invoice']) && $_SESSION['Invitereferrals_invoice'] != -1)
					{
						// Get order id from session variable
						$this->order_id = $_SESSION['Invitereferrals_invoice'];
						// Reset session variable
						$_SESSION['Invitereferrals_invoice'] = -1;
						// Check if WC_Order class exists
						if(class_exists('WC_Order'))
						{
							// Send data to Invitereferrals API
							$order = new WC_Order($this->order_id);
							$order_total = $order->get_total( );
							$order_id = $this->order_id;							
							$order_subtotal = $order->get_subtotal_to_display();
							$order_subtotal = preg_replace("/[^0-9.]/", "", $order_subtotal);
							$order_subtotal = preg_replace('{^\.}', '', $order_subtotal, 1);
							$order_coupons = $order->get_used_coupons( );
							$order_coupon = $order_coupons[0];
							$order_items = ($order->get_items());
							foreach ($order_items as $order_item) {
								$cartInfoArray[] =  array("id" => $order_item['product_id'], "name" => $order_item['name'], "quantity" => $order_item['qty']);
							}
							$cartInfo = serialize($cartInfoArray);
							$order_email = $order->billing_email;
							$order_name = $order->billing_first_name.' '.$order->billing_last_name;
							$flag = true;
						}
					}
					
					/*
					if($flag)
						echo 'var showButton = false;';
					else
						echo 'var showButton = true;';
					echo '</script>';
					echo '<script src="//rfer.co/api/v1/js/all.js"></script>'; // Javascript code end
					*/
					
					
							echo "<div id='invtrflfloatbtn'></div>
							<script>	
							var invite_referrals = window.invite_referrals || {}; (function() { 
							invite_referrals.auth = { 
							bid_e : '".$this->options['Invitereferrals_key']."',
							bid : '".$this->options['Invitereferrals_id']."', email : '".$setUserEmail."',
							t : '420', userParams : {'fname' : '".$fname."'} };	
							var script = document.createElement('script');script.async = true;
							script.src = (document.location.protocol == 'https:' ? '//d11yp7khhhspcr.cloudfront.net' : '//cdn.invitereferrals.com') + '/js/invite-referrals-1.0.js';
							var entry = document.getElementsByTagName('script')[0];entry.parentNode.insertBefore(script, entry); })();
							</script>";	
					
					
					
					
					if($flag)
					{

						/*
						echo "<script>"; // Tracking Code
						echo "invoiceInvitereferrals('$order_subtotal', '$order_total', '$order_coupon', '$cartInfo', '$order_name', '$order_email');";
						echo "</script>";
						*/
						
						echo "
						<img style='position:absolute; visibility:hidden' src='https://www.ref-r.com/campaign/t1/settings?
						bid_e=".$this->options['Invitereferrals_key']."
						&bid=".$this->options['Invitereferrals_id']."
						&t=420
						&event=sale
						&email=$order_email
						&orderID=$order_id
						&purchaseValue=$order_total' />
						";
						
						
						
					}
				}
			}

			// Add plugin in Admin Menu
			public function Invitereferrals_admin_options() {
				add_options_page('Invitereferrals Options', 'Invitereferrals_wc', 'manage_options', $this->plugin_id.'-options', array(&$this, 'Invitereferrals_options_page'));
			 
			}

			// Render Admin Options Page
			public function Invitereferrals_options_page()
			{
				if (!current_user_can('manage_options'))
				{
					wp_die( __('You can manage options from the Settings->Invitereferrals Options menu.') );
				}

				// Include option's page
				include_once('Invitereferrals_options.php');
			}

		}

		// Let's Start
		$Invitereferrals_wc = new Invitereferrals_wc('Invitereferrals_wc');
	}
}
?>