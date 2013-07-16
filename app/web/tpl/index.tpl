<link rel="stylesheet" type="text/css" href="<?=$css_host;?>/css/index.css" ></link>

<!-- 报错信息 -->
<?php if (isset($error)):?>
<div class="alert alert-error" style="margin: 20px"><?=$error;?></div>
<?php endif;?>

<!-- 头部表单 -->
<div class="navbar-fixed-top">
    <form class="well form-inline" action="<?=$form_action_add?>" method="post" autocomplete="off" >
        <input type="text" class="input-large" placeholder="<?=$input_site;?>" name="name">
        <input type="text" class="input-large" placeholder="<?=$input_url;?>" name="url">
        <button type="submit" class="btn btn-success"><?=$bt_commit;?></button>
        <a class="btn btn-danger" href="javascript:void(0)" id="logout_bt"><?=$bt_logout?></a>
    </form>
</div>

<!-- 搜索区 -->
<div class="container-fluid">
    <div class="row-fluid">
        <div style="margin:10%">

            <!-- logo -->
            <h1 class="form-signin-heading span5 offset4 cw" style="font-family: 'Risque', cursive" title="<?=$site_total;?>">
                <img src='<?=$img_host;?>/img/web.png' width=90 height=90>
                Open Sesame
            </h1>

            <!-- 搜索框+按钮 -->
            <div class="controls-row span9 offset3">
                <div class="form-wrapper cf">
                    <input type="text" name="site" id="search" autocomplete="off" placeholder="<?=$input_search;?>">
                    <button id="search_bt"><?=$bt_search;?></button>
                </div>
            </div>

            <!-- 推荐帐号 -->
            <?php if (isset($recomm)):?>
            <h4 class="controls-row span9 offset3 cw" style="margin-top: 30px">
                <?=$msg_recomm;?>
            </h4>
            <div class="controls-row span8 offset3">
                <?php foreach($recomm as $key => $value):?>
                <div class="span2">
                    <a href="<?=$value['url'];?>" id="recomm_<?=$key + 1;?>" target="_blank"><?=$value['name'];?></a>
                </div>
                <?php endforeach;?>
            </div>
            <?php endif;?>

        </div>
    </div>
</div>
