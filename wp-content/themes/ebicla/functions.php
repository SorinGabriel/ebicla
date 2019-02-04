<?php

  /**
   * Functions
   *
   * Functions file for the theme.
   *
   * @category   Components
   * @package    WordPress
   * @subpackage Ebicla
   * @author     Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://ebicla.ro
   * @since      1.0.0
   */
  
/* Removing bar bump */
/**
 * A list of tokenizers this sniff supports.
 *
 * @return void
 */
function My_Filter_head() 
{
    remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'my_filter_head');

/**
 * Adding the javascripts
 *
 * @return void
 */
function Wpt_Register_js() 
{

    wp_deregister_script('jquery');
    wp_register_script('jquery', "https://code.jquery.com/jquery-1.11.1.min.js", false, null);
    wp_enqueue_script('jquery');

    wp_register_script('touchswipe', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js', 'touchswipe');
    wp_enqueue_script('touchswipe');

    wp_register_script('bootstrap.min', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', 'bootstrap');
    wp_enqueue_script('bootstrap.min');

    wp_register_script('material.min', 'https://code.getmdl.io/1.2.1/material.min.js', 'material');
    wp_enqueue_script('material.min');

    // wp_register_script('state.js', get_template_directory_uri() . '/js/states.js', 'state');
    // wp_enqueue_script('state.js');

    wp_register_script('website.js', get_template_directory_uri() . '/js/website.js', 'website');
    wp_enqueue_script('website.js');

    wp_register_script('menu.js', get_template_directory_uri() . '/js/menu.js', 'menu');
    wp_enqueue_script('menu.js');

    wp_register_script('top-slider.js', get_template_directory_uri() . '/js/top-slider.js', 'top-slider');
    wp_enqueue_script('top-slider.js');

    // if (is_page_template('homepage.php')) {
        wp_register_script('homepage.js', get_template_directory_uri() . '/js/homepage.js', 'homepage');
        wp_enqueue_script('homepage.js');
    // }

    // if (is_archive()) {
        wp_register_script('products.js', get_template_directory_uri() . '/js/products.js', 'products');
        wp_enqueue_script('products.js');
    // }

    // if (is_product()) {
        wp_register_script('single-product.js', get_template_directory_uri() . '/js/single-product.js', 'single-product');
        wp_enqueue_script('single-product.js');
    // }

    // if (is_cart()) {
        wp_register_script('cart.js', get_template_directory_uri() . '/js/cart.js', 'cart');
        wp_enqueue_script('cart.js');
    // }

}
add_action('wp_enqueue_scripts', 'wpt_register_js');

/**
 * Custom Scripting to Move JavaScript from the Head to the Footer
 *
 * @return void
 */
function Remove_Head_scripts() 
{ 

    remove_action('wp_head', 'wp_print_scripts'); 
    remove_action('wp_head', 'wp_print_head_scripts', 9); 
    remove_action('wp_head', 'wp_enqueue_scripts', 1);
 
    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5); 

} 
add_action('wp_enqueue_scripts', 'remove_head_scripts');

/**
 * Adding the css
 *
 * @return void
 */
function Wpt_Register_css() 
{

    // wp_register_style( 'jquery-mobile.css', 'https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css' );
    // wp_enqueue_style( 'jquery-mobile.css' );

    wp_register_style('font-awesome.css', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css');
    wp_enqueue_style('font-awesome.css');

    wp_register_style('bootstrap.min', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap.min');

    wp_register_style('bootstrap-theme.min', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css');
    wp_enqueue_style('bootstrap-theme.min');

    wp_register_style('style.css', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('style.css');

    wp_register_style('bycicle-loader.css', get_template_directory_uri() . '/css/bycicle-loader.css');
    wp_enqueue_style('bycicle-loader.css');

    wp_register_style('top-menu.css', get_template_directory_uri() . '/css/top-menu.css');
    wp_enqueue_style('top-menu.css');

    wp_register_style('top-slider.css', get_template_directory_uri() . '/css/top-slider.css');
    wp_enqueue_style('top-slider.css');

    wp_register_style('footer.css', get_template_directory_uri() . '/css/footer.css');
    wp_enqueue_style('footer.css');

    // if (is_page_template('homepage.php')) {
        wp_register_style('homepage.css', get_template_directory_uri() . '/css/homepage.css');
        wp_enqueue_style('homepage.css');
    // }

    // if (is_archive()) {
        wp_register_style('products.css', get_template_directory_uri() . '/css/products.css');
        wp_enqueue_style('products.css');
    // }

    // if (is_product()) {
        wp_register_style('single-product.css', get_template_directory_uri() . '/css/single-product.css');
        wp_enqueue_style('single-product.css');
    // }

    // if (is_account_page()) {
        wp_register_style('myaccount.css', get_template_directory_uri() . '/css/myaccount.css');
        wp_enqueue_style('myaccount.css');
    // }
    
    // if (is_cart()) {
        wp_register_style('cart.css', get_template_directory_uri() . '/css/cart.css');
        wp_enqueue_style('cart.css');
    // }

    // if (is_checkout()) {
        wp_register_style('checkout.css', get_template_directory_uri() . '/css/checkout.css');
        wp_enqueue_style('checkout.css');
    // }

    // if (is_page_template('terms.php')) {
        wp_register_style('terms.css', get_template_directory_uri() . '/css/terms.css');
        wp_enqueue_style('terms.css');
    // }

    // if (is_page_template('contact.php')) {
        wp_register_style('contact.css', get_template_directory_uri() . '/css/contact.css');
        wp_enqueue_style('contact.css');
    // }

    // if (is_page_template('q&a.php')) {
        wp_register_style('q&a.css', get_template_directory_uri() . '/css/q&a.css');
        wp_enqueue_style('q&a.css');
    // }

}
add_action('wp_enqueue_scripts', 'wpt_register_css');

/**
 * Adding the menus
 *
 * @return void
 */
function Register_My_menus() 
{
    
    if (function_exists('register_nav_menu')) {

        register_nav_menu('header_menu', 'Header Menu');

        register_nav_menu('footer_menu', 'Footer Menu');

    
    }

}
add_action('init', 'register_my_menus');

/**
 * Woocommerce support
 *
 * @return void
 */
function Woocommerce_support() 
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'woocommerce_support');

?>