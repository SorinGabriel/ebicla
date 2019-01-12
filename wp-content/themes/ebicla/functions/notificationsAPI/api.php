<?php

  /**
   * Main file for the API
   *
   * @category   Components
   * @package    WordPress
   * @subpackage NotificationsAPI
   * @author     Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://ebicla.ro
   * @since      1.0.0
   */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'autoload.php';

$router = new Router();
echo $router->load($_GET['path'], $_GET['params']);