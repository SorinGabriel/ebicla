<?php
  /**
   * Products
   *
   * Products file for the theme.
   *
   * @category   Components
   * @package    WordPress
   * @subpackage Ebicla
   * @author     Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://ebicla.ro
   * @since      1.0.0
   */

/* Template Name: Products */

get_header();

$context = Timber::get_context();

/* Breadcrumbs and filters */
$context['category'] = get_term_by('slug', get_query_var('product_cat'), 'product_cat')->name;
$context['search_term'] = get_query_var('s');
$sort = get_query_var('orderby');
$meta_query = get_query_var('meta_query');
$context['min_price'] = $meta_query['price_filter']['value'][0];
$context['max_price'] = $meta_query['price_filter']['value'][1];
$attributes = wc_get_attribute_taxonomies();
$context['attributes'] = array();
$context['filters'] = array();
foreach ($attributes as $attribute) {
    array_push(
        $context['filters'], array(
        'attribute_label' => $attribute->attribute_label,
        'queried_var' => get_query_var('pa_' . $attribute->attribute_name)
        )
    );

    $values = get_terms('pa_'.$attribute->attribute_name);
    $array_values = array();
    foreach ($values as $val) {

        /* Check or uncheck the button based on the url */
        $params = explode("/", $_SERVER['REQUEST_URI']);
        $index = array_search($attribute->attribute_name, $params);
        $checked = "";

        if ($index !== false) {
            $values = explode(",", $params[$index + 1]);
            $index2 = array_search($val->slug, $values);

            if ($index2 !== false) {
                $checked = "checked";
            }
        }

        array_push(
            $array_values, array(
                'attribute_name' => $attribute->attribute_name,
                'id' => $attribute->attribute_name . '_' . $val->slug,
                'value' => $attribute->attribute_name . '/' . $val->slug,
                'checked' => $checked,
                'val_slug' => $val->slug,
                'val_name' => $val->name 
            )
        );
    }
    array_push(
        $context['attributes'], array(
            'attribute_label' => $attribute->attribute_label,
            'values' => $array_values
        )
    );

}
$params = explode("/", $_SERVER['REQUEST_URI']);
$index_pret_min = array_search('pret-minim', $params);
$index_pret_max = array_search('pret-maxim', $params);
$context['lowest_price_value'] = ($index_pret_min !== false ? 'value="' . $params[$index_pret_min + 1] . '"' : '');
$context['highest_price_value'] = ($index_pret_max !== false ? 'value="' . $params[$index_pret_max + 1] . '"' : '');
$context['url_value'] = filter_links('pret-minim', '#pret_min#', 'singular', filter_links('pret-maxim', '#pret_max#', 'singular', 'REQUEST_URI', false), false);

/* Sort */
$context['sort'] = array(
    'popular' => (empty($sort) ? 'selected' : ''),
    'newest' => ($sort == 'date ID' ? 'selected' : ''),
    'ascending_price' => ($sort == 'price' ? 'selected' : ''),
    'descending_price' => ($sort == 'price-desc' ? 'selected' : ''),
    'reviews' => ($sort == 'rating' ? 'selected' : '')
);

/* Products */
$context['products'] = array();
while (have_posts()) {
    the_post();
    global $product;
    if (Get_Stock_info($product) > 0) {
        array_push(
            $context['products'], array(
                // 'price_class' => ($product->is_type('simple') ? 'simple' : 'variable'),
                'thumbnail' => get_the_post_thumbnail_url(),
                'permalink' => get_the_permalink(),
                'title' => get_the_title(),
                'price' => get_price_html2($product),
                'id' => get_the_ID(),
                'button_class' => ($product->is_type('simple') ? '' : 'not-directly')
            )
        );
    }
}


Timber::render('templates/products.twig', $context);

get_footer(); 

?>