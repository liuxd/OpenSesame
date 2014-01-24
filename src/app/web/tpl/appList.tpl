<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="?">搜索 "<?=$keyword;?>" 的结果数为 : <?=$total;?></a>
        </div>
    </div>
</div>

<div class="container-fluid">
    <?php if ($error):?>
    <div class="alert alert-error"><?=$error;?></div>
    <?php endif;?>

    <?php if ($total > 0):?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th width="20%">帐号</th>
                <th width="20%">操作</th>
                <th width="60%">网址</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($site_list as $k => $v):?>
        <tr>
            <th>
                <a href="<?=$v['info_url'];?>"><?=$k;?></a>
            </th>
            <td>
                <a href="<?=$v['info_url'];?>" class="btn bt" target="_blank">查看</a>
                <button class="btn btn-danger list_del_bt bt" id="<?=$k;?>">删除</button>
            </td>
            <td>
                <a href="<?=$v['goto_url'];?>" target='_blank'><?=$v['goto_url'];?></a>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>

<form action="<?=$form_action_del;?>" method="post" id="del">
    <input type="hidden" name="table" value="<?=$table;?>" />
    <input type="hidden" name="key" id="key" />
</form>
<?php endif;?>
