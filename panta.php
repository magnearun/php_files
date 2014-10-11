
<?php
 
/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */

$host="sql5.freemysqlhosting.net"; //replace with database hostname 
$username="sql554585"; //replace with database username 
$password="wI1*pB4!"; //replace with database password 
$db_name="sql554585"; //replace with database name
 
$con=mysql_connect("$host", "$username", "$password"); 
mysql_select_db("$db_name");


// array for JSON response
$response = array();
 
// check for required fields
if (isset($_POST['kt'])) {
 
    $kt = $_POST['kt'];
    $starfsmadur = 'bambi';
    $tegund ="F";
    $startTime = "12:00";
    $endTime = "13:20";
    $dagsetning = "2012.12.12";
    $startDate= "2014-10-12 12:00:00";
    $endDate = "2014-10-12 13:00:00";
   
 

 
    // mysql inserting a new row
    $result = mysql_query("INSERT INTO pantanir(kennitala, starfsmadur, tegund, startTime, endTime, dagsetning, startDate, endDate) VALUES('$kt', '$starfsmadur', '$tegund', '$startTime', '$endTime', '$dagsetning', '$startDate', '$endDate')");
 
    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Product successfully created.";
 
        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
 
        // echoing JSON response
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