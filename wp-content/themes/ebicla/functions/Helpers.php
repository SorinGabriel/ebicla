<?php
  /**
   * Helper Functions
   *
   * Helper functions needed in functions.php
   *
   * @category   Components
   * @package    WordPress
   * @subpackage Ebicla
   * @author     Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://ebicla.ro
   * @since      1.0.0
   */

/**
 * Gets the post thumbnail alt attribute
 *
 * @param int $post_id It's the id of a post from wordpress
 *
 * @return string
 */
function Get_The_Post_Thumbnail_alt($post_id) 
{
    return get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true);
}

/**
 * Get the variation from a list of attributes and variations
 *
 * @param array $attributes The list of attributes
 * @param array $variations The list of variations
 *
 * @return string
 */
function Get_variation($attributes, $variations) 
{
    $attributes_aux = array();
    foreach ($attributes as $key => $val) {
        $attributes_aux['attribute_' . $key] = $val;
    }
    foreach ($variations as $key => $variation) {
        if (empty(array_diff($variation['attributes'], $attributes)) 
            && empty(array_diff($attributes, $variation['attributes']))
        ) {
            return $variations[$key];
        }
    }
    return false;
}

/**
 * Get the price HTML in a new format
 *
 * @param string $sale_price    Preset the sale price
 * @param string $regular_price Preset the regular price
 *
 * @return string
 */
function Get_Price_Html_new($sale_price = null, $regular_price = null) 
{
    global $product;
    if (!$sale_price) {
        $sale_price = $product->get_sale_price();
    }
    if (!$regular_price) {
        $regular_price = $product->get_regular_price();
    }
    $sale_price = number_format($sale_price, 2, ',', ',');
    $regular_price = number_format($regular_price, 2, ',', ',');
    return '<div class="price-new">
                <span class="sale-price">' . $sale_price . '</span>
                <span class="sale-price-currency">' . get_woocommerce_currency_symbol() . '</span>
                <span class="regular-price">' . $regular_price . '</span>
                <span class="regular-price-currency">' . get_woocommerce_currency_symbol() . '</span></div>';
}

/**
 * Get the price HTML in another format
 *
 * @param object $product       The product
 * @param string $sale_price    Preset the sale price
 * @param string $regular_price Preset the regular price
 *
 * @return string
 */
function Get_Price_html2($product = null, $sale_price = null, $regular_price = null) 
{
    if (!$sale_price) {
        $sale_price = $product->get_sale_price();
    }
    if (!$regular_price) {
        $regular_price = $product->get_regular_price();
    }

    if ($product->is_type('variable')) {
        $default_variation = get_variation($product->get_default_attributes(), $product->get_available_variations());
        $sale_price = $default_variation['display_price'];
        $regular_price = $default_variation['display_regular_price'];
    }

    $sale_price = number_format($sale_price, 2, ',', ',');
    $regular_price = number_format($regular_price, 2, ',', ',');

    return '<del>
        <span class="woocommerce-Price-amount amount">' . $regular_price . '&nbsp;
        <span class="woocommerce-Price-currencySymbol">lei</span></span>
        </del><ins>
        <span class="woocommerce-Price-amount amount">' . $sale_price . '&nbsp;
        <span class="woocommerce-Price-currencySymbol">lei</span></span>
        </ins>';
}

/**
 * Get info about the stock of a product regardless it's type
 *
 * @param object $product The product for which we need to get the info
 *
 * @return integer
 */
function Get_Stock_info($product)
{
    if ($product->is_type('variable')) {
        $result = array_sum(array_column($product->get_available_variations(), 'max_qty'));
    } else {
        $result = $product->get_stock_quantity();
    }
    return $result;
}

?>