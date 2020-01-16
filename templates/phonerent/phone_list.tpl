<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/phonerent/weui.min.css">
    <link rel="stylesheet" href="/public/css/phonerent/jquery-weui.min.css">
    <title>�����ֻ���Ϣ</title>
</head>

<body>

    <{if $phoneList}>
    <div class="weui-cells">
        <{foreach key=key item=item from=$phoneList}>
        <a class="weui-cell weui-cell_access" href="/dom/PhoneRent/phone.php?type=detail&phone_model=<{$item.phone_model}>&wap=1">
            <div class="weui-cell__bd">
                <p>�ֻ��ͺ�: <{$item.phone_model}></p>
            </div>
            <div class="weui-cell__ft">
            </div>
        </a>
        <{/foreach}>
    </div>
    <{else}>
    <div class="weui-cells" style="text-align: center;">�����ֻ���Ϣ</div>
    <{/if}>

    <div style="padding:15px;">
        <a href="/dom/PhoneRent/phone.php?type=add&wap=1" class="weui-btn weui-btn_primary">����ֻ���Ϣ</a>
        <a href="/dom/PhoneRent/index.php" class="weui-btn weui-btn_warn">����ҳ</a>
    </div>
<script src="/public/js/jquery.min.2.1.1.js"></script>

</body>
<script type="text/javascript">
    function form_submit(){
        var phone_model = $('#phone_model').val();
        if($.trim(phone_model) == ''){
            $.toast("�������ֻ��ͺ�", "forbidden");
            return false;
        }else{
            $.post("/dom/PhoneRent/phone.php",{type:'check_phone',phone_model:phone_model,wap:1},function(data,status){
                if(data.status=='success'){
                    $.toast("�ֻ��ͺŲ�����", "forbidden");
                }else{
                    $('#search_rent').submit();
                }
            });
        }

    }
</script>
</html>