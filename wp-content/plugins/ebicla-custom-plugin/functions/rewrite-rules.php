<?php

  /**
   * Rewriting rules 
   *
   * Rewriting rules for the website and htaccess
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
 * Categories filters
 *
 * @param array $array The array where the replacement is made
 * @param int   $key1  The key to be replaced
 * @param int   $key2  The replacement key
 * 
 * @return array
 */
function Replace_Key_function($array, $key1, $key2)
{
    $keys = array_keys($array);
    $index = array_search($key1, $keys);

    if ($index !== false) {
        $keys[$index] = $key2;
        $array = array_combine($keys, $array);
    }

    return $array;
}

/**
 * Categories URLs
 *
 * @param object $wp_rewrite The global wp_rewrite variable from wordpress
 *
 * @return void
 */
function Url_rewrite( $wp_rewrite ) 
{

    $attributes = wc_get_attribute_taxonomies();

    $feed_rules = array();

    /* rewrite rules for all the attributes in their order */
    $startingKeys = array(
        'cautare/(.*)/categorie-produs/(.*)' => array(
            'value' => 'index.php?s=' . $wp_rewrite->preg_index(1) . '&product_cat=' . $wp_rewrite->preg_index(2),
            'index' => 3
        ),
        'cautare/(.*)' => array(
            'value' => 'index.php?product_type=product&s=' . $wp_rewrite->preg_index(1),
            'index' => 2
        ),
        'categorie-produs/(.*)' => array(
            'value' => 'index.php?product_cat=' . $wp_rewrite->preg_index(1),
            'index' => 2
        ),
        'produse' => array(
            'value' => 'index.php?post_type=product',
            'index' => 1
        )
    );

    global $ordonare_append;
    $ordonare_append = array(
        '/ordonare/popularitate' => '&orderby=popularity',
        '/ordonare/recenzii' => '&orderby=rating',
        '/ordonare/noi' => '&orderby=date',
        '/ordonare/pret-descrescator' => '&orderby=price-desc',
        '/ordonare/pret' => '&orderby=price',
        '' => '' //fake record in order to minify the code
    );

    for ($i = count($attributes) - 1; $i >= 0; $i--) {
        for ($j = 0; $j < count($attributes) - $i; $j++) {
            foreach ($startingKeys as $key => $array) {
                $value = $array['value'];
                for ($k = $j; $k <= $j + $i; $k++) {
                    $key .= '/' . $attributes[$k]->attribute_name . '/(.*)';
                    $value .= '&pa_' . $attributes[$k]->attribute_name . '=(' . $wp_rewrite->preg_index($k - $j + $array['index']). ')';
                }

                foreach ($ordonare_append as $oa_key => $oa_val) {
                    $feed_rules[$key . $oa_key . '/pagina/(.*)'] = $value . $oa_val . '&paged=' . $wp_rewrite->preg_index($i + $array['index'] + 1);
                    $feed_rules[$key . $oa_key] = $value . $oa_val;
                }
            }
        }
    }

    foreach ($ordonare_append as $oa_key => $oa_val) {
        $feed_rules['cautare/(.*)/categorie-produs/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?s=' . $wp_rewrite->preg_index(1) . '&product_cat=' . $wp_rewrite->preg_index(2) . $oa_val . '&paged=' . $wp_rewrite->preg_index(3);
        $feed_rules['cautare/(.*)/categorie-produs/(.*)' . $oa_key] = 'index.php?s=' . $wp_rewrite->preg_index(1) . '&product_cat=' . $wp_rewrite->preg_index(2) . $oa_val;
    }
    foreach ($ordonare_append as $oa_key => $oa_val) {
        $feed_rules['cautare/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?post_type=product&s=' . $wp_rewrite->preg_index(1) . $oa_val . '&paged=' . $wp_rewrite->preg_index(2);
        $feed_rules['cautare/(.*)' . $oa_key] = 'index.php?post_type=product&s=' . $wp_rewrite->preg_index(1) . $oa_val;
    }
    foreach ($ordonare_append as $oa_key => $oa_val) {
        $feed_rules['categorie-produs/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?product_cat=' . $wp_rewrite->preg_index(1) . $oa_val . '&paged=' . $wp_rewrite->preg_index(2);
        $feed_rules['categorie-produs/(.*)' . $oa_key] = 'index.php?product_cat=' . $wp_rewrite->preg_index(1) . $oa_val;
    }
    foreach ($ordonare_append as $oa_key => $oa_val) {
        $feed_rules['produse' . $oa_key . '/pagina/(.*)'] = 'index.php?post_type=product' . $oa_val . '&paged=' . $wp_rewrite->preg_index(1);
        $feed_rules['produse' . $oa_key] = 'index.php?post_type=product' . $oa_val;
    }

    $wp_rewrite->rules = $feed_rules + $wp_rewrite->rules;

    // echo '<div style="margin-left: 25%">';

    // foreach($wp_rewrite->rules as $key => $val) {
    //     echo $key . ' => ' . $val . '<br>';
    // }

    // echo '</div>';
}
add_filter('generate_rewrite_rules', 'url_rewrite');

/**
 * Pagination url name changing
 *
 * @return void
 */
function Re_Rewrite_rules() 
{
    global $wp_rewrite;
    $wp_rewrite->pagination_base = 'pagina';
    $wp_rewrite->flush_rules();
}
add_action('init', 're_rewrite_rules');

/**
 * Filter function
 *
 * @param string $attribute   The attribute for which we get the filter links
 * @param string $value       The value
 * @param string $type        Types may be singular or multiple
 * @param string $current_url The url of the page from which you use the function
 * @param bool   $output      If you want to output the result or not
 *
 * @return string
 */
function Filter_links($attribute, $value, $type = 'singular', $current_url = 'REQUEST_URI', $output = true) 
{
    /* This function is suppose to create the urls for the filters */
    if ($current_url == 'REQUEST_URI') {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    } else {
        $url = $current_url;
    }
    $params = explode("/", $url);

    if ($attribute != 'pagina' && (($index = array_search('pagina', $params)) !== false)) {
        array_splice($params, $index, 2);
    }
    
    $order = array('cautare', 'categorie-produs', 'culoare', 'marime', 'pret-minim', 'pret-maxim', 'ordonare', 'pagina');

    switch ($type) {
    case 'singular' :
        if (($attribute_index = array_search($attribute, $params)) !== false) {
            if ($params[$attribute_index + 1] == $value || empty($value)) {
                array_splice($params, $attribute_index, 2);
            } else {
                $params[$attribute_index + 1] = $value;
            }
        } else {
            $order_index = array_search($attribute, $order);
            $insert_index = count($params) - 1;
            for ($i = $order_index + 1; $i < count($order) && $insert_index == count($params) - 1; $i++) {
                if (($aux_insert_index = array_search($order[$i], $params)) !== false) {
                    $insert_index = $aux_insert_index;
                }
            }
            $params = array_merge(
                array_slice($params, 0, $insert_index),
                array($attribute, $value),
                array_slice($params, $insert_index, count($params) - 1)
            );
        }
        break;
    case 'multiple' :
        if (($attribute_index = array_search($attribute, $params)) !== false) {
            $values = explode(",", $params[$attribute_index + 1]);
            if (($index = array_search($value, $values)) !== false) {
                unset($values[$index]);
            } else {
                array_push($values, $value);
            }
            $values = implode(",", $values);
            if (empty($values)) {
                array_splice($params, $attribute_index, 2);
            } else {
                $params[$attribute_index + 1] = $values;
            }
        } else {
            $order_index = array_search($attribute, $order);
            $insert_index = count($params) - 1;
            for ($i = $order_index + 1; $i < count($order) && $insert_index == count($params) - 1; $i++) {
                if (($aux_insert_index = array_search($order[$i], $params)) !== false) {
                    $insert_index = $aux_insert_index;
                }
            }
            $params = array_merge(
                array_slice($params, 0, $insert_index),
                array($attribute, $value),
                array_slice($params, $insert_index, count($params) - 1)
            );
        }
        break;
    default :
        break;
    }

    if ($output) {
        echo implode("/", $params);
    } else {
        return implode("/", $params);
    }
}
