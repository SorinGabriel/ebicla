<?php 
  /**
   * Q&A
   *
   * Q&A file for the theme.
   *
   * @category   Components
   * @package    WordPress
   * @subpackage Ebicla
   * @author     Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://ebicla.ro
   * @since      1.0.0
   */

/* Template Name: Q&A */

get_header();

$context = Timber::get_context();
$context['post'] = new TimberPost();
Timber::render('templates/q&a.twig', $context);

get_footer(); 

?>