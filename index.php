<?php

/** 
 * API fyrir samskipti við gagnagrunn. Skilar upplýsingum um notanda sem JSONObject.
 * Að hluta til notast við eftirfarandi tutorial: 
 * http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/
 */

header('Content-type=application/json; charset=utf-8');

// athuga hvort einhver POST beiðni sé
if (isset($_POST['tag']) && $_POST['tag'] != '') {
    $tag = $_POST['tag'];

	require_once 'DB_functions.php';
        $db = new DB_functions();
 
    // response Array
    $response = array("tag" => $tag, "success" => 0, "error" => 0);
 
    // athuga hvort að tag sé login eða register
    if ($tag == 'login') {
        // beiðni um login með email og lykilorði
        $email = $_POST['email'];
        $password = $_POST['password'];
 
        // athuga hvort að notandi sé til
        $user = $db->getUserByEmailAndPassword($email, $password);
        if ($user != false) {
        	// notandi er til
        	// sækja upplýsingar um notanda í gagnagrunn
            $response["success"] = 1;
            $response["user"]["uid"] = $user["unique_id"];
            $response["user"]["name"] = $user["name"];
            $response["user"]["email"] = $user["email"];
            $response["user"]["phone"] = $user["phone"];
            $response["user"]["created_at"] = $user["created_at"];
            $response["user"]["updated_at"] = $user["updated_at"];
            echo json_encode($response);
        } else {
            // notandi fannst ekki
            $response["error"] = 1;
            $response["error_msg"] = "Rangt email eða lykilorð!";
            echo json_encode($response);
        }
    } else if ($tag == 'register') {
        // beiðni um nýskráningu með nafni, email, símanúmeri og lykilorði
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
 
        // athuga hvort notandi með þetta email sé nú þegar til í gagnagrunni
        if ($db->isUserExisted($email)) {
        	// notandi er til
        	// villuskilaboð
            $response["error"] = 2;
            $response["error_msg"] = "Notandi er nú þegar til";
            echo json_encode($response);
        } else {
            // notandi er ekki til
            // vista upplýsingar um notanda
            $user = $db->storeUser($name, $email, $phone, $password);
            // athuga hvort tekist hafi að vista notandaupplýsingar
            if ($user) {
                // tókst að vista notanda í gagnagrunni
                // sækja upplýsingar um notanda
                $response["success"] = 1;
                $response["user"]["uid"] = $user["unique_id"];
                $response["user"]["name"] = $user["name"];
                $response["user"]["email"] = $user["email"];
                $response["user"]["phone"] = $user["phone"];
                $response["user"]["created_at"] = $user["created_at"];
                $response["user"]["updated_at"] = $user["updated_at"];
                echo json_encode($response);
            } else {
                // tókst ekki að vista notanda í gagnagrunni
                // villuskilaboð
                $response["error"] = 1;
                $response["error_msg"] = "Villa kom upp við skráningu";
                echo json_encode($response);
            }
        }
    } else {
        echo "Ógild beiðni. Hvorki með tag login né register.";
    }
} else {
    echo "Engin POST beiðni til staðar.";
}
?>