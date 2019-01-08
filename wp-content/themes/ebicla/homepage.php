<?php
  /**
   * Homepage
   *
   * Homepage file for the theme.
   *
   * @category   Components
   * @package    WordPress
   * @subpackage Ebicla
   * @author     Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://ebicla.ro
   * @since      1.0.0
   */

/* Template Name: Homepage Template */

get_header();

$context = Timber::get_context();
        
/* Get carousel data */
$context['carousel'] = array(
    array(
        'image_url' => get_field('carousel_1_img')['url'],
        'title' => get_field('carousel_1_title'),
        'description' => get_field('carousel_1_description'),
        'url' => get_field('carousel_1_url')
    ),
    array(
        'image_url' => get_field('carousel_2_img')['url'],
        'title' => get_field('carousel_2_title'),
        'description' => get_field('carousel_2_description'),
        'url' => get_field('carousel_2_url')
    ),
    array(
        'image_url' => get_field('carousel_3_img')['url'],
        'title' => get_field('carousel_3_title'),
        'description' => get_field('carousel_3_description'),
        'url' => get_field('carousel_3_url')
    )
    );

/* Get the last added products */
$args = array(
    'post_type' => 'product',
    'posts_per_page' => '8',
    'orderby' =>'date',
    'order' => 'DESC',
    'meta_query' => array(
        array(
            'key' => '_stock_status',
            'value' => 'instock',
            'compare' => '=',
        )
    )
);
$products = new WP_Query($args);
$context['last_added_products'] = false;
if ($products->have_posts()) {
    $context['last_added_products'] = array();
    while ($products->have_posts()) {
        $products->the_post();
        global $product;
        if (Get_Stock_info($product) > 0) {
            $arrayProduct = array(
                // 'price_class' => ($product->is_type('simple') ? 'simple' : 'variable'),
                'thumbnail' => get_the_post_thumbnail_url($products->post->ID),
                'title' => get_the_title(),
                'description' => get_the_excerpt(2),
                'price' => get_price_html2($product),
                'id' => get_the_ID(),
                'button_class' => ($product->is_type('simple') ? '' : 'not-directly'),
                'permalink' => get_the_permalink()
            );
            array_push($context['last_added_products'], $arrayProduct);
        }
    }
}

/* Get the categories */
$categories = get_terms('product_cat', array('hide_empty'=>false));
$context['categories'] = false;
if (count($categories) > 0) {
    $context['categories'] = array();
    foreach ($categories as $key => $category) {
        $arrayCategory = array(
            'thumbnail' => wp_get_attachment_url(
                get_woocommerce_term_meta(
                    $category->term_id, 
                    'thumbnail_id', 
                    true
                )
            ),
            'link' => get_term_link($category),
            'title' => $category->name,
            'description' => $category->description
        );
        array_push($context['categories'], $arrayCategory);
    }
}

Timber::render('templates/homepage.twig', $context);

get_footer(); 

?>