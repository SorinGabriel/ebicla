<?php
  /**
   * 404
   *
   * 404 file for the theme.
   *
   * @category   Components
   * @package    WordPress
   * @subpackage Ebicla
   * @author     Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://ebicla.ro
   * @since      1.0.0
   */

get_header();

$context = Timber::get_context();
Timber::render('templates/404.twig', $context);

get_footer(); 

?>