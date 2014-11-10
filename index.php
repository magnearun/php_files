<?php

/** 
 * API fyrir samskipti við gagnagrunn. Skilar upplýsingum um notanda sem JSONObject.
 * Að hluta til notast við eftirfarandi tutorial: 
 * http://www.androidhive.info/2012/05/how-to-connect-android-with-php-mysql/
 */

header('Content-type=application/json; charset=utf-8');

// athuga hvort einhver POST beiðni sé til staðar
if (isset($_POST['tag']) && $_POST['tag'] != '') {
  $tag = $_POST['tag'];

  require_once 'UserFunctions.php';
  $db = new UserFunctions();
 
  // response Array
  $response = array("tag" => $tag, "success" => 0, "error" => 0);
 
  // athuga hvort að tag sé login eða register eða update
  if ($tag == 'login') {
    // beiðni um login með email og lykilorði
    $email = $_POST['email'];
    $password = $_POST['password'];
 
    // athuga hvort að notandi sé til
    $user = $db->getUserByLoginDetails($email, $password);
    if ($user != false) {
      // notandi er til
      // sækja upplýsingar um notanda í gagnagrunn
      $response["success"] = 1;
      $response["user"]["uid"] = $user["uid"];
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
	$response["user"]["uid"] = $user["uid"];
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
  } else if ($tag == 'update') {
    // beiðni um að uppfæra notanda með gömlu emaili og lykilorði
    // og nýju nafni, email, símanúmeri og lykilorði
    $oldEmail = $_POST['oldEmail'];
    $oldPassword = $_POST['oldPassword'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password']; 
    // athuga hvort að notandi sé til
    //$user = $db->//getUserByLoginDetails($oldEmail, $oldPassword);
    $user = $db->updateUser($oldEmail, $oldPassword, $name, $email, $phone, $password);

    if ($user != false) {
      // notandi er til
      // uppfæra upplýsingar um notanda
      //sækja gömlu upplýsingarnar um notandann
      //$response["success"] = 1;
      //$response["user"]["uid"] = $user["uid"];
      //$response["user"]["name"] = $user["name"];
      //$response["user"]["email"] = $user["email"];
      //$response["user"]["phone"] = $user["phone"];
      //$response["user"]["created_at"] = $user["created_at"];
      //$response["user"]["updated_at"] = $user["updated_at"];
      //echo json_encode($response);
      
      //sækja nýju upplýsingarnar um notandann
      $response["success"] = 1;
      $response["user"]["uid"] = $user["uid"];
      $response["user"]["name"] = $user["name"];
      $response["user"]["email"] = $user["email"];
      $response["user"]["phone"] = $user["phone"];
      $response["user"]["created_at"] = $user["created_at"];
      $response["user"]["updated_at"] = $user["updated_at"];
      echo json_encode($response);	  
    } else {
      // tókst ekki að sækja og uppfæra notanda með þetta email og lykilorð
      // villuskilaboð
      $response["error"] = 1;
      $response["error_msg"] = "Villa kom upp við uppfærslu";
      echo json_encode($response);
    }	
  } else {
    echo "Ógild beiðni. Hvorki með tag login, register né update.";
  }
} else {
  echo "Engin POST beiðni til staðar.";
}
?>