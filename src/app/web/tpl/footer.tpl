<!-- footer -->
<footer class="footer" id="footer">
    <div class="controls-row span12 offset4">
        <div class="span2">
            &copy;<a href="https://github.com/liuxd?tab=repositories" target="_blank">刘喜东</a>
        </div>
    </div>
</footer>

<!--普通内容弹出框-->
<div class="modal" id="popup" style="display:none">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>你要的东西在这里</h3>
    </div>

    <div class="modal-body">
        <p><input id="pop_content" type="text" value="" /></p>
    </div>
</div>

<div id="pop_confirm"></div>
<script language="javascript" src="<?=$host?>static/bootstrap/js/plugin/bootstrap-modal.js"></script>
<script language="javascript" src="<?=$host?>static/bootstrap/js/plugin/bootstrap-confirm.js"></script>
<script language="javascript" src="<?=$host?>static/bootstrap/js/plugin/bootstrap-dropdown.js"></script>
<script language="javascript" src="<?=$host?>static/js/web.js"></script>
</body>
</html>
