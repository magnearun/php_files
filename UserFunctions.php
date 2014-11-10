<?php

/** 
 * Aðferðir til þess að ná í upplýsingar um notanda úr gagnagrunni
 * og setja inn upplýsingar um notanda
 * Að hluta til notast við eftirfarandi tutorial: 
 * http://www.androidhive.info/2012/05/how-to-connect-android-with-php-mysql/
 * Notast við password hashing aðferðir úr PasswordHash.php
 */

header('Content-type=application/json; charset=utf-8');
class UserFunctions {

    private $db;
 
    // constructor
    function __construct() {
      require_once 'PasswordHash.php';
      //require_once 'DatabaseConnect.php';
	
        // tengjast gagnagrunni
        //$this->db = new DatabaseConnect();
        //$this->db->connect() or die('Gat ekki tengst gagnagrunni ' . mysql_error());

	require_once 'config.php';
	mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) 
	or die('Gat ekki tengst gagnagrunni ' . mysql_error());
	mysql_select_db(DB_DATABASE);
	
	//$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

	//Check connection
	//if ($conn->connect_error) {
      //die("Database connection failed: " . $conn->connect_error);
      //	}

      //$db_host ="xh1887.sql.x.is";
      //$db_username ="xh1887";
      //$db_pass ="birkirflotti";
      //$db_name ="xh1887";


      // $conn = new mysqli($db_host, $db_username, $db_pass, $db_name);

      // Check connection
      // if ($conn->connect_error) {
      //die("Database connection failed: " . $conn->connect_error);
      //}
    }
 
    // destructor
    function __destruct() {         
    }
 
    /**
     * Geyma register upplýsingar um notanda í gagnagrunni.
     * Skilar öllum upplýsingum um notanda með ákveðið user id 
     * ef það tókst að vista upplýsingarnar í gagnagrunni.
     */
    public function storeUser($name, $email, $phone, $password) {
        $hasher = new PasswordHash(8, false);
        $hash = $hasher->HashPassword($password);
	 mysql_query('SET CHARACTER SET utf8');
	$result = mysql_query("INSERT INTO Notendur(name, email, phone, hash, created_at) VALUES('$name', '$email', '$phone', '$hash', NOW())");
        //$result = mysql_query("INSERT INTO Notendur(unique_id, name, email, phone, hash, created_at) VALUES('$uuid', '$name', '$email', '$phone', '$hash', NOW())");

        //echo json_encode($result);
        // athuga hvort að tekist hafi að setja inn upplýsingar um notanda í gagnagrunn
        if ($result) {
            // sækja upplýsingar um notanda með ákveðið id 
            $uid = mysql_insert_id(); // síðasta id sem sett var inn
	    mysql_query('SET CHARACTER SET utf8');
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
    public function getUserByLoginDetails($email, $password) {
	$hasher = new PasswordHash(8, false);
	 mysql_query('SET CHARACTER SET utf8');
        $result = mysql_query("SELECT * FROM Notendur WHERE email = '$email'") or die(mysql_error());
        // athuga hvort notandi með þetta email finnist í gagnagrunni 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            $stored_hash = $result['hash'];
            $check = $hasher->CheckPassword($password, $stored_hash);
            // athuga hvort lykilorð sé rétt
            if ($check) {
                // aðgangsupplýsingar notanda eru réttar
                return $result;
            }
        } else {
            // notandi með þetta email og lykilorð fannst ekki í gagnagrunni
            return false;
        }
    }
 
 
    /**
     * Athuga hvor notandi sé til í gagnagrunni. 
     * Skilar true er svo er.
     */
    public function isUserExisted($email) {
      mysql_query('SET CHARACTER SET utf8');
      $result = mysql_query("SELECT email from Notendur WHERE email = $email");
      if ($result == false) {
	return false;
      }
      else {
	return true;
      }
    }
      
    public function updateUser($oldEmail, $oldPassword, $name, $email, $phone, $password) {
      $db = new UserFunctions();
      $user = $db->getUserByLoginDetails($oldEmail, $oldPassword);
      $uid = $user['uid'];
      //echo $uid;
      $hasher = new PasswordHash(8, false);
      $hash = $hasher->HashPassword($password);
      mysql_query('SET CHARACTER SET utf8');
      $result = mysql_query("UPDATE Notendur SET name = '$name', email = '$email', phone = '$phone', hash = '$hash',updated_at = NOW() WHERE uid = $uid");
      // or die("Error updating: " . mysql_error());

      //  echo mysql_error();
      //  echo $oldEmail;
      //echo $oldPassword;
      //echo $name;
      //echo $email;
      //echo $phone;
      //echo $password;
      //echo $uid;


      //$result = mysql_query("SELECT * FROM Notendur WHERE uid = $uid");
       // or die("Error fetching: " . mysql_error());


	// athuga hvort að tekist hafi að uppfæra upplýsingar um notanda í gagnagrunni
       if ($result) {
	  mysql_query('SET CHARACTER SET utf8');
	  $result = mysql_query("SELECT * FROM Notendur WHERE uid = $uid");
	  // or die("Error fetching: " . mysql_error());
            // skila upplýsingum um notanda
            return mysql_fetch_array($result);
        } else {
            return false;
	    //echo mysql_error();
        }
    }
}
?>