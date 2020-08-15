<?php
include_once("class/connect.php");
include_once("class/salt.php");
include_once("class/website.php");
$email = $_POST['email'];
$pass1 = $_POST['password1'];
$pass2 = $_POST['password2'];
if ($pass1 !== $pass2) {
    echo "<script type='text/javascript'>alert('两次输入的密码不一致！');history.go(-1)</script>";
} else {
    $salt = generatsalt(6);
    $saltedpass = md5(md5($pass2).$salt);
    $sql = 'select * from `'.$usertable.'` WHERE email="'.$email.'"';
    $sql1 = 'update '.$usertable.' set password="'.$saltedpass.'" where email="'.$email.'"';
    $sql2 = 'update '.$usertable.' set salt="'.$salt.'" where email="'.$email.'"';
    $query = $query = mysqli_query($conn,$sql);
    $num = mysqli_num_rows($query);
    if ($num == 0) {
        echo "<script type='text/javascript'>alert('无法获取数据！');window.location.href='".$redirect."'</script>";
        exit;
    }else{
        mysqli_query($conn,$sql1);
        mysqli_query($conn,$sql2);
        echo "<script type='text/javascript'>alert('密码重置完成，请使用新密码登录！');window.location.href='".$redirect."'</script>";
        exit;
    }
}