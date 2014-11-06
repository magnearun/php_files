
<?php
 
/*
 * Sækir annað hvort allar pantanir notanda eða næstu virku pöntun hans
 */

// JSON fylki fyrir niðurstöður
$response = array();

//Sækja dagsetningu dagsins í dag
date_default_timezone_set('Iceland');
$date = date('Y-m-d h:i:s', time());


$host="db4free.net"; //database hostname 
$username="folkmedhar"; //database username 
$password="peoplewithhair"; //database password 
$db_name="folk"; //database name
 
 
// tengjast gagnagrunni
$con=mysql_connect("$host", "$username", "$password"); 
mysql_select_db("$db_name");

// athuga hvort nauðslynlegar upplýsingar séu til staðar
if (isset($_GET['email'])) {
     $email= $_GET['email'];
 

      mysql_query('SET CHARACTER SET utf8');
    if (isset($_GET['sidastaPontun'])) {
       
          // MySQL query - Sæki næstu virku pöntun fyrir tiltekið email
        $result = mysql_query("SELECT * FROM Pantanir WHERE email = '$email' AND startDate = ( SELECT MIN(startDate) FROM (SELECT startDate FROM Pantanir WHERE email ='$email' AND startDate >= '$date' ) AS Framtid)") or die(mysql_error());
     
     }
    else{
           // MySQL query - Sækir allar pantanir fyrir tiltekið email
        $result = mysql_query("SELECT *FROM Pantanir WHERE email ='$email' ORDER BY startDate DESC") or die(mysql_error());
     }
    // Athuga hvort að skipunin skilaði niðurstöðum
    if (mysql_num_rows($result) > 0) {
       
        $response["pantanir"] = array();
     
        while ($row = mysql_fetch_array($result)) {
            
            $product = array();
            $product["adgerd"] = $row["adgerd"];
            $product["staff_id"] = $row["staff_id"];
            $product["dagur"] = $row["dagur"];
            $product["time"] = $row["time"];
            $product["nafn"] = $row["nafn"];
            $product["ID"] = $row["ID"];
            $product["startDate"] = $row["startDate"];
        
     
         
            array_push($response["pantanir"], $product);
        }
       
        $response["success"] = 1;
     
        // skila JSON fylki
        echo json_encode($response);
    } else {
        // engin pöntun fannst
        $response["success"] = 0;
        $response["message"] = "Engin pontun fannst";
     
        // skila JSON fylki
        echo json_encode($response);
    }
}
?>