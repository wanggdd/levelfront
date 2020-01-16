<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/phonerent/weui.min.css">
    <link rel="stylesheet" href="/public/css/phonerent/jquery-weui.min.css">
    <title>�ֻ���Ϣ</title>
</head>

<body>

    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�ֻ��ͺ�</label></div>
            <div class="weui-cell__bd">
                <{$phoneInfo.phone_model}>
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�ֻ��ɱ�</label></div>
            <div class="weui-cell__bd">
                <{$phoneInfo.phone_cost}>
            </div>
        </div>
    </div>

    <a href="/dom/PhoneRent/rent.php?phone_id=<{$phoneInfo.id}>&type=list&wap=1" id="show-confirm" class="weui-btn weui-btn_primary" style="margin:15px;">�鿴������Ϣ</a>
    <a href="javascript:;" onclick="del_phone()" id="show-confirm" class="weui-btn weui-btn_warn" style="margin:15px;">ɾ��</a>
    <a href="/dom/PhoneRent/index.php" class="weui-btn weui-btn_warn" style="margin:15px;">����ҳ</a>


    <script src="/public/js/jquery.min.2.1.1.js"></script>
    <script src="/public/js/phonerent/jquery-weui.min.js"></script>

</body>
<script type="text/javascript">
    function del_phone(){
        var phone_model = '<{$phoneInfo.phone_model}>';
        $.confirm({
            title: 'ɾ��',
            text: 'ȷ��ɾ����',
            onOK: function () {
                $.post("/dom/PhoneRent/phone.php",{type:'del',phone_model:phone_model,wap:1},function(data,status){
                    if(data.status=='success'){
                        window.location.href = '/dom/PhoneRent/phone.php';
                    }else{
                        $('#search_rent').submit();
                    }
                });
            },
            onCancel: function () {
            }
        });
    }

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