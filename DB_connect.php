<?php

/** 
 * Tenging við gagnagrunn
 */

header('Content-type=application/json; charset=utf-8');
class DB_connect {
 
    // constructor
    function __construct() {
            
    }
 
    // destructor
    function __destruct() {
        $this->close();
    }
 
    // tengjast server og gagnagrunni
    public function connect() {
        require_once 'config.php';
        $connect = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
        mysql_select_db(DB_DATABASE);
        return $connect;
    }

    // loka tengingu við gagnagrunn
    public function close() {
        mysql_close();
    }
 
}
?>