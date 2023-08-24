<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"/www/wwwroot/wk.winxx.cc/public/../application/index/view/index/buy.html";i:1616851394;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1,user-scalable=no">

    <title>自助购买USDT</title>

    <link href="/assets/libs/layui/css/layui.css" rel="stylesheet">
    <link href="/assets/css/sell.css" rel="stylesheet">
</head>
<body>

<div class="layui-form" id="form1" lay-filter="form1">
    <div id="toptitle" style="margin-top: 0;">
        <h1 class="htitle" id="htitle"><a href="<?php echo url('sell'); ?>" class="layui-btn layui-btn-primary">出售</a><a href="javascript:void(0)" class="layui-btn">购买</a></h1>
    </div>

    <div class="divContent">
        <div id="divDesc" class="formfield">
            <span class="description"><?php echo $site['desc_top']; ?></span>
        </div>

        <div class="divDesc">
            <div style="margin:7px 12px;">
                <?php echo $site['desc_center']; ?>
            </div>
        </div>

        <div class="field">
            <div class="field-label">1. 您要购买USDT总金额【标价<label id="b-money_num"><?php echo $site['buy_money']; ?></label>CNY】<span class="req">*</span></div>

            <div class="ui-controlgroup">
                <!--<div class="layui-form-item">-->
                <!--    <input type="radio" name="money_type" lay-filter="money_type" value="1" title="1000 CNY" onclick="radio()" checked>-->
                <!--</div>-->
                <div class="layui-form-item">
                    <label class="layui-form-label">数量</label>
                    <input type="hidden" name="money_type" lay-filter="money_type" value="0" title="自定义" checked>
                    <input type="number" id="c-money" name="money" required  lay-verify="money" autocomplete="off" class="layui-input">
                    <input type="hidden" id="c-money_num" name="money_num" value="<?php echo $site['buy_money']; ?>" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">总金额（CNY）</label>
                    <input type="number" id="c-money_count" name="money_count" value="" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>

        <div class="field">
            <div class="field-label">2. 您支付的账户<span class="req">*</span></div>

            <div class="ui-controlgroup">
                <div class="layui-form-item">
                    <label class="layui-form-label">姓名</label>
                    <input type="text" name="bank_account" required lay-verify="bank_account" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">账户</label>
                    <input type="text" name="bank_card" required lay-verify="bank_card" autocomplete="off" class="layui-input">
                </div>
            </div>

        </div>

        <div class="field">
            <div class="field-label">3. 您的收币地址【USDT- TRC20】<span class="req">*</span></div>

            <div class="ui-controlgroup">
                <div class="layui-form-item">
                    <label class="layui-form-label">USDT地址</label>
                    <input type="text" name="address" required lay-verify="address" autocomplete="off" class="layui-input">
                </div>
            </div>

        </div>

        <div class="divDesc">
            <div style="margin:7px 12px;">
                <?php echo $site['desc_bottom']; ?>
            </div>
        </div>

        <div class="layui-form-item">
            <button class="layui-btn layui-btn-normal layui-btn-fluid" lay-submit lay-filter="formDemo">提交</button>
        </div>
    </div>
</div>

<script src="/assets/libs/layui/layui.js"></script>
<script>

    </script>
<script>
    //Demo
    layui.use(['form', 'jquery','layer'], function(){
        var form = layui.form
        , $ = layui.$
        , layer = layui.layer;

        var sell = <?php echo json_encode($site['buy_money_array']); ?>;
        var co = {};
        $.each(sell, function(index, value) {
            var arr = index.split('_');
            if (arr.length > 1) {
                console.log(arr)
                co[xxx(arr[0], value) + '_' + xxx(arr[1], value)] = value
            } else {
                co[xxx(value, index)] = value
            }
        })

        $('#c-money').on('input propertychange', function() {
            var data = parseFloat($(this).val());
            $.each(sell, function(index, value) {
                var arr = index.split('_');
                var a = parseInt(arr[0])
                if (arr.length > 1) {
                    var b = parseInt(arr[1])
                    if (data > a && b >= data) {
                        $('#c-money_num').val(value)
                        $('#b-money_num').html(value)
                        $('#c-money_count').val(xxx(data, value))
                    }
                } else {
                    if (data > a) {
                        $('#c-money_num').val(value)
                        $('#b-money_num').html(value)
                        $('#c-money_count').val(xxx(data, value))
                    }
                }
            })
        });
        
        $('#c-money_count').on('input propertychange', function() {
            var data = parseFloat($(this).val());
            $.each(co, function(index, value) {
                var arr = index.split('_');
                var a = parseInt(arr[0])
                if (arr.length > 1) {
                    var b = parseInt(arr[1])
                    if (data > a && b >= data) {
                        $('#c-money_num').val(value)
                        $('#b-money_num').html(value)
                        $('#c-money').val(numDiv(data, value))
                    }
                } else {
                    if (data > a) {
                        $('#c-money_num').val(value)
                        $('#b-money_num').html(value)
                        $('#c-money').val(numDiv(data, value))
                    }
                }
            })
        });
        
        function xxx(val, ds) {
            var ss = 10000;
            return (val * ss) * (ds * ss) / (ss * ss);
        }
        
        function numDiv(num1, num2) {
            var baseNum1 = 0, baseNum2 = 0;
            var baseNum3, baseNum4;
            try {
                baseNum1 = num1.toString().split(".")[1].length;
            } catch (e) {
                baseNum1 = 0;
            }
            try {
                baseNum2 = num2.toString().split(".")[1].length;
            } catch (e) {
                baseNum2 = 0;
            }
            with (Math) {
                baseNum3 = Number(num1.toString().replace(".", ""));
                baseNum4 = Number(num2.toString().replace(".", ""));
                return ((baseNum3 / baseNum4) * pow(10, baseNum2 - baseNum1)).toFixed(2);
            }
        }
    
        form.on('radio(money_type)', function(data){
          console.log(data.elem); //得到radio原始DOM对象
          console.log(data.value); //被点击的radio的value值
        }); 

        form.verify({
            money: function (value, item) {
                var data = form.val("form1");
                if (data.money_type === "0" && value.length === 0) {
                    return '请输入自定义金额';
                }
            },
            bank_account: function (value) {
                if (value.length <= 0) {
                    return '姓名不可为空';
                }
                if (!new RegExp("^[\u4E00-\u9FA5]+$").test(value)) {
                    return '请输入正确姓名';
                }
            },
            bank_card: function (value) {
                if (value.length <= 0) {
                    return '账户不可为空';
                }
            },
            address: function (value) {
                if (value.length <= 0) {
                    return '收币地址不可为空';
                }
            }
        });
        //监听提交
        form.on('submit(formDemo)', function(data){
            $.ajax({
                type: "POST",
                url: "<?php echo url('buy'); ?>",
                data: data.field,
                dataType: "json",
                success: function(data){
                    if (data.code === 1) {
                        layer.msg('提交成功，请等待审核')
                    } else {
                        layer.msg(data.msg)
                    }
                }
            });
            return false;
        });
    });
</script>

</body>
</html>
