<?php
function sendmail($time,$email,$url,$username) {
	include_once("class/Smtp.class.php");
	//******************** 配置信息 ********************************
	$smtpserver = "ssl://smtp.ym.163.com";//SMTP服务器
	$smtpserverport =994;//SMTP服务器端口
	$smtpusermail = "no-reply@zhjlfx.cn";//SMTP服务器的用户邮箱
	$smtpemailto = $email;//发送给谁
	$smtpuser = "no-reply@zhjlfx.cn";//SMTP服务器的用户帐号，注：部分邮箱只需@前面的用户名
	$smtppass = "A+Koakuma+135";//SMTP服务器的用户密码
	$mailtitle = "综合资源分享网 - 找回密码";//邮件主题
	$mailcontent = "亲爱的 ".$username." :<br>您收到这封邮件，是因为有人在 综合资源分享网 的密码重置功能使用了您的地址 ".$email."<br>请点此链接重置您的密码: <a href='".$url."'target='_blank'>".$url."</a><br>链接在 15 分钟内有效，如果您并没有访问过我们的网站，或没有进行上述操作，请忽略这封邮件。";
	$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
	//************************ 配置信息 ****************************
	$smtp = new Smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
	$smtp->debug = false;//是否显示发送的调试信息
	$state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
	return $state;
}