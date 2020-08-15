<?php
require('dbconfig.php');
require('class/mail.php');
require('class/website.php');
include_once("class/connect.php");
$email = trim($_POST['email']);
$sql = 'select * from `'.$usertable.'` WHERE email="'.$email.'"';
$query = mysqli_query($conn,$sql);
$num = mysqli_num_rows($query);
if ($num == 0) {
    echo "<script type='text/javascript'>alert('您输入的邮箱未注册！');history.go(-1)</script>";
    exit;
} else {
    $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
    $vtime = time();
    $uid = $row['uid'];
    $username = $row['username'];
    $email = $row['email'];
    $pass = $row['password'];
    $salt = $row['salt'];
    $token = md5(md5($uid.$username.$email.$pass).$salt);
    $url = $website."/reset.php?email=".$email."&token=".$token;
    $time = date('Y-m-d H:i');
    $result = sendmail($time,$email,$url,$username);
    if ($result == 1) {
        $msg = "<script type='text/javascript'>alert('系统已向您的邮箱发送了一封邮件,请登录到您的邮箱及时重置您的密码！');window.location.href='".$website."'</script>";
        $updatetime = 'update `'.$usertable.'` set `vtime`="'.$vtime.'" where uid="'.$uid.'"';
        mysqli_query($conn,$updatetime);
    } else {
        $msg = $result;
    }
}
?>