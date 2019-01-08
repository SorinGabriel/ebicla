<?php
  /**
   * Footer
   *
   * Footer file for the theme.
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

/* Notifications fixed */
$context['add_to_cart_page'] = false;
if (isset($_GET['add-to-cart'])) {
    $context['add_to_cart_page'] = true;
}

/* Contact details */
$context['phone_number'] = get_field('phone_number', get_option('page_on_front'));
$context['email'] = get_field('email', get_option('page_on_front'));

/* Footer menu */
$locations = get_nav_menu_locations();
$menu = get_term($locations['footer_menu'], 'nav_menu');
$context['menu_items'] = wp_get_nav_menu_items($menu->term_id);

/* Social networks */
$context['facebook_url'] = get_field('facebook_url', get_option('page_on_front'));
$context['twitter_url'] = get_field('twitter_url', get_option('page_on_front'));
$context['instagram_url'] = get_field('instagram_url', get_option('page_on_front'));;

Timber::render('templates/footer.twig', $context);

?>