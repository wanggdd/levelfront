<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/phonerent/weui.min.css">
    <link rel="stylesheet" href="/public/css/phonerent/jquery-weui.min.css">
    <title>租赁信息</title>
</head>

<body>

    <div style="text-align: center;">手机型号：<{$phone_info.phone_model}></div>
    <{if $rentList}>
    <div class="weui-cells">
        <{foreach key=key item=item from=$rentList}>
        <a class="weui-cell weui-cell_access" href="/dom/PhoneRent/search.php?type=detail&rent_id=<{$item.id}>&wap=1">
            <div class="weui-cell__bd">
                <p>租赁日期: <{$item.rent_start_time}> - <{$item.rent_end_time}></p>
            </div>
            <div class="weui-cell__ft">
            </div>
        </a>
        <{/foreach}>
    </div>
    <{else}>
    <div style="text-align: center;margin:15px;">暂无租赁信息</div>
    <{/if}>

    <div style="padding:15px;">
        <a href="/dom/PhoneRent/rent.php?type=added&phone_id=<{$phone_id}>&wap=1" class="weui-btn weui-btn_primary">添加租赁信息</a>
        <a href="/dom/PhoneRent/index.php" class="weui-btn weui-btn_warn">回首页</a>
    </div>

<script src="/public/js/jquery.min.2.1.1.js"></script>

</body>
<script type="text/javascript">
    function form_submit(){
        var phone_model = $('#phone_model').val();
        if($.trim(phone_model) == ''){
            $.toast("请输入手机型号", "forbidden");
            return false;
        }else{
            $.post("/dom/PhoneRent/phone.php",{type:'check_phone',phone_model:phone_model,wap:1},function(data,status){
                if(data.status=='success'){
                    $.toast("手机型号不存在", "forbidden");
                }else{
                    $('#search_rent').submit();
                }
            });
        }

    }
</script>
</html>