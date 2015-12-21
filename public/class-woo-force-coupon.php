<?php

if ( !class_exists('FOA_Woo_Force_Coupon' ) ):

class FOA_Woo_Force_Coupon {

    private static $instance = null;
    public $plugin_slug = 'woo-force-coupon';

    private function __construct() {
        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
        add_action( 'woocommerce_checkout_process', array( $this, 'coupon_validation' ) );
        add_action( 'woocommerce_checkout_coupon_message', array( $this, 'coupon_message' ) );
    }

    public static function instance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // textdomain
    public function load_textdomain(){
        load_plugin_textdomain( 'woo-force-coupon', false, $this->plugin_slug. '/languages/' );
    }

    // validate coupon
    public function coupon_validation(){
        $wc = WC();
        $coupons = $wc->cart->get_coupons();

        if(empty($coupons)){
            $options = get_option( 'foa_woo_force_coupon', '' );
            $errornotice = empty($options['errornotice'])? __( 'Coupon is a required field. Please enter a coupon.', 'woo-force-coupon' ): $options['errornotice'];

            wc_add_notice( $errornotice , 'error' );
        }
    }

    // change coupon message
    public function coupon_message($msg){
        $options = get_option( 'foa_woo_force_coupon', '' );
        $couponmsg = empty($options['couponmsg'])? $msg : $options['couponmsg'];
        return $couponmsg;
    }

}

endif;
