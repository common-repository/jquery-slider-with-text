<?php

/**
 * Class SpinSlider
 * @package spininteractive-slider
 * @author Spin Interactive <dev@spin-interactive.com>
 * @version 1.0
 */

class SpinSlider {

    private static $initiated = false;

    public static function init() {
        if ( ! self::$initiated ) {
            self::init_hooks();
        }
    }

    private static function init_hooks() {
        self::$initiated = true;
        if(is_admin()) {
            /* Backoffice */
            //load_plugin_textdomain( 'spin-interactive-slider' );
            add_action( 'admin_menu', array( 'SpinSlider', 'admin_menu' ) );
            add_action( 'admin_notices', array( 'SpinSlider', 'admin_notices' ) );
        }
        else {
            /* Frontoffice */
            wp_enqueue_style("spininteractive_slider_css", plugin_dir_url(__FILE__) . "inc/style.css", null, "1.0");
            wp_enqueue_script("spininteractive_slider_script", plugin_dir_url(__FILE__) . "inc/script.js", null, "1.0", true);
        }
        add_shortcode( 'spinslider', array( 'SpinSlider', 'spinslider_shortcode' )  );
    }

    //[spinslider]
    function spinslider_shortcode( $atts ){
        global $wpdb;
        $slides = ($wpdb->get_results("SELECT * FROM spinslider ORDER BY id ASC"));
        $html = '<div class="spininteractive-slider">';
        $html .=  '<ul>';
        foreach($slides as $slide) {
            $html .= '<li><img data-url="" src="'.$slide->image.'" /><div class="description">'.$slide->title.'</div></li>';
        }
        $html .=  '</ul>';
        $html .=  '<span class="arrows arrow-left"></span>';
        $html .=  '<span class="arrows arrow-right"></span>';
        $html .= '</div>';
        return $html;
    }

    public static function admin_menu_options() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
    }

    public static function admin_help() {
        $screen = get_current_screen();
        $screen->add_help_tab( array(
            'id' => 1,            //unique id for the tab
            'title' => "Test1",      //unique visible title for the tab
            'content' => "Hello world 1",  //actual help text
            'callback' => array( 'SpinSlider', 'admin_menu_options' ) //optional function to callback
        ) );
        $screen->add_help_tab( array(
            'id' => 2,            //unique id for the tab
            'title' => "Test2",      //unique visible title for the tab
            'content' => "Hello world 2",  //actual help text
            'callback' => array( 'SpinSlider', 'admin_menu_options' ) //optional function to callback
        ) );
        // Help Sidebar
        $screen->set_help_sidebar(
            "Spin Interactive Slider"
        );
    }

    public static function admin_notices() {
        global $hook_suffix;
        if($hook_suffix == "settings_page_spin-interactive-slider") {
            if(isset($_GET["view"])) {
                switch($_GET["view"]) {
                    case "form":
                        SpinSlider::view("form");
                        break;
                    default:
                        SpinSlider::view("default");
                }
            }
            else {
                SpinSlider::view("default");
            }
        }
    }

    public static function admin_menu()
    {
        $hook = add_options_page('Spin Interactive Slider Options', 'Spin Interactive Slider', 'manage_options', 'spin-interactive-slider', array('SpinSlider', 'admin_menu_options'));
        if (version_compare($GLOBALS['wp_version'], '3.3', '>=')) {
            //add_action( "load-$hook", array( 'SpinSlider', 'admin_help' ) );
        }
    }

    public static function view( $name, array $args = array() ) {
        $args = apply_filters( 'spin-interactive-slider_view_arguments', $args, $name );
        foreach ( $args AS $key => $val ) {
            $$key = $val;
        }
        $file = plugin_dir_path(__FILE__) . 'views/'. $name . '.php';
        include( $file );
    }

}