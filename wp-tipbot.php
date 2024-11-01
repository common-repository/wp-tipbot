<?php
/**
 * Plugin Name: XRP TIP BOT for WordPress
 * Plugin URI: https://wp-tipbot.com
 * Description: Displays a XRP TIP BOT button with a widget or shortcode.
 * Author: alordiel
 * Author URI: https://timelinedev.com
 * Version: 1.1.1
 * License: GPLv2 or later
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {

  exit;

}

require_once( plugin_dir_path( __FILE__ ) . 'classes/class.widget.php' );
require_once( plugin_dir_path( __FILE__ ) . 'functions/shortcode.php' );
require_once( plugin_dir_path( __FILE__ ) . 'functions/settings.php' );


add_action( 'plugins_loaded', 'wp_tipbot_text_domain' );
function wp_tipbot_text_domain() {

  load_plugin_textdomain( 'wptipbot', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );

}

add_action( 'widgets_init', 'register_xrptipbot_widget' );
function register_xrptipbot_widget() {

  register_widget( 'WP_TIPBOT_Widget' );

}


add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links' );
function add_action_links ( $links ) {
 $mylinks = array(
 '<a href="' . admin_url( 'options-general.php?page=wp-tipbot' ) . '">Settings</a>',
 );
return array_merge( $links, $mylinks );
}

