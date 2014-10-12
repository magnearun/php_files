
<?php
 
/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */

$host="sql5.freemysqlhosting.net"; //replace with database hostname 
$username="sql554616"; //replace with database username 
$password="tS6%eH6%"; //replace with database password 
$db_name="sql554616"; //replace with database name
 
$con=mysql_connect("$host", "$username", "$password"); 
mysql_select_db("$db_name");


// array for JSON response

 $response = array();

   
 
    // check for post data
if (isset($_GET['kt'])) {
    $kt= $_GET['kt'];
 
    // get a product from products table
    $result = mysql_query("SELECT *FROM Pantanir WHERE kt = $kt");
    $pantanir = array();
    if (!empty($result)) {
        // check for empty result
        if (mysql_num_rows($result) > 0) {
            
            if(mysql_num_rows($result)){
                while($row=mysql_fetch_assoc($result)){
                    $pantanir[]=$row;
                }

            }
          
 
         
           
            // success
            $response["success"] = 1;
 
            // user node
            $response["pantanir"] = array();
 
           array_push($response["pantanir"], $pantanir);
 
            // echoing JSON response
            echo json_encode($response);
        } else {
            // no product found
            $response["success"] = 0;
            $response["message"] = "No product found";
 
            // echo no users JSON
            echo json_encode($response);
        }
    } else {
        // no product found
        $response["success"] = 0;
        $response["message"] = "No product found";
 
        // echo no users JSON
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
 
    // echoing JSON response
    echo json_encode($response);
}
?>