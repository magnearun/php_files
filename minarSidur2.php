
<?php
 
/*
 * Sæki upplýsingar um allar pantanir notanda
 */

$host="sql5.freemysqlhosting.net"; //database hostname 
$username="sql554616"; //database username 
$password="tS6%eH6%"; //database password 
$db_name="sql554616"; //database name
 
$con=mysql_connect("$host", "$username", "$password"); 
mysql_select_db("$db_name");


// JSON fylki fyrir niðurstöður
 $response = array();


// athuga hvort að nauðsynlegar upplýsingar séu til staðar
if (isset($_GET['kt'])) {
    $kt= $_GET['kt'];
 
    // MySQL skipun - Sæki allar pantanir á ákveðinni kennitölu
    $result = mysql_query("SELECT *FROM Pantanir WHERE kt = $kt");

    $pantanir = array();
    // athuga hvort skipunin skilaði niðurstöðum
    if (!empty($result)) {
        if (mysql_num_rows($result) > 0) {
            if(mysql_num_rows($result)){
                while($row=mysql_fetch_assoc($result)){
                    $pantanir[]=$row;
                }

            }
        
            // skipunin skilaði niðurstöðum
            $response["success"] = 1;

            $response["pantanir"] = array();
 
            array_push($response["pantanir"], $pantanir);
 
            // Skila JSON fylki
            echo json_encode($response);
        } else {
            // engin röð fannst
            $response["success"] = 0;
            $response["message"] = "Engar pantanir fundust";
 
            // skila JSON fylki
            echo json_encode($response);
        }
    } else {
        // engin röð fannst
        $response["success"] = 0;
        $response["message"] = "Engar pantanir fundust";
 
        // skila JSON fylki
        echo json_encode($response);
    }
} else {
    // nauðsynlegr upplýsingar vantar
    $response["success"] = 0;
    $response["message"] = "nauðsynlegr upplýsingar vantar";
 
    // skila JSON fylki
    echo json_encode($response);
}
?>