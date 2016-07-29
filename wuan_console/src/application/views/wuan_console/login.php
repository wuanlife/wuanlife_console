<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Login in</title>
</head>
<body>
	<br />
	<br />
	<center>午安网管理中心
	<br />
	<br />
		<?php echo validation_errors(); ?>
	<form action="<?php echo site_url('Wuan/yanzheng'); ?>" method="post">
		<label for="adminname">用户名：</label>
		<input type="input" name= "adminname" /><br />
		<br />
		<label for="adminpwd">密　码：</label>
		<input type="password" name ="adminpwd" /><br />
		<br />
		<input type ="submit" name= "submit" value="登陆" />
	</center>
</form>
</body>
</html>