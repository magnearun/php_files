
<?php
 
/*
 * Bý til nýja röð í töflunni Pantanir.
 * 
 */

$host="db4free.net"; //database hostname 
$username="folkmedhar"; //database username 
$password="peoplewithhair"; //database password 
$db_name="folk"; //database name



 
$con=mysql_connect("$host", "$username", "$password"); 
mysql_select_db("$db_name");


// JSON fylki fyrir niðurstöður
$response = array();
 
// athuga hvort nauðslynlegar upplýsingar séu til staðar
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
   
    // MySQL query - Bæti við röð í töflunni Pantanir
    $result = mysql_query("INSERT INTO Pantanir(startDate, endDate, staff_id, adgerd, nafn, simi, email, harlengd, time, dagur, lengd) VALUES('$startDate', '$endDate', '$staff_id', '$adgerd', '$nafn', $simi, '$email', '$harlengd', '$time', '$dagur', '$lengd' )");
 
    // Athuga hvort það tókst að bæta við röð
    if ($result) {
        // innsetning í töflu heppnaðist
        $response["success"] = 1;
        $response["message"] = "Nýrri röð hefur verið bætt við.";
 
        // skila JSON fylki
        echo json_encode($response);
    } else {
        // innsetning í töflu misheppnaðist
        $response["success"] = 0;
        $response["message"] = "Oops! Villa!.";
 
        // skila JSON fylki
        echo json_encode($response);
    }
} else {
    // Nauðsynlegar upplýsingar vantar
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
 
    // skila JSON fylki
    echo json_encode($response);
}
?>