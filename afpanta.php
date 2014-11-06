
<?php
 
/*
 * Eyðum röð úr gagnagrunni. 
 * Nota id til að auðkenna röð
 */

$host="db4free.net"; //database hostname 
$username="folkmedhar"; //database username 
$password="peoplewithhair"; //database password 
$db_name="folk"; //database name
 
// tengjast gagnagrunni
$con=mysql_connect("$host", "$username", "$password"); 
mysql_select_db("$db_name");


 
// JSON fylki fyrir niðurstöður
$response = array();
 
// athuga hvort nauðslynlegar upplýsingar séu til staðar
if (isset($_POST['id'])) {
    $id = $_POST['id'];
 
    
 
    // MySql query - sæki röðina tiltekið id úr töflunni Pantanir
    $result = mysql_query("DELETE FROM Pantanir WHERE ID = $id");
 
    
    // athuga hvort að skipunin skilaði niðurstöðum
    if (mysql_affected_rows() > 0) {
        
        $response["success"] = 1;
        $response["message"] = "Order successfully deleted";
 
          // skila JSON fylki
        echo json_encode($response);
    } else {
          // að sækja niðurstöður misstókst
        $response["success"] = 0;
        $response["message"] = "No order found";
 
        // skila JSON fylki
        echo json_encode($response);
    }
} else {
    // nauðsynlegar upplýsingar vantar
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
 
    // skila JSON fylki
    echo json_encode($response);
}
?>