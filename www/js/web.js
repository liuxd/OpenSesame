(function() {
    var w = window, l = location;
    var url_index = '?', url_logout = '?type=3&op=logout', url_list = '?op=app_list';

    //UI文本
    var pop_del_head = $('#pop_del_head').val(), pop_del_body = $('#pop_del_body').val();
    var pop_del_info_head = $('#pop_del_info_head').val(), pop_del_info_body = $('#pop_del_info_body').val();
    var pop_logout_head = $('#pop_logout_head').val(), pop_logout_body = $('#pop_logout_body').val();
    var confirm_enter = $('#confirm_enter').val(), confirm_close = $('#confirm_close').val();
    var msg_pwd = $('#msg_pwd').val(), msg_not_empty = $('#msg_not_empty').val();

    //列表页删除按钮
    $('.list_del_bt').each(function() {
        var value = $(this).attr('id');

        $($(this)).bind('click', function() {
            $('#pop_confirm').confirmModal({
                heading: pop_del_head,
                body: pop_del_body,
                enter: confirm_enter,
                close: confirm_close,
                callback: function() {
                    $('#key').attr('value', value);
                    $('#del').submit();
                }
            });
        });
    });

    //单页modify按钮
    $('.info_up_bt').each(function() {
        var key = $(this).attr('title');
        var value = $(this).attr('id');

        $($(this)).bind('click', function() {
            $('#field_name').attr('value', key);
            $('#field_value').attr('value', value);
        });
    });

    //单页copy按钮
    $('.info_copy_bt').each(function() {
        var value = $(this).attr('id');

        $($(this)).bind('click', function() {
            var content = $('#pop_content');
            content.attr('value', value);
            $('#popup').modal('show');
            content.select();
            content.attr('disabled', 'disabled');
        });
    });

    //单页删除按钮
    $('.info_del_bt').each(function() {
        var value = $(this).attr('title');

        $($(this)).bind('click', function() {
            $('#pop_confirm').confirmModal({
                heading: pop_del_info_head,
                body: pop_del_info_body,
                enter: confirm_enter,
                close: confirm_close,
                callback: function() {
                    $('#key').attr('value', value);
                    $('#del').submit();
                }
            });
        });
    });

    //搜索按钮
    $('#search_bt').bind('click', function() {
        var key = $('#search').val();
        var url = url_list;

        if (key) {
            url += '&key=' + key;
            l.href = url;
        }
    });

    //生成密码按钮
    $('#pwd_bt').bind('click', function() {
        var l = 15;
        var x = '0123456789abcdefghijklmnopqrstuvwxyz()', s = '';

        for (var i = 0; i < l; i++) {
            s += x.charAt(Math.ceil(Math.random() * 100000) % x.length);
        }

        $('#field_name').attr('value', msg_pwd);
        $('#field_value').attr('value', s);
    });

    //退出按钮
    $('#logout_bt').bind('click', function() {
        $('#pop_confirm').confirmModal({
            heading: pop_logout_head,
            body: pop_logout_body,
            enter: confirm_enter,
            close: confirm_close,
            callback: function() {
                $.ajax({
                    url: url_logout,
                    success: function(){
                        l.reload();
                    }
                });
            }
        });
    });

    //键盘事件
    var key_combo = [
        {
            keys: '`',
            on_keydown: function() {
                l.replace(url_index);
            },
        },
        {
            keys: 'enter',
            on_keydown: function() {
                $('#search_bt').click();
            },
        },
    ];
    keypress.register_many(key_combo);

    //首页搜索框自动获得焦点。
    $('#search').focus();

    //单页name框自动获得焦点。
    $('#field_name').focus();
})();
