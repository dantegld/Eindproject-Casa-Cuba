<?php
$servername = "srv1650.hstgr.io";
$username = "u578783310_dante";
$password = "ik ben niet dom";
$dbname = "u578783310_casacuba";

$localServername = "localhost";
$localUsername = "root";
$localPassword = "";
$localDbname = "u578783310_casacuba";


$mysqli = new mysqli($servername, $username, $password, $dbname);

session_start();

//mysqli = new mysqli($localServername, $localUsername, $localPassword, $localDbname);


if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
