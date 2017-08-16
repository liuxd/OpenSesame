(function() {
    var w = window, l = location;
    var url_index = '/', url_list = '/Search/?';

    function create_password(l) {
        var x = '23456789abcdefghijkmnpqrstuvwxyz()', s = '';

        for (var i = 0; i < l; i++) {
            s += x.charAt(Math.ceil(Math.random() * 100000) % x.length);
        }

        return s;
    }

    // Delete button on list page.
    $('.list_del_bt').each(function() {
        var value = $(this).attr('id');

        $($(this)).bind('click', function() {
            $('#pop_confirm').confirmModal({
                heading: 'Boss',
                body: 'Are you sure?',
                enter: 'Yes',
                close: 'No',
                callback: function() {
                    $('#account_id').attr('value', value);
                    $('#del_account').submit();
                }
            });
        });
    });

    // Modify button on detail page.
    $('.info_up_bt').each(function() {
        var field = $(this).attr('title');
        var value = $(this).attr('id');
        var id = $(this).attr('data');

        $($(this)).bind('click', function() {
            $('#field_name_up').prop('value', field);
            $('#field_value_up').prop('value', value);
            $('#field_id_up').prop('value', id);
            $('#modify').modal('show');
        });
    });

    // Button on detail page to show basic information.
    $('#account_base_bt').bind('click', function() {
        $('#modify-base').modal('show');
    });

    // Choose email
    $('.emails').each(function() {
        var email = $(this).attr('data');

        $($(this)).bind('click', function() {
            $('#field_name').prop('value', '邮箱');
            $('#field_value').prop('value', email);
            $('#info_enter').click();
        });
    });

    // Choose password
    $('.default_password').each(function() {
        var default_password = $(this).attr('data');

        $($(this)).bind('click', function() {
            if ($('#field_name').val() === '') {
                $('#field_name').prop('value', '密码');
            }

            $('#field_value').prop('value', default_password);
            $('#info_enter').click();
        });
    });

    // Check button
    $('.info_show_bt').each(function() {
        var value = $(this).attr('id');

        $($(this)).bind('click', function() {
            $('#pop_name').text('CHECK');
            $('#pop_content').text(value);
            $('#popup').modal('show');
        });
    });

    // Copy button
    var clipboard = new Clipboard('.info_copy_bt');

    clipboard.on('success', function(e) {
        $('#pop_name').text('Bingo!');
        $('#pop_content').text('Copy successfully!');
        $('#popup').modal('show');
    });

    // Delete button on detail page
    $('.info_del_bt').each(function() {
        var value = $(this).attr('title');

        $($(this)).bind('click', function() {
            $('#pop_confirm').confirmModal({
                heading: 'Boss',
                body: 'Are you sure?',
                enter: 'Kill it!',
                close: 'NO NO NO',
                callback: function() {
                    $('#field_id').attr('value', value);
                    $('#del_field').submit();
                }
            });
        });
    });

    // Search button
    $('#search_bt').bind('click', function() {
        var key = $('#search').val();
        var url = url_list;

        if (key) {
            url += 'q=' + key;
            l.href = url;
        }
    });

    // Password generating button
    $('#pwd_bt').bind('click', function() {
        var field_name = $('#field_name');
        password = create_password(14);

        if (field_name.val() === '') {
            field_name.attr('value', '密码');
        }

        $('#field_value').prop('value', password);
        $('#info_enter').click();
    });

    // Popup to generate password
    $('#modify_pwd').bind('click', function() {
        password = create_password(14);
        $('#field_value_up').prop('value', password);
    });

    // Show the Add button
    $('#add_pull').bind('click', function() {
        $(this).hide();
        $('#add_input').slideDown();
    });

    // Keyboard event
    var key_combo = [
        {
            keys: '`',
            on_keydown: function() {
                l.replace(url_index);
                ('#search').val('');
            }
        },
        {
            keys: 'enter',
            on_keydown: function() {
                $('#search_bt').click();
            }
        },
        {
            keys: 'alt w',
            on_keydown: function() {
                var url = $('#home_url').attr('href');

                if (url) {
                    w.open(url);
                }
            }
        }
    ];
    keypress.register_many(key_combo);

    $('#search').focus();
})();
