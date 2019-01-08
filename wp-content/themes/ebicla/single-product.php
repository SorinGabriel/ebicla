<?php
  /**
   * Single product
   *
   * Single-product file for the theme.
   *
   * @category   Components
   * @package    WordPress
   * @subpackage Ebicla
   * @author     Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://ebicla.ro
   * @since      1.0.0
   */

/* Template Name: Single-Product */
get_header();

$context = Timber::get_context();

global $product; 
if (!is_object($product)) $product = wc_get_product(get_the_ID());

/* Breadcrumbs */
$category = get_term_by('slug', get_query_var('product_cat'), 'product_cat');
$context['category_name'] = $category->name;
echo $context['category_name'];

/* Image gallery */
$attachment_ids = $product->get_gallery_image_ids(); 
$context['attachment_ids'] = array();
foreach ($attachment_ids as $item) {
    $image_attributes = wp_get_attachment_image_src($item, 'full');
    array_push(
        $context['attachment_ids'],
        array(
            'src' => $image_attributes[0],
            'alt' => $image_attributes[1]
        )
    );
}

/* Product details */
$context['available_variations'] = array();
$context['product_variable'] = $product->is_type('variable');
$context['product_title'] = $product->get_title();
if ($product->is_type('variable')) {
    $context['available_variations'] = $product->get_available_variations();
    $attributes_variations = $product->get_variation_attributes();
    $default_attributes = $product->get_default_attributes();
    $default_variation = get_variation($default_attributes, $context['available_variations']);
    $context['price'] = get_price_html_new($default_variation['display_price'], $default_variation['display_regular_price']);
} else {
    $context['price'] = get_price_html_new();
}
$context['stock_quantity_total'] = $product->get_stock_quantity();
if ($product->is_type('variable')) {
    $context['stock_quantity'] = $default_variation['max_qty'];
    $context['stock_quantity_total'] = array_sum(array_column($context['available_variations'], 'max_qty'));
} else {
    $context['stock_quantity'] = $context['stock_quantity_total'];
}
$context['no_stock_class'] = ($stock_quantity > 20 ? 'info' : ($stock_quantity > 10 ? 'warning' : 'danger'));
$context['attribute_variations'] = array();
foreach ($attributes_variations as $key => $variation) {
    $array_variation = array();
    foreach ($variation as $value) {
        array_push(
            $array_variation,
            array(
                'value' => $value,
                'selected' => ($value == $default_attributes[$key] ? 'selected' : '')
            )
        );
    }
    array_push(
        $context['attribute_variations'],
        array(
            'attribute_label' => get_taxonomy($key)->labels->singular_name,
            'select_name' => $key,
            'variation' => $array_variation
        )
    );
}
$shipping_class = get_term($product->get_shipping_class_id(), 'product_shipping_class');
$context['show_shipping_class'] = !(empty($shipping_class->name) && empty($shipping_class->description));
$context['shipping_class'] = array(
    'name' => $shipping_class->name,
    'description' => $shipping_class->description
);

/* Product specs */
$info_content = get_post()->post_content; 
if (empty($info_content)) {
    $context['info'] = 'Nu există alte informații despre acest produs';
} else {
    $context['info'] = $info_content;
}
if ($product->has_attributes()) {
    ob_start();
    $product->list_attributes();
    $output = ob_get_contents();
    ob_end_clean();
    $context['attributes'] = $output; 
} else {
    $context['attributes'] = 'Nu există specificații pentru acest produs';
}
$comments = get_comments(
    array(
    'post_type' => 'product',
    'post_id' => get_the_id()
    )
);
if (empty($comments)) {
    $context['reviews'] = 'Nu există recenzii pentru acest produs';
} else {
    ob_start();
    wp_list_comments(array('callback' => 'woocommerce_comments'), $comments);
    $output = ob_get_contents();
    ob_end_clean();
    $context['reviews'] = $output;
}

/* Similar products */
$similar_products = wc_get_related_products(get_the_ID(), 4);
$context['similar_products'] = array();
foreach ($similar_products as $item) {
    $prod = wc_get_product($item); 
    array_push(
        $context['similar_products'],
        array(
            'url' => get_permalink($item),
            'title' => get_the_title($item),
            'thumbnail' => get_the_post_thumbnail_url($item),
            'price' => get_price_html2($prod),
            // 'price_class' => ($prod->is_type('simple') ? 'simple' : 'variable')
        )
    );
}

Timber::render('templates/single-product.twig', $context);

get_footer(); 
?>