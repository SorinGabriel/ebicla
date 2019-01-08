<?php
  /**
   * Htacces Generator
   *
   * Htaccess generator file for the theme.
   *
   * @category   Components
   * @package    WordPress
   * @subpackage Ebicla
   * @author     Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://ebicla.ro
   * @since      1.0.0
   */
?>
<?php /* Template Name: htacces generator */ ?>
<?php
/* .htaccess generator */

/* 
Sample:
array(
    'new' => 'sample/sample',
    'old' => 'index.php'
)
*/

$rules = array();

global $wp_rewrite;


$attributes = wc_get_attribute_taxonomies();

$feed_rules = array();

/* rewrite rules for all the attributes in their order */
$startingKeys = array(
    'cautare/(.*)/categorie-produs/(.*)' => array(
        'value' => 'index.php?s=$1&product_cat=$2',
        'index' => 3
    ),
    'cautare/(.*)' => array(
        'value' => 'index.php?product_type=product&s=$1',
        'index' => 2
    ),
    'categorie-produs/(.*)' => array(
        'value' => 'index.php?product_cat=$1',
        'index' => 2
    ),
    'produse' => array(
        'value' => 'index.php?post_type=product',
        'index' => 1
    )
);
global $ordonare_append;
for ($i = count($attributes) - 1; $i >= 0; $i--) {
    for ($j = 0; $j < count($attributes) - $i; $j++) {
        foreach ($startingKeys as $key => $array) {
            $value = $array['value'];
            for ($k = $j; $k <= $j + $i; $k++) {
                $key .= '/' . $attributes[$k]->attribute_name . '/(.*)';
                $value .= '&pa_' . $attributes[$k]->attribute_name . '=($' . ($k - $j + $array['index']). ')';
            }
            foreach ($ordonare_append as $oa_key => $oa_val) {
                $feed_rules[$key . '/pret-minim/(.*)/pret-maxim/(.*)' . $oa_key . '/pagina/(.*)'] = $value . '&min_price=$' . ($i + $array['index'] + 1) . '&max_price=$' . ($i + $array['index'] + 2) . $oa_val . '&paged=$' . ($i + $array['index'] + 3);
                $feed_rules[$key . '/pret-minim/(.*)' . $oa_key . '/pagina/(.*)'] = $value . '&min_price=$' . ($i + $array['index'] + 1) . $oa_val . '&paged=$' . ($i + $array['index'] + 2);
                $feed_rules[$key . '/pret-maxim/(.*)' . $oa_key . '/pagina/(.*)'] = $value . '&max_price=$' . ($i + $array['index'] + 1) . $oa_val . '&paged=$' . ($i + $array['index'] + 2);   
                
                $feed_rules[$key . '/pret-minim/(.*)/pret-maxim/(.*)' . $oa_key] = $value . '&min_price=$' . ($i + $array['index'] + 1) . '&max_price=$' . ($i + $array['index'] + 2) . $oa_val;
                $feed_rules[$key . '/pret-minim/(.*)' . $oa_key] = $value . '&min_price=$' . ($i + $array['index'] + 1) . $oa_val;
                $feed_rules[$key . '/pret-maxim/(.*)' . $oa_key] = $value . '&max_price=$' . ($i + $array['index'] + 1) . $oa_val;        
            }
        }
    }
}

foreach ($ordonare_append as $oa_key => $oa_val) {
    $feed_rules['cautare/(.*)/categorie-produs/(.*)/pret-minim/(.*)/pret-maxim/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?s=$1&product_cat=$2&min_price=$3&max_price=$4&paged=$5' . $oa_val;
    $feed_rules['cautare/(.*)/categorie-produs/(.*)/pret-minim/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?s=$1&product_cat=$2&min_price=$3&paged=$4' . $oa_val;
    $feed_rules['cautare/(.*)/categorie-produs/(.*)/pret-maxim/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?s=$1&product_cat=$2&max_price=$3&paged=$4' . $oa_val;
    $feed_rules['cautare/(.*)/pret-minim/(.*)/pret-maxim/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?post_type=product&s=$1&min_price=$2&max_price=$3&paged=$4' . $oa_val;
    $feed_rules['cautare/(.*)/pret-minim/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?post_type=product&s=$1&min_price=$2&paged=$3' . $oa_val;
    $feed_rules['cautare/(.*)/pret-maxim/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?post_type=product&s=$1&max_price=$2&paged=$3' . $oa_val;
    $feed_rules['categorie-produs/(.*)/pret-minim/(.*)/pret-maxim/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?product_cat=$1&min_price=$2&max_price=$3&paged=$4' . $oa_val;
    $feed_rules['categorie-produs/(.*)/pret-minim/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?product_cat=$1&min_price=$2&paged=$3' . $oa_val;
    $feed_rules['categorie-produs/(.*)/pret-maxim/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?product_cat=$1&max_price=$2&paged=$3' . $oa_val;
    $feed_rules['produse/pret-minim/(.*)/pret-maxim/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?post_type=product&min_price=$1&max_price=$2&paged=$3' . $oa_val;
    $feed_rules['produse/pret-minim/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?post_type=product&min_price=$1&paged=$2' . $oa_val;
    $feed_rules['produse/pret-maxim/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?post_type=product&max_price=$1&paged=$2' . $oa_val;
    $feed_rules['pret-minim/(.*)/pret-maxim/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?post_type=product&min_price=$1&max_price=$2&paged=$3' . $oa_val;
    $feed_rules['pret-minim/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?post_type=product&min_price=$1&paged=$2' . $oa_val;
    $feed_rules['pret-maxim/(.*)' . $oa_key . '/pagina/(.*)'] = 'index.php?post_type=product&max_price=$1&paged=$2' . $oa_val;

    $feed_rules['cautare/(.*)/categorie-produs/(.*)/pret-minim/(.*)/pret-maxim/(.*)' . $oa_key] = 'index.php?s=$1&product_cat=$2&min_price=$3&max_price=$4' . $oa_val;
    $feed_rules['cautare/(.*)/categorie-produs/(.*)/pret-minim/(.*)' . $oa_key] = 'index.php?s=$1&product_cat=$2&min_price=$3' . $oa_val;
    $feed_rules['cautare/(.*)/categorie-produs/(.*)/pret-maxim/(.*)' . $oa_key] = 'index.php?s=$1&product_cat=$2&max_price=$3' . $oa_val;
    $feed_rules['cautare/(.*)/pret-minim/(.*)/pret-maxim/(.*)' . $oa_key] = 'index.php?post_type=product&s=$1&min_price=$2&max_price=$3' . $oa_val;
    $feed_rules['cautare/(.*)/pret-minim/(.*)' . $oa_key] = 'index.php?post_type=product&s=$1&min_price=$2' . $oa_val;
    $feed_rules['cautare/(.*)/pret-maxim/(.*)' . $oa_key] = 'index.php?post_type=product&s=$1&max_price=$2' . $oa_val;
    $feed_rules['categorie-produs/(.*)/pret-minim/(.*)/pret-maxim/(.*)' . $oa_key] = 'index.php?product_cat=$1&min_price=$2&max_price=$3' . $oa_val;
    $feed_rules['categorie-produs/(.*)/pret-minim/(.*)' . $oa_key] = 'index.php?product_cat=$1&min_price=$2' . $oa_val;
    $feed_rules['categorie-produs/(.*)/pret-maxim/(.*)' . $oa_key] = 'index.php?product_cat=$1&max_price=$2' . $oa_val;
    $feed_rules['produse/pret-minim/(.*)/pret-maxim/(.*)' . $oa_key] = 'index.php?post_type=product&min_price=$1&max_price=$2' . $oa_val;
    $feed_rules['produse/pret-minim/(.*)' . $oa_key] = 'index.php?post_type=product&min_price=$1' . $oa_val;
    $feed_rules['produse/pret-maxim/(.*)' . $oa_key] = 'index.php?post_type=product&max_price=$1' . $oa_val;
    $feed_rules['pret-minim/(.*)/pret-maxim/(.*)' . $oa_key] = 'index.php?post_type=product&min_price=$1&max_price=$2' . $oa_val;
    $feed_rules['pret-minim/(.*)' . $oa_key] = 'index.php?post_type=product&min_price=$1' . $oa_val;
    $feed_rules['pret-maxim/(.*)' . $oa_key] = 'index.php?post_type=product&max_price=$1' . $oa_val;
}

foreach ($feed_rules as $key => $val) {
    echo 'RewriteRule ' . $key . ' ' . $val . ' [L]<br>';
}

?>