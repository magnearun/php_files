
<?php
 
/*
 * Sæki upplýsingar um bókaða tíma. 
 * 
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
if (isset($_GET['dagur'])) {

     $dagur= $_GET['dagur'];
     $staff_id= $_GET['staff_id'];

       mysql_query("SET character_set_results=utf8", $con);
    // MySql query - sæki upphafstíma og lengd bókaðra tíma fyrir ákveðin dag
     if ($staff_id != '000') {

        $result = mysql_query("SELECT time, lengd, staff_id FROM Pantanir WHERE dagur = '$dagur' AND staff_id = '$staff_id'");
     }
     else{
        $result = mysql_query("SELECT time, lengd, staff_id FROM Pantanir WHERE dagur = '$dagur'");
     }
    
    $pantanir = array();

    // athuga hvort að skipunin skilaði niðurstöðum
    if (!empty($result)) {
    
        if(mysql_num_rows($result)){
            // set hverja röð sem stak í fylki
            while($row=mysql_fetch_assoc($result)){
                $pantanir[]=$row;
             }

        // að sækja niðurstöður tókst
        $response["success"] = 1;
        $response["pantanir"] = array();
        array_push($response["pantanir"], $pantanir);
        // skila JSON fylki
        echo json_encode($response);
        }
        else {
            // að sækja niðurstöður misstókst
            $response["success"] = 0;
            $response["message"] = "Engin röð fannst";
 
            // skila JSON fylki
            echo json_encode($response);
        }
    }
    else {
       
        $response["success"] = 0;
        $response["message"] = "Engin röð fannst";
 
        // skila JSON fylki
        echo json_encode($response);
    }
} else {
    // Nauðsynlegar upplýsingar vantar
    $response["success"] = 0;
    $response["message"] = "Nauðsynlegar upplýsingar vantar";
 
    // skila JSON fylki
    echo json_encode($response);
}
?>