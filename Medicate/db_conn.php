<?php

$name="";
$email="";
$ssid="";
$dsid="";
$conn=mysqli_connect('localhost','root','','medical_record_system');

if(!$conn){
	echo "Connection failed.";
}	
?>