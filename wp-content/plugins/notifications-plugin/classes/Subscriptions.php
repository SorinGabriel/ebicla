<?php

  /**
   * Subscription File Class
   *
   * @category   Components
   * @package    WordPress
   * @subpackage NotificationsAPI
   * @author     Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://ebicla.ro
   * @since      1.0.0
   */

/**
 * Class Subscription
 *
 * Manages the notifications subscriptions
 *
 * @category   Components
 * @package    WordPress
 * @subpackage Ebicla
 * @author     Marica Sorin-Gabriel <sorinmarica4@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://ebicla.ro
 * @since      1.0.0
 */
class Subscriptions
{
    private $_publicKey;
    private $_conn;

    /**
     * Initialize the publicKey
     *
     * @return void
     */
    public function __construct() 
    {
        global $wpdb;
        var_dump($wpdb);
        $this->_conn = new PDO("mysql:host=" . $wpdb->dbhost . ";dbname=" . $wpdb->dbname, $wpdb->dbuser, $wpdb->dbpassword);
        $this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->_publicKey = "BHNxH4G6agx-XsPBP-90jxHj9cXbn6vUVqWiDhGPpiJXy8el69RfWOzp5fs_ZJiU6jl8QTxoNdASPOOYXhuKbUw";
    }

    /**
     * Register a subscription
     *
     * @param json $json The json subscription
     *
     * @return Array
     */
    public function create($json) 
    {
        try {
            $stmt = $this->_conn->prepare(
                "INSERT INTO notificationsAPI (ip, json) 
                VALUES (:ip, :json)"
            );
            $stmt->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
            $stmt->bindParam(':json', json_encode($json));
            $stmt->execute();
            return [
                'status' => true,
                'message' => 'Subscription registered'
            ];
        } catch(PDOException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}