<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>team_mangement</title>
	<style>
		#container{
			border: 1px;
			width: 1024px

		}
		#head{
			height: 50px;
			background-color: red;
			line-height: 50px;
			
		}
		#wuan_1{
			float: left;
			width: 400px;
		}
		#wuan_2{
			float: left;
			width: 400px;
		}
		#wuan_3{
			float: right;
		}

		#lmain{
			width: 200px;
			height: 600px;
			text-align: center;
			line-height:600px;
			background-color: grey;
			float: left;
		}
		#rmain{
			float: left;
		}
		#newadmin{
			width: 100px;
			height: 20px;
			border: 1px solid black;
			text-align: center;
			margin: 29px;
			padding: 10px;

		}
		#adminlist{
			padding-top: 10px;
			padding-left: 50px;
			height: 490px;
			background-color: white;
		}
		table{
			border: solid 1px black;
			border-collapse: collapse;


		}
		td{
			border: 1px solid black;
			padding: 5px;


		}

	</style>
</head>
<body>
	<div id="container">
		<div id="head">
			<div id="wuan_1">
				午安网管理中心
			</div>
			<div id="wuan_2">
				成员管理
			</div>
			<div id="wuan_3">
				<span><?php echo $adminname; ?>
				<a href="<?php echo site_url('Wuan/login');?>">退出</a></span>
			</div>
		</div>

		<div id="lmain">
			管理团队
		</div>
		<div id="rmain">
			<div id="newadmin">
				<a href="<?php echo site_url('Wuan/add'); ?>">新增管理员</a>
			</div>
			<div id="adminlist">
				<table class="thinsolid" >
						<td>呢称</td>
						<td>操作</td>
					</tr>
						<?php foreach ($new as $user_item): ?>
							<tr>
								<td><?php echo $user_item['nickname']; ?></td>
								<td><a href="<?php echo site_url('wuan/delete/'.$user_item['id']) ?>">删除</a></td>

								<!-- <td><?php echo "delete"; ?></td> -->
							</tr>
							


<?php endforeach; ?>
				</table>
			</div>

		</div>
	</div>
</body>
</html>