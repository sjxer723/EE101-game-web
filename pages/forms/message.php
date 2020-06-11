<?php
header("Content-type:text/html;charset=utf-8");    //设置编码
$servername = "127.0.0.1";
$username = "root";
$password = "";
// 创建连接
$conn = mysqli_connect($servername, $username, $password);
 mysqli_set_charset($conn,'utf8'); //设定字符集 
// 检测连接
if (!$conn) {
    die("连接失败: " . mysqli_connect_error());
}
// 创建数据库  名称为message
$sql = "CREATE DATABASE message";
if (mysqli_query($conn, $sql)) {
    echo "数据库创建成功";
} else {
    echo "数据库创建失败: " . mysqli_error($conn);
}
mysqli_close($conn);
?>