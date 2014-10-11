<?php
$host="sql5.freemysqlhosting.net"; //replace with database hostname 
$username="sql554585"; //replace with database username 
$password="wI1*pB4!"; //replace with database password 
$db_name="sql554585"; //replace with database name
 
$con=mysql_connect("$host", "$username", "$password"); 
mysql_select_db("$db_name");
$sql = "select * from pantanir"; 
$result = mysql_query($sql);
$json = array();
 
if(mysql_num_rows($result)){
while($row=mysql_fetch_assoc($result)){
$json[]=$row;
}
}
mysql_close($con);
echo json_encode($json); 
?> 