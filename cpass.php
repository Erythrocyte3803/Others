<?php
require('dbconfig.php');
include_once("class/connect.php");
include_once("class/salt.php");
include_once("class/website.php");
$email = trim($_POST['email']);
$oldpass = $_POST['oldpassword'];
$newpass1 = $_POST['newpass1'];
$newpass2 = $_POST['newpass2'];
$sql = 'select * from `'.$usertable.'` WHERE email="'.$email.'"';
$query = mysqli_query($conn,$sql);
$num = mysqli_num_rows($query);
if ($num == 0) {
    echo "<script type='text/javascript'>alert('您输入的邮箱不存在！');history.go(-1)</script>";
    exit;
} else {
    $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
    $username = $row['username'];
    $email = $row['email'];
    $pass = $row['password'];
    $salt = $row['salt'];
    $old_salted = md5(md5($oldpass).$salt);
    if ($old_salted !== $pass) {
        echo "<script type='text/javascript'>alert('原密码错误！');history.go(-1)</script>";
        exit;
    } else if ($newpass1 !== $newpass2) {
        echo "<script type='text/javascript'>alert('两次输入的密码不一致！');history.go(-1)</script>";
        exit;
    } else {
        $pass_salt = generatsalt(6);
        $saltedpass = md5(md5($newpass2).$pass_salt);
        $sql_updatepass = 'update '.$usertable.' set password="'.$saltedpass.'" where email="'.$email.'"';
        $sql_updatesalt = 'update '.$usertable.' set salt="'.$pass_salt.'" where email="'.$email.'"';
        mysqli_query($conn,$sql_updatepass);
        mysqli_query($conn,$sql_updatesalt);
        echo "<script type='text/javascript'>alert('密码修改完成，请使用新密码登录！');window.location.href='".$redirect."'</script>";
        exit;
    }
}