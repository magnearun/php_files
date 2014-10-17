<?php

/** 
 * Aðferðir til þess að ná í upplýsingar um notanda úr gagnagrunni
 * og setja inn upplýsingar um notanda
 *
 * ATH! Skjal til bráðabirgða. Á eftir að refactora!
 */

header('Content-type=application/json; charset=utf-8');
class DB_functions {
 
    private $db;
 

    // constructor
    function __construct() {
	require_once 'DB_connect.php';
	
        // tengjast gagnagrunni
        $this->db = new DB_connect();
        $this->db->connect();
    }
 
    // destructor
    function __destruct() {         
    }
 
    /**
     * Geyma register upplýsingar um notanda í gagnagrunni.
     * Skilar öllum upplýsingum um notanda með ákveðið user id 
     * ef það tókst að vista upplýsingarnar í gagnagrunni.
     */
    public function storeUser($name, $phone, $email, $password) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
        $result = mysql_query("INSERT INTO Notendur(unique_id, name, email, phone, encrypted_password, salt, created_at) VALUES('$uuid', '$name', '$phone', '$email', '$encrypted_password', '$salt', NOW())");
        // athuga hvort að tekist hafi að setja inn upplýsingar um notanda í gagnagrunn
        if ($result) {
            // sækja upplýsingar um notanda með ákveðið id  
            $uid = mysql_insert_id(); 
            $result = mysql_query("SELECT * FROM Notendur WHERE uid = $uid");
            // skila upplýsingum um notanda
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }

    /**
     * Sækja upplýsingar um notanda úr gagnagrunni með email og lykilorði
     */
    public function getUserByEmailAndPassword($email, $password) {
        $result = mysql_query("SELECT * FROM Notendur WHERE email = '$email'") or die(mysql_error());
		// athuga hvort notandi með þetta email finnist í gagnagrunni 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            $salt = $result['salt'];
            $encrypted_password = $result['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // athuga hvort lykilorð sé rétt
            if ($encrypted_password == $hash) {
                return $result;
            }
        } else {
            // notandi fannst ekki
            return false;
        }
    }
 
    /**
     * Athuga hvor notandi sé til í gagnagrunni. 
     * Skilar true er svo er.
     */
     
	public function isUserExisted($email) {
        $result = mysql_query("SELECT email from Notendur WHERE email = $email");
        if ($result == false) {
            return false;
        }
        else {
            return true;
        }
    }
 
 
    /**
     * Dulkóða lykilorð
     * Skilar salt og dulkóðuðu lykilorði
     */
    public function hashSSHA($password) {
 
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
 
    /**
     * Afkóða lykilorð
     */
    public function checkhashSSHA($salt, $password) {
 
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
 
        return $hash;
    }
 
}
?>
