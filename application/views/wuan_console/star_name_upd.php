<div id="starmanagement">
<div id="starlist">
<table class="thinsolid">
	<center>
		<form action="<?php echo site_url('wuan/star_name_upding/'.$starinfo['id']); ?>" method="post">
			<p>星球名修改:（原名称："<?php echo $starinfo['name']?>"）</p>
			<br />
			<label for="nickname">呢称：</label>
			<input type="text" id="starname" value="<?php echo $starinfo['name']?>"/>
			<input type="hidden" id="starnameid" value="<?php echo $starinfo['id']?>"/>
			<br /><br /><br />
			<a href="javascript:void(0)" onClick=starnameupding('starmanagement',<?=$pn?>)>改名</a>
		</form>
	</center>
</table>
</div>
</div>