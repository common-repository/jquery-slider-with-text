<?php

/**
 * @package spininteractive-slider
 * @version 1.0
 */

/**
 * Plugin Name: Spin Interactive Slider
 * Plugin URI: http://www.spin-interactive.com
 * Description: jQuery Image Slider with Text
 * Version: 1.0
 * Author: Spin Interactive <dev@spin-interactive.com>
 * Author URI: http://www.spin-interactive.com
 * License: GPL2
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

require_once( plugin_dir_path(__FILE__) . 'SpinSlider.php' );
add_action( 'init', array( 'SpinSlider', 'init' ) );

