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
        <input type="text" name="key" id="field_name" class="input_text" placeholder="名称" />
        <input type="text" name="value" id="field_value" class="input_text" placeholder="内容" />
        <input type="submit" value="确定" class="btn btn-primary" id="info_enter" />
        <input type="button" value="生成随机密码" class="btn btn-warning" id="pwd_bt" />

        <?php if($default_password):?>
        <input type="button" value="生成默认密码" class="btn btn-info" id="pwd_bt_default" data="<?=$default_password?>" />
        <?php endif;?>

        <?php if($emails):?>
        <div class="btn-group">
            <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">
                选择常用邮箱
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <?php foreach ($emails as $email):?>
                <li><a class="emails" href="#" data="<?=$email?>"><?=$email?></a></li>
                <?php endforeach;?>
            </ul>
        </div>
        <?php endif;?>
    </form>

    <?php if ($site_info['stat'] === true):?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th width="20%">名称</th>
                <th width="30%">操作</th>
                <th width="50%">内容</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($site_info['response'] as $k => $v):?>
            <tr>
                <td><?=$k;?></td>
                <td>
                    <span class="btn btn-danger info_del_bt" title='<?=$k?>'>删除</span>
                    <span class="btn btn-info info_up_bt"  title='<?=$k?>' id='<?=$v['real']?>'>修改</span>
                    <span class="btn btn-success info_show_bt" id='<?=$v['real']?>'>查看</span>
                    <span class="btn btn-primary info_copy_bt" id='copy-button' data-clipboard-text='<?=$v['real']?>'>复制</span>
                </td>

                <?php if (isset($v['link'])):?>
                <td>使用 <b><a href="<?=$v['link']?>"><?=$v['site_name']?></a></b> 帐号登录</td>
                <?php else: ?>
                <td><?=$v['display']?></td>
                <?php endif;?>
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
<script language="javascript" src="<?=$host?>static/zeroclipboard/ZeroClipboard.min.js"></script>
<script language="javascript" src="<?=$host?>static/bootstrap/js/plugin/bootstrap-typeahead.js"></script>
<script language="javascript">
$('#field_value').typeahead({
    source: <?=$site_list?>,
    display: 'name',
});
</script>
