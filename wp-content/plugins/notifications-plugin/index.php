<?php

  /**
   * Notifications Plugin
   *
   * Send browser notifications using this plugin
   *
   * @category   Components
   * @package    WordPress
   * @subpackage Notifications-Plugin
   * @author     Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://ebicla.ro
   * @since      1.0.0
   */

/*
Plugin Name: Notifications Plugin
Description: Send browser notifications using this plugin
Author: Marica Sorin
Version: 1.0
*/

/**
 * Adding the javascripts
 *
 * @return void
 */
function Notifications_Plugin_Register_js() 
{
    wp_register_script('notifications.js', plugin_dir_url(__FILE__) . '/js/notifications.js', 'notifications');
    wp_enqueue_script('notifications.js');
}
add_action('wp_enqueue_scripts', 'Notifications_Plugin_Register_js');