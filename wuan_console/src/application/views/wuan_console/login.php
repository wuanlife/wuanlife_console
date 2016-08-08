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
		
	<form action="<?php echo site_url('Wuan/logining'); ?>" method="post">
	<table>
		<tr>
			<td>用户名：</td>
			<td><input type="input" name= "adminname" value="<?php echo set_value('adminname'); ?>" ><?php echo form_error('adminname','<span>','</span>');?></td>
		</tr>
		<tr>
			<td>密 码：</td>
			<td><input type="password" name= "adminpwd" value="<?php echo set_value('adminpwd'); ?>" ><?php echo form_error('adminpwd','<span>','</span>');?></td>
		</tr>
		<tr>
			<td colspan = "2" style="text-align:center;"><input type ="submit" name= "submit" value="登陆" /></td>
		</tr>
	</table>


	</center>
</form>
</body>
</html>