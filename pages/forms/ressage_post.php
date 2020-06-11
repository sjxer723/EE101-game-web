<?php
    session_start();
    header("content-type:text/html;charset=utf-8");
    $name=$_POST['name'];
    $email=$_POST['email'];
    $content=$_POST['content'];
    $vcode=$_POST['vcode'];
    if($name==''){
        echo "<script>alert('请输入你的姓名');location='" . $_SERVER['HTTP_REFERER'] . "'</script>";
        exit;
    }
    if($content==''){
        echo "<script>alert('留言内容不能为空');location='" . $_SERVER['HTTP_REFERER'] . "'</script>";
        exit;
    }
    if($vcode!=$_SESSION['VCODE']){
        echo"<script>alert('你的验证码不正确，请重新输入');location='".$_SERVER['HTTP_REFERER']. "'</script>";
        exit;
    }
    $conn=mysqli_connect('127.0.0.1','root','','message');
    mysqli_set_charset($conn,'utf8'); //设定字符集
    //如果连接成功，将数据存入数据库中
    if($conn){
        $sql=mysqli_prepare($conn,"insert into ressage_user(name,email,content,ressage_time) VALUES (?,?,?,now())");
        $param=mysqli_stmt_bind_param($sql,'sss',$name,$email,$content);
        $result=mysqli_stmt_execute($sql);
    if($result){
        echo "<script>alert('留言成功');location.href='basic_elements.php';</script>";
    }else{
        echo"<script>alert('你的留言失败，请稍后重试');location.href='basic_elements.php';</script>";
        exit;
    }
    }else{
        die("数据库连接失败".  mysqli_connect_error());
    }
?>