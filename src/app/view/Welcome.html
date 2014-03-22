<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Valar Morghulis</title>
        <link rel="shortcut icon" href="<?=$host?>static/application/img/web.png" />
        <script language="javascript" src="<?=$host?>static/vendor/jquery/jquery.min.js"></script>
    </head>
    <body>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        canvas {
            display: block;
        }
    </style>
    <canvas id="matrix"></canvas>
    <script language="javascript">
        var c = document.getElementById("matrix");
        var ctx = c.getContext("2d");

        //全屏
        c.height = window.innerHeight;
        c.width = window.innerWidth;

        //文字
        var txts = "0123456789abcdefghigklmgopqrstuvwxyz";
        //转为数组
        txts = txts.split("");

        var font_size = 16;
        var columns = c.width / font_size;
        //用于计算输出文字时坐标，所以长度即为列数
        var drops = [];
        //初始值
        for (var x = 0; x < columns; x++)
            drops[x] = 1;

        //输出文字
        function draw()
        {
            //让背景逐渐由透明到不透明
            ctx.fillStyle = "rgba(0, 0, 0, 0.05)";
            ctx.fillRect(0, 0, c.width, c.height);

            ctx.fillStyle = "#0F0"; //文字颜色
            ctx.font = font_size + "px arial";
            //逐行输出文字
            for (var i = 0; i < drops.length; i++)
            {
                //随机取要输出的文字
                var text = txts[Math.floor(Math.random() * txts.length)];
                //输出文字，注意坐标的计算
                ctx.fillText(text, i * font_size, drops[i] * font_size);

                //如果绘满一屏或随机数大于0.95（此数可自行调整，效果会不同）
                if (drops[i] * font_size > c.height || Math.random() > 0.95)
                    drops[i] = 0;

                //用于Y轴坐标增加
                drops[i]++;
            }
        }

        setInterval(draw, 40);

        c.onclick = function() {
            $.ajax({
                url: '<?=$auth_url;?>',
                type: 'GET',
                dataType: 'json',
                timeout: 3000,
                error: function() {
                    //alert('request failed!');
                },
                success: function(data) {
                    if (data.result == 1) {
                        location.href = 'http://' + location.host;
                    }
                },
            });
        }


        //title闪烁
        var flashTitlePlayer = {
            start: function(msg) {
                this.title = document.title;
                if (!this.action) {
                    try {
                        this.element = document.getElementsByTagName('title')[0];
                        this.element.innerHTML = this.title;
                        this.action = function(ttl) {
                            this.element.innerHTML = ttl;
                        }
                    } catch (e) {
                        this.action = function(ttl) {
                            document.title = ttl;
                        }
                        delete this.element;
                    } 
                    this.toggleTitle = function() {
                        this.action("【" + this.messages[this.index = this.index == 0 ? 1 : 0] + "】");
                    };
                }

                if (typeof msg !== 'string') {
                    msg += "";
                }

                this.messages = [msg];
                var n = msg.length;
                var s = '';

                if (this.element) {
                    var num = msg.match(/\w/g);
                    if (num != null) {
                        var n2 = num.length;
                        n -= n2;
                        while (n2 > 0) {
                            s += "&nbsp;";
                            n2--;
                        }
                    }
                }
                while (n > 0) {
                    s += ' ';
                    n--;
                }
                this.messages.push(s);
                this.index = 0;
                this.timer = setInterval(function(){
                    flashTitlePlayer.toggleTitle();
                }, 1000);
            },
            stop: function() {
                if (this.timer) {
                    clearInterval(this.timer);
                    this.action(this.title);
                    delete this.timer;
                    delete this.messages;
                }
            }
        };

        flashTitlePlayer.start('Valar Morghulis');
    </script>
</body>
</html>
