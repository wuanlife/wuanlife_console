<div id="starmanagement">
<div id="starlist">
<table class="thinsolid">
	<center>
			<p>星球名:<?php echo $starinfo['gname'];?></p>
			<input type="hidden" id="starnameid" value="<?php echo $starinfo['gid']?>"/>
			<p>星球原主人:<?php echo $starinfo['uname'];?></p>
			<br />
			<label for="userid">星球主人：</label>
			<select id="userid">
				<?php foreach ($userlist as $user_item): ?>
				<option value="<?php echo $user_item['id'];?>"<?php echo $starinfo['uid']==$user_item['id']?' selected':''?>><?php echo $user_item['nickname']; ?></option>
				<?php endforeach; ?>
			</select>
			<br /><br /><br />
			<a href="javascript:void(0)" onClick=staruserupding('starmanagement',<?=$pn?>)>修改</a>
	</center>
</table>
</div>
</div>