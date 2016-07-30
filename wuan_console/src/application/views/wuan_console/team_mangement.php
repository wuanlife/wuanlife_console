<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<style type ="text/css">

	
	#container{
		width:400px;
		margin:0 auto;

	}

	table.thinsolid {
		border:thin solid;
		cellpadding:30px;
	
		
	</style>
	<title>team_mangement</title>
	
</head>
<body>
<p style="text-align:right"><?php echo $adminname; ?> <a href="<?php echo site_url('Wuan/login');?>">退出</a></p>
<div id = "container">
	<table cellpadding=30px class="thinsolid">
		<tr>
			<td>午安网管理中心</td>
			<td>成员管理<br /><br /><table class="thinsolid"><td><a href="<?php echo site_url('Wuan/add'); ?>">新增管理员</a></td></table></td>
		</tr>
		<tr>
			<td>管理团队</td>
			<td>
				<table class="thinsolid">
						<td>呢称</td>
						<td>操作</td>
					</tr>
						<?php foreach ($user as $user_item): ?>
							<tr>
								<td><?php echo $user_item['nickname']; ?></td>
								<td><a href="<?php echo site_url('wuan/delete/'.$user_item['Id']) ?>">删除</a></td>

								<!-- <td><?php echo "delete"; ?></td> -->
							</tr>
							


<?php endforeach; ?>
				</table>
			</td>
		</tr>
	</table>

	</div>
</body>
</html>