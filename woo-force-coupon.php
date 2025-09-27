<?php
/**
 * Plugin Name: Force Coupon for WooCommerce
 * Plugin URI: http://kowsarhossain.com/
 * Description: A lightweight WooCommerce based plugin to force the customer to enter a coupon code during checkout
 * Version: 1.0.0
 * Author: Md. Kowsar Hossain
 * Author URI: http://kowsarhossain.com
 * Text Domain: woo-force-coupon
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

if ( ! defined( 'WPINC' ) ) die;

// exit if WooCommerce not activated
if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
	return;
}

define('WFCFOA_BASENAME', plugin_basename(__FILE__));

if ( is_admin() ):
	require_once dirname( __FILE__ ) . '/admin/class-settings-api.php';
	require_once dirname( __FILE__ ) . '/admin/class-woo-force-coupon-admin.php';
	FOA_Woo_Force_Coupon_Admin::instance();
endif;

require_once dirname( __FILE__ ) . '/public/class-woo-force-coupon.php';
FOA_Woo_Force_Coupon::instance();