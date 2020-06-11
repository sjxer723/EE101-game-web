<?php
header("Content-type=text/json;charset=UTF-8");

$conn = mysqli_connect("127.0.0.1", "root", "","game_SQL") or die("数据库连接失败".  mysqli_connect_error());
# 设定字符集
$conn->set_charset("utf8");
# 执行SQL语句
$resultset = mysqli_query($conn, "SELECT name,price from steamgame");
////////////////////////////////////////////////准备数据进行装填
$data = array();
////////////////////////////////////////////////实体类
class Game{
    public $id;
    public $game_name;
    public $game_price;
    public $develper;
    public $release_date;
    public $description;
}
$index=0;
////////////////////////////////////////////////处理
while($row = mysqli_fetch_array($resultset)) {
    $index++;
    $game = new Game();
    $game->id=$index;
    $game->game_name = $row['name'];
    $game->game_price = $row['price'];
    $game->developer=$row['developer'];
    $game->release_date=$row['release_date'];
    $game->description=$row['description'];
    $data[] = $game;
}
// 返回JSON类型的数据
echo json_encode($data);