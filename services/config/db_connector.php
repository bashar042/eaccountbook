<?php
date_default_timezone_set('Asia/Dhaka');
header('Content-Type: text/html; charset=utf-8');
// @ live server
$charset = "utf8";
//$user     = "root";
$user = "ideaitbd_root";
$password = "kFyYNxl*^d!x";
$database = "ideaitbd_ecrdr";//"ecrdr_db";
$host = "localhost";//"209.44.117.201:3306";//"127.0.0.2";
$link = mysql_connect($host, $user, $password) or die("\n\n<br> Unable to connect with mysql-server !\n");
mysql_select_db($database) or die("Unable to select database !");
?>
