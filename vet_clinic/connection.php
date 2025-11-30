<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'vet_clinic');

// Attempt to connect to MySQL database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("ERROR: Could not connect to the database. Check your MySQL server status and credentials. Error: " . $conn->connect_error);
}

//connection.php
// $server="10.74.48.199";
// $dbuser="postgres";
// $dbpassword="password";
// $dbname="postgres";
// $db=mysqli_connect($server,
//         $dbuser,
//         $dbpassword,
//         $dbname);

// if (mysqli_connect_errno($db)) {
//     echo "Connection to db failed: ", mysqli_connect_error($db);
//     exit();
// }else{
// 	//echo "Successful connect to database<br>";
// }



//define('DB_SERVER1', '10.74.48.199');
//define('DB_USERNAME1', 'postgres');
//define('DB_PASSWORD1', 'password');
//define('DB_NAME1', 'postgres');

// Attempt to connect to MySQL database
//$conn1 = new mysqli(DB_SERVER1, DB_USERNAME1, DB_PASSWORD1, DB_NAME1);

// Check connection
//if ($conn1->connect_error) {
    //die("ERROR: Could not connect to the database. Check your MySQL server status and credentials. Error: " . $conn1->connect_error);
//}
?>
