<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="?"><?=$msg_total?> "<?=$keyword;?>" : <?=$total;?></a>
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
                <th width="20%"><?=$input_site;?></th>
                <th width="20%"><?=$input_op;?></th>
                <th width="60%"><?=$input_url;?></th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($site_list as $k => $v):?>
        <tr>
            <th>
                <a href="<?=$v['info_url'];?>"><?=$k;?></a>
            </th>
            <td>
                <a href="<?=$v['info_url'];?>" class="btn bt" target="_blank"><?=$bt_info;?></a>
                <button class="btn btn-danger list_del_bt bt" id="<?=$k;?>"><?=$bt_del;?></button>
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
