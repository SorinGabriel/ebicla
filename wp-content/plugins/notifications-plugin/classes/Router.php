<?php

  /**
   * [name]
   *
   * [name] file for the theme.
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
 * Router Class
 *
 * Creates the paths for the API
 *
 * @category   Components
 * @package    WordPress
 * @subpackage Ebicla
 * @author     Marica Sorin-Gabriel <sorinmarica4@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://ebicla.ro
 * @since      1.0.0
 */
class Router
{
    private $_paths;
    private $_errors;
    private $_class;
    private $_method;

    /**
     * Initializez the paths
     *
     * @return type
     */
    public function __construct()
    {
        $this->_paths = [
            'RegisterSubscription' => 'Subscriptions/create'
        ];
        $this->_errors = [
            '404' => [
                'status' => false,
                'message' => 'The path specified does not exist'
            ],
            'no_class' => [
                'status' => false,
                'message' => 'The class does not exist'
            ],
            'no_method' => [
                'status' => false,
                'message' => 'The method does not exist'
            ]
        ];
    }

    /**
     * Validates if a path is initiable
     *
     * @param String $path The path we are checking
     *
     * @return array
     */
    private function _validate($path)
    {
        if (!isset($this->_paths[$path])) {
            return $this->_errors['404'];
        }
        $this->_class = explode("/", $this->_paths[$path])[0];
        $this->_method = explode("/", $this->_paths[$path])[1];
        if (!class_exists($this->_class)) {
            return $this->_errors['no_class'];
        }
        $object = new $this->_class();
        if (!method_exists($object, $this->_method)) {
            return $this->_errors['no_method'];
        }
        return ['status' => true];
    }

    /**
     * Load class
     *
     * @param String $path   The path we are trying to load
     * @param Array  $params The params for the method
     *
     * @return json
     */
    public function load($path, $params) 
    {
        $validation = $this->_validate($path);
        if (!$validation['status']) {
            return json_encode($validation);
        } else {
            $object = new $this->_class();
            $method = $this->_method;
            $params = str_replace("\\", "", $params);
            return json_encode($object->$method(json_decode($params)));
        }
    }
}