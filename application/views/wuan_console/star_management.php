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
}

td{
    border: 1px solid black;
    padding: 5px;
}
#rs{
    color:red;
}
</style>
<base href = "<?php echo base_url();?>"/>
<script type="text/javascript" src='resource/sql.js'></script>
<div id="starmanagement">
    <div id="starlist">
<?php
    if(empty($starinfo)){
        echo '无星球！';
    }else{
?>
    <table class="thinsolid">
    <tr id="page">
        <td colspan="10">
        <?php
                if($pn==1){
                    echo '没有上一页';
                }else{


            ?>
            <a id='-' href="javascript:void(0)" onClick=changepage('starmanagement','-',<?=$pn?>)>上一页</a>
            <?}?>
            页码：<?=$pn?>/<?=$pan?>
            <?php
                if($pn>=$pan){
                    echo '没有下一页';
                }else{


            ?>
            <a id='+' href="javascript:void(0)" onClick=changepage('starmanagement','+',<?=$pn?>)>下一页</a>
            <?}?>跳转：<input id='u' type='text' Onchange=changepage('starmanagement','u',u.value) value=<?=$pn?>  />
        </td>


    </tr>
    <tr id="rs"><td colspan="10"><?php echo @$ms;?></td></tr>
    <tr>
        <td>星球id</td>
        <td>星球名称</td>
        <td>星球介绍</td>
        <td>星球主人</td>
        <td>星球主人id</td>
        <td width = 80>状态</td>
		<td width = 50>是否私密</td>
        <td width = 50>改名</td>
        <td width = 50>转让</td>
        <td width = 100 align='center'>操作</td>
    </tr>
<?php foreach ($starinfo as $key): ?>
    <tr id="<?=$key['id']?>">
        <td><?php echo $key['id'] ?></td>
        <td><?php echo $key['name'] ?></td>
        <td><?php echo $key['g_introduction'] ?></td>
        <td><?php echo $key['owner'] ?></td>
        <td><?php echo $key['owner_id'] ?></td>
        <td><?php if($key['status']  =="已隐藏")
        {
             ?><p style="color: red"><?php echo $key['status'] ?></p>
        <?php
        }
        else
            echo $key['status'];
            ?></td>
		<td><p style="color: red"><?php echo $key['private'] ?></p></td>
        <td><a href="javascript:void(0)" onClick=starnameupd('starmanagement',<?=$key['id']?>,<?=$pn?>)>改名</a></td>
        <td><a href="javascript:void(0)" onClick=staruserupd('starmanagement',<?=$key['id']?>,<?=$pn?>)>转让</a></td>
        <td>

            <!-- <a href="<?php echo $_SERVER['SCRIPT_NAME'] ?>/wuan/star_close/<?php echo $key['id'] ?>">关闭</a> -->

            <a href="javascript:void(0)" onClick=groupcp('starmanagement',<?=$key['id']?>,<?=$pn?>,1)>
                <?php
                    if($key['status']  =="已隐藏"){
                        echo '打开';
                    }else{
                        echo '隐藏';
                    }
                ?>
            </a>|
            <a href="javascript:void(0)" onClick=groupcp('starmanagement',<?=$key['id']?>,<?=$pn?>,2)>
                <?php
                    if($key['private']  =="私密"){
                        echo '取私';
                    }else{
                        echo '私密';
                    }
                ?>
            </a>
        </td>
    </tr>
    <?php endforeach; }?>
    </table>
</div>
</div>