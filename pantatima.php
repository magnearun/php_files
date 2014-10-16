
<?php
 
/*
 * Bý til nýja röð í töflunni Pantanir.
 * 
 */

$host="sql5.freemysqlhosting.net"; //replace with database hostname 
$username="sql554616"; //replace with database username 
$password="tS6%eH6%"; //replace with database password 
$db_name="sql554616"; //replace with database name
 
$con=mysql_connect("$host", "$username", "$password"); 
mysql_select_db("$db_name");


// array for JSON response
$response = array();
 
// check for required fields
if (isset($_POST['staff_id'])) {

    $staff_id = $_POST['staff_id'];
    $adgerd =$_POST['adgerd'];
    $harlengd = $_POST['harlengd'];
    $staff_id = $_POST['staff_id'];
    $nafn = $_POST['nafn'];
    $simi = $_POST['simi'];
    $time = $_POST['time'];
    $startDate= $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $email = $_POST['email'];
    $status = "ghjk";
    $dagur = $_POST['dagur'];
    $lengd = $_POST['lengd'];  
   
    // MySQL query
    $result = mysql_query("INSERT INTO Pantanir(startDate, endDate, staff_id, adgerd, nafn, simi, email, harlengd, time, dagur, lengd) VALUES('$startDate', '$endDate', '$staff_id', '$adgerd', '$nafn', $simi, '$email', '$harlengd', '$time', '$dagur', '$lengd' )");
 
    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Nýrri röð hefur verið bætt við.";
 
        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! Villa!.";
 
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