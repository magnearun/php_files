
<?php
 
/*
 * Sæki upplýsingar um bókaða tíma. 
 * 
 */

$host="sql5.freemysqlhosting.net"; //Database hostname 
$username="sql554616"; //Database username 
$password="tS6%eH6%"; //Database password 
$db_name="sql554616"; //Database name
 
// tengjast gagnagrunni
$con=mysql_connect("$host", "$username", "$password"); 
mysql_select_db("$db_name");


// JSON fylki fyrir niðurstöður
 $response = array();

// athuga hvort nauðslynlegar upplýsingar séu til staðar
if (isset($_GET['dagur'])) {

     $dagur= $_GET['dagur'];
     $staff_id= $_GET['staff_id'];

    
    // MySql query - sæki upphafstíma og lengd bókaðra tíma fyrir ákveðin dag

    $result = mysql_query("SELECT time, lengd FROM Pantanir WHERE dagur = '$dagur' AND staff_id = '$staff_id'");
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