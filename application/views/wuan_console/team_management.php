<style>
#teammanagement{
			float: left;
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
<base href = "<?php echo base_url();?>"/>
<script type="text/javascript" src='resource/sql.js'></script>
<div id="teammanagement">
	
	<div id="adminlist">
		<table class="thinsolid" >
		新增管理员:用户昵称<input type="text" id = "nickname" value=''/><a href="javascript:void(0)" onClick=getname('teammanagement')>新增</a>
		</table>
		<br/><br/><br/>
	
	
		
		<table class="thinsolid" >
			<tr id="rs"><?php echo @$msg;?></tr>
		    <tr>
		    <td>用户id</td>
			<td>呢称</td>
			<td>操作</td>
			</tr>
				<?php foreach ($admin as $user_item): ?>
					<tr id="<?=$user_item['id']?>">
					    <td><?=$user_item['id']?></td>
						<td><?=$user_item['nickname']?></td>
						<td><a href="javascript:void(0)" onClick=checkfourm('teammanagement',<?=$user_item['id']?>)>删除</a></td>
					</tr>
				<?php endforeach; ?>
		</table>
	</div>
</div>