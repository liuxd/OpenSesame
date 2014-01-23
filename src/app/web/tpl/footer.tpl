<!-- footer -->
<footer class="footer" id="footer">
    <div class="controls-row span12 offset4">
        <div class="span2">
            Powered By <a href="https://github.com/liuxd?tab=repositories" target="_blank">刘喜东</a>
        </div>
        <div class="span2">
            <iframe src="http://ghbtns.com/github-btn.html?user=liuxd&repo=open-sesame&type=fork" allowtransparency="true" frameborder="0" scrolling="0" width="53" height="20"></iframe>
        </div>
    </div>
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
<script language="javascript" src="static/bootstrap/js/plugin/bootstrap-modal.js"></script>
<script language="javascript" src="static/bootstrap/js/plugin/bootstrap-confirm.js"></script>
<script language="javascript" src="static/js/web.js"></script>
</body>
</html>
