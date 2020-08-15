<?php
include_once("dbconfig.php");//连接数据库
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
if (!$conn) {
    die('连接失败: '.mysqli_error($conn));
}
mysqli_query($conn,"set names utf8");