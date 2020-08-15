<?php
include_once("class/connect.php");
require('class/website.php');
$token = trim($_GET['token']);
$email = trim($_GET['email']);
$sql = 'select * from `'.$usertable.'` WHERE email="'.$email.'"';
$query = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
if ($row) {
    $uid = $row['uid'];
    $username = $row['username'];
    $email = $row['email'];
    $pass = $row['password'];
    $salt = $row['salt'];
    $vtime = $row['vtime'];
    $mt = md5(md5($uid.$username.$email.$pass).$salt);
    if ($mt == $token) {
        if (time()-$vtime > 15*60) {
            $msg = "<script type='text/javascript'>alert('链接已过期！');window.location.href='".$redirect."'</script>";
        } else {
            $msg = '<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
<title>设置新密码</title>
<link href="css/login.css" type="text/css" rel="stylesheet">
</head>
<body>

<div class="login">
    <div class="message">设置新密码</div>
    <div id="darkbannerwrap"></div>
    <form action="newpass.php" method="post">
		<input name="action" value="login" type="hidden">
		<input name="email" placeholder="邮箱" required="" type="email" value="'.$email.'" readonly="true">
		<hr class="hr15">
		<input name="password1" placeholder="新密码" required="" type="password">
		<hr class="hr15">
		<input name="password2" placeholder="确认新密码" required="" type="password">
		<hr class="hr15">
		<input value="提交" style="width:100%;" type="submit">
	</form>
</div>

<div class="copyright">© 2020 综合资源分享网 by <a href="https://www.zhjlfx.cn" target="_blank">综合资源分享网</a></div>

</body>
</html>';
        }
    } else {
        $msg = "<script type='text/javascript'>alert('该链接已失效！');window.location.href='".$redirect."'</script>";
    }
} else {
    $msg = "<script type='text/javascript'>alert('链接错误！');window.location.href='".$redirect."'</script>";
}
echo $msg;