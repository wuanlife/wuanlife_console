<style type="text/css">
a{ text-decoration: none;}

#staranagement{
    float: left;
}
#starlist{
            padding-top: 10px;
            padding-left: 50px;
            height: 490px;
            background-color: white;
        }

table{
    border: solid 1px black;
    border-collapse: collapse;
	text-overflow:ellipsis;
	overflow:hidden;
}

td{
    border: 1px solid black;
    padding: 5px;
}
#rs{
    color:red;
}
.div-tdcontent{
height:15px;
text-overflow:ellipsis;
overflow:hidden;
}
.div-hidden{ background:#FFF; color:#F00}
</style>
<base href = "<?php echo base_url();?>"/>
<script type="text/javascript" src='resource/sql.js'></script>
<div id="starmanagement">
    <div id="starlist">
<?php
    if(empty($starinfo)):
        echo '无星球！';
    else:
?>
    <table width="85%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
    <tr id="page">
        <td colspan="10">
        <?php
            if($pn==1):
                echo '上一页';
            else:


            ?>
            <a id='-' href="javascript:void(0)" onClick=changepage('starmanagement','-',<?=$pn?>)>上一页</a>
        <?php
			endif;
		?>
            页码：<?=$pn?>/<?=$pan?>
            <?php
            if($pn>=$pan):
                echo '下一页';
            else:


            ?>
            <a id='+' href="javascript:void(0)" onClick=changepage('starmanagement','+',<?=$pn?>)>下一页</a>
        <?php
			endif;
		?>
		跳转：<input id='u' type='text' Onchange=changepage('starmanagement','u',u.value) value=<?=$pn?>  />
        </td>


    </tr>
    
    <tr>
        <td width="5%">星球id</td>
        <td width="15%">星球名称</td>
        <td width="35%">星球介绍</td>
        <td width="10%">星球主人</td>
        <td width="5%">星球主人id</td>
        <td width="5%">状态</td>
		<td width="5%">是否私密</td>
        <td width="5%">改名</td>
        <td width="5%">转让</td>
        <td width="10%" align='center'>操作</td>
    </tr>
<?php foreach ($starinfo as $key): ?>
    <tr id="<?=$key['id']?>">
        <td><div class="div-tdcontent"><?=$key['id']?></div></td>
        <td><div class="div-tdcontent"><?=$key['name']?></div></td>
        <td><div class="div-tdcontent"><?=$key['g_introduction']?></div></td>
        <td><div class="div-tdcontent"><?=$key['owner']?></div></td>
        <td><div class="div-tdcontent"><?=$key['owner_id']?></div></td>
        <td>
			<div class="div-tdcontent">
			<?php if($key['status'] =="已隐藏"):?>
					<div class="div-hidden">
			<?php else:?>
					<div>
        <?php
				endif;
            echo $key['status'];
            ?>
					</div>
			</div>
		</td>
		<td>
			<div class="div-tdcontent">
			<?php if($key['private'] =="私密"):?>
					<div class="div-hidden">
			<?php else:?>
					<div>
			<?php
				endif;
				echo $key['private'];
            ?>
					</div>
			</div>
		</td>
        <td><div class="div-tdcontent"><a href="javascript:void(0)" onClick=starnameupd('starmanagement',<?=$key['id']?>,<?=$pn?>)>改名</a></div></td>
        <td><div class="div-tdcontent"><a href="javascript:void(0)" onClick=staruserupd('starmanagement',<?=$key['id']?>,<?=$pn?>)>转让</a></div></td>
        <td>
			<div class="div-tdcontent">

            <!-- <a href="<?php echo $_SERVER['SCRIPT_NAME'] ?>/wuan/star_close/<?php echo $key['id'] ?>">关闭</a> -->

            <a href="javascript:void(0)" onClick=groupcp('starmanagement',<?=$key['id']?>,<?=$pn?>,1)>
                <?php
                    if($key['status']  =="已隐藏"):
                        echo '打开';
                    else:
                        echo '隐藏';
                    endif;
                ?>
            </a>|
            <a href="javascript:void(0)" onClick=groupcp('starmanagement',<?=$key['id']?>,<?=$pn?>,2)>
                <?php
                    if($key['private']  =="私密"):
                        echo '取私';
                    else:
                        echo '私密';
                    endif;
                ?>
            </a>
			</div>
        </td>
    </tr>
    <?php 
		endforeach;
	?>
	<tr id="rs"><td align='right'colspan="10"><?php echo @$ms;?></td></tr>
    </table>
	<?php
		endif;
	?>
</div>
</div>