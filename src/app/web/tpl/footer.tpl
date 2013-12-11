<!-- footer -->
<footer class="footer" id="footer">
    Powered By <a href="https://github.com/liuxd?tab=repositories" target="_blank">刘喜东</a>
</footer>

<!--普通内容弹出框-->
<div class="modal" id="popup" style="display:none">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3><?=$pop_title;?></h3>
    </div>

    <div class="modal-body">
        <p><input id="pop_content" type="text" value="" /></p>
    </div>
</div>

<?php foreach ($msg_js as $k => $v):?>
<input type="hidden" value="<?=$v;?>" id="<?=$k;?>" />
<?php endforeach;?>

<div id="pop_confirm"></div>
<script language="javascript" src="<?=$js_host;?>/bootstrap/js/plugin/bootstrap-modal.js"></script>
<script language="javascript" src="<?=$js_host;?>/bootstrap/js/plugin/bootstrap-confirm.js"></script>
<script language="javascript" src="<?=$js_host;?>/js/web.js"></script>
</body>
</html>