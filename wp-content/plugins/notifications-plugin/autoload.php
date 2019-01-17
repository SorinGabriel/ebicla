<?php 
  /**
   * Autoloader
   *
   * Autoloads the classes
   *
   * @category   Components
   * @package    WordPress
   * @subpackage NotificationsAPI
   * @author     Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://ebicla.ro
   * @since      1.0.0
   */

    require_once '../../../wp-config.php';

    spl_autoload_register(
        function ($class_name) {
            include 'classes/' . $class_name . '.php';
        }
    );
