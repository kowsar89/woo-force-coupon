<?php

if ( !class_exists('FOA_Woo_Force_Coupon_Admin' ) ):

class FOA_Woo_Force_Coupon_Admin {
    
    private static $instance = null;
    public $plugin_slug = 'woo-force-coupon';
    private $settings_api;

    private function __construct() {

        $this->settings_api = new FOA_Woo_Force_Coupon_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );

        add_filter('plugin_action_links_'.WFCFOA_BASENAME, array( $this, 'plugin_settings_link' ) ); 
    }

    public static function instance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // Settings link for plugin page
    public function plugin_settings_link($links) {
        $settings_link = '<a href="'. esc_url( get_admin_url(null, "admin.php?page=$this->plugin_slug") ) .'">'.__('Settings', 'woo-force-coupon').'</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    public function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    public function admin_menu() {
        add_submenu_page( 'woocommerce', 'Woo Force Coupon', 'Force Coupon', 'manage_options', $this->plugin_slug, array($this, 'plugin_page') );
    }

    public function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'foa_woo_force_coupon',
                'title' => __( 'Woo Force Coupon', 'woo-force-coupon' )
            )
        );

        return $sections;
    }

    /**
     * Returns all the settings fields
     *  
     * @return array settings fields
     */
    public function get_settings_fields() {
        $settings_fields = array(
            'foa_woo_force_coupon' => array(
                array(
                    'name'    => 'errornotice',
                    'label'   => __( 'Error Notice', 'woo-force-coupon' ),
                    'desc'    => __( 'Error notice when no coupon is applied', 'woo-force-coupon' ),
                    'type'    => 'textarea',
                    'placeholder'    => __( 'eg. Coupon is a required field. Please enter a coupon', 'woo-force-coupon' ),
                ),
                array(
                    'name'    => 'couponmsg',
                    'label'   => __( 'Coupon Text', 'woo-force-coupon' ),
                    'desc'    => __( 'If this field is empty then default will be used</br>Default: Have a coupon?&lt;a href=&quot;#&quot; class=&quot;showcoupon&quot;&gt;Click here to enter your code&lt;/a&gt;', 'woo-force-coupon' ),
                    'type'    => 'textarea',
                    'placeholder'    => __( 'Have a coupon?&lt;a href=&quot;#&quot; class=&quot;showcoupon&quot;&gt;Click here to enter your code&lt;/a&gt;', 'woo-force-coupon' ),
                ),
            )
        );

        return $settings_fields;
    }

    public function plugin_page() {
        echo '<div class="wrap">';
        $this->settings_api->show_forms();
        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    public function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}

endif;
