<script language="javascript" src="<?=$host?>static/vendor/jquery/plugins/jquery.jrumble.1.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$host?>static/application/css/index.css" ></link>

<!-- 报错信息 -->
<?php if (isset($error)):?>
<div class="alert alert-error" style="margin: 20px"><?=$error;?></div>
<?php endif;?>

<!-- 头部表单 -->
<div class="navbar-fixed-top" id="add_input" style="display : none">
    <form class="well form-inline" action="<?=$form_action_add?>" method="post" autocomplete="off" >
        <a href="http://cn.gravatar.com/emails/" target="__blank"><img src="<?=$gravatar;?>" alt="liuxd" width="30" height="30" /></a>
        <input type="text" class="input-large" placeholder="网站名称" name="name">
        <input type="text" class="input-large" placeholder="网址" name="url">
        <button type="submit" class="btn btn-success">添加</button>
        <a class="btn btn-danger" href="javascript:void(0)" id="logout_bt">退出</a>
    </form>
</div>

<div class="navbar-fixed-top" style="width : 50px">
    <button type="button" class="btn btn-primary btn-small" id="add_pull" >+</button>
</div>

<!-- 搜索区 -->
<div class="container-fluid">
    <div class="row-fluid">
        <div style="margin:10%">

            <!-- logo -->
            <h1 class="form-signin-heading span5 offset4 cw" style="font-family: 'Risque', cursive" title="<?=$site_total;?>" id="logo">
                <img src='<?=$host?>static/application/img/web.png' width=90 height=90 id="icon">
                Open Sesame
            </h1>

            <!-- 搜索框+按钮 -->
            <div class="controls-row span9 offset3">
                <div class="form-wrapper cf">
                    <input type="text" name="site" id="search" autocomplete="off" placeholder="骚年，你想知道什么？" x-webkit-speech lang="zh-CN" x-webkit-grammar="bUIltin:search" />
                    <button id="search_bt">芝麻开门</button>
                </div>
            </div>

            <h4 class="controls-row span9 offset3 cw" style="margin-top: 30px">推荐</h4>

            <!-- 随机帐号 -->
            <?php if (isset($random)):?>
            <div class="controls-row span8 offset3">
                <?php foreach($random as $key => $value):?>
                <div class="span2 recommand">
                    <a href="<?=$value['url'];?>" title="<?=$value['name'];?>" target="_blank"><?=$value['name'];?></a>
                </div>
                <?php endforeach;?>
            </div>
            <?php endif;?>

            <!-- 推荐帐号 -->
            <?php if (isset($recomm)):?>
            <div class="controls-row span8 offset3">
                <?php foreach($recomm as $key => $value):?>
                <div class="span2 recommand">
                    <a href="<?=$value['url'];?>" title="<?=$value['name'];?>" target="_blank"><?=$value['name'];?></a>
                </div>
                <?php endforeach;?>
            </div>
            <?php endif;?>

        </div>
    </div>
</div>

<script type="text/javascript">
    $('#icon').jrumble().hover(
            function() {
                $(this).trigger('startRumble');
            },
            function() {
                $(this).trigger('stopRumble');
            }
    );

    $('#search_bt').jrumble().hover(
            function() {
                $(this).trigger('startRumble');
            },
            function() {
                $(this).trigger('stopRumble');
            }
    );
</script>
