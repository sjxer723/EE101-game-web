<?php
header("Content-type:type/html;charset=utf-8");//设置编码
$servername="127.0.0.1";
$username="root";
$password="";
$dbname="message";

//创建连接
$conn=mysqli_connect($severname,$username,$password,$dbname);
mysqli_set_charset($conn,'utf8');//设定字符集

//检测连接
if(!$conn){
    die("连接失败：".mysqli_connect_errror());
}

// 使用 sql 创建数据表
$sql = "CREATE TABLE Ressage_user (
    id INT(30) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    content VARCHAR(200) NOT NULL,
    ressage_time DATE
    )";

if (mysqli_query($conn, $sql)) {
       echo "数据表 user 创建成功";
} else {
       echo "创建数据表错误: " . mysqli_error($conn);
}
   mysqli_close($conn);
?>

