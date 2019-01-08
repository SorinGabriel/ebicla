<?php
  /**
   * Top sidebar
   *
   * Sidebar-top file for the theme.
   *
   * @category   Components
   * @package    WordPress
   * @subpackage Ebicla
   * @author     Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://ebicla.ro
   * @since      1.0.0
   */

$context = Timber::get_context();

global $wp; 
$current_url = home_url($wp->request) . '/';

/* Search value */
$params = explode("/", $_SERVER['REQUEST_URI']);
$index_search_term = array_search('cautare', $params);
$context['search_value'] = ($index_search_term !== false ? 'value="' . $params[$index_search_term + 1] . '"' : '');

/* Cart */
$locations = get_nav_menu_locations();
$menu = get_term($locations['header_menu'], 'nav_menu');
$menu_items = wp_get_nav_menu_items($menu->term_id);
$context['menu'] = array();
$context['cart_count'] = WC()->cart->get_cart_contents_count();
$context['cart_price'] = WC()->cart->get_cart_total();
foreach ($menu_items as $item) {
    array_push(
        $context['menu'],
        array(
            'url' => $item->url,
            'title' => $item->title,
            'icon' => implode(" ", $item->classes),
            'li_class' => ($current_url == $item->url ? 'class="active"' : '')
        )
    );
}

/* User status */
$context['user_status'] = is_user_logged_in();
$context['logout_url'] = wp_logout_url(get_permalink(woocommerce_get_page_id('myaccount')));

/* Categories */
$context['categories_li_class'] = ($current_url == get_permalink(woocommerce_get_page_id('shop')) ? 'active' : '');
$context['all_products_url'] = get_permalink(woocommerce_get_page_id('shop'));
$context['categories'] = array();
$categories = get_terms('product_cat', array('hide_empty'=>false));
foreach ($categories as $item) {
    array_push(
        $context['categories'],
        array(
            'li_class' => ($current_url == get_term_link($item) ? 'active' : ''),
            'name' => $item->name,
            'url' => get_term_link($item)
        )
    );
}

Timber::render('templates/sidebar-top.twig', $context);

?>