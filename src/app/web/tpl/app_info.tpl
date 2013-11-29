<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="<?=$app_url;?>" target="_blank" id="home_url"><?=$page_title;?></a>
        </div>
    </div>
</div>

<?php if ($error):?>
<div class="alert alert-error" style="margin: 0 20px 20px 20px"><?=$error;?></div>
<?php endif;?>

<div class="container-fluid">

    <form action="<?=$form_action_add;?>" method="post" class="well form-inline" autocomplete="off">
        <input type="hidden" name="table" value="<?=$site_name;?>" />
        <input type="text" name="key" id="field_name" class="input_text" placeholder="<?=$input_key;?>" />
        <input type="password" name="value" id="field_value" class="input_text" placeholder="<?=$input_value;?>" />
        <input type="submit" value="<?=$bt_commit;?>" class="btn btn-primary" />
        <input type="button" value="<?=$bt_pwd;?>" class="btn btn-inverse" id="pwd_bt" />
    </form>

    <?php if ($site_info['stat'] === TRUE):?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th width="20%"><?=$th_name;?></th>
                <th width="20%"><?=$th_op;?></th>
                <th width="60%"><?=$th_value?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($site_info['response'] as $k => $v):?>
        <tr>
            <td><?=$k;?></td>
            <td>
                <span class="btn btn-danger info_del_bt" title='<?=$k;?>'><?=$bt_del;?></span>
                <span class="btn btn-info info_up_bt"  title='<?=$k;?>' id='<?=$v['real'];?>'><?=$bt_modify;?></span>
                <span class="btn btn-success info_copy_bt" id='<?=$v['real'];?>'><?=$bt_copy;?></span>
            </td>
            <td><?=$v['display'];?></td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <?php endif;?>
</div>

<form action="<?=$form_action_del;?>" method="post" id="del">
    <input type="hidden" name="table" value="<?=$site_name?>" />
    <input type="hidden" name="key" id="key" />
</form>
