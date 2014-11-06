
<?php
 
/*
 * Following code will list all the products
 */

// JSON fylki fyrir niðurstöður
$response = array();



$host="xh1887.sql.x.is"; //database hostname 
$username="xh1887"; //database username 
$password="birkirflotti"; //database password 
$db_name="xh1887"; //database name
 
 
// tengjast gagnagrunni
$con=mysql_connect("$host", "$username", "$password"); 
mysql_select_db("$db_name");


 
// MySQL query - Sæki allar raðir úr töflunni Verdlisti
$result = mysql_query("SELECT *FROM Verdlisti") or die(mysql_error());
 
// Athuga hvort að skipunin skilaði niðursöðum
if (mysql_num_rows($result) > 0) {
   
    $response["verdlisti"] = array();
 
    while ($row = mysql_fetch_array($result)) {
      
        $verdlisti = array();
        $verdlisti["adgerd"] = $row["adgerd"];
        $verdlisti["verd"] = $row["verd"];
        
    
 
       
        array_push($response["verdlisti"], $verdlisti);
    }

    $response["success"] = 1;
 
    // skila JSON fylki
    echo json_encode($response);
} else {
    // Enginn verðlisti fannst
    $response["success"] = 0;
    $response["message"] = "Enginn verdlisti fannst";
 
    // skila JSON fylki
    echo json_encode($response);
}

?>