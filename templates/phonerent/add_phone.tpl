<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/phonerent/weui.min.css">
    <link rel="stylesheet" href="/public/css/phonerent/jquery-weui.min.css">

    <title>����ֻ���Ϣ</title>
</head>

<body>

<form name="add_phone" id="add_phone" method="post">
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�ֻ��ͺ�</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="phone_model" id="phone_model" placeholder="�������ֻ��ͺ�" onblur="check_phone()">
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�ֻ��ɱ���</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="phone_cost" id="phone_cost" placeholder="����С�������λ">
            </div>
        </div>
    </div>
    <input type="hidden" name="type" value="add_phone">
    <a href="javascript:;" onclick="check_info()" class="weui-btn  weui-btn_primary" style="margin:15px;">����</a>
    <a href="/dom/PhoneRent/index.php" class="weui-btn weui-btn_warn" style="margin:15px;">����ҳ</a>
</form>

</body>
<script src="/public/js/jquery.min.2.1.1.js"></script>
<script src="/public/js/phonerent/jquery-weui.min.js"></script>

<script type="text/javascript">
    function check_phone(){
        var phone_model = $('#phone_model').val();
        if($.trim(phone_model) == ''){
            $.toast("�������ֻ��ͺ�", "forbidden");
            return false;
        }
        $.post("/dom/PhoneRent/phone.php",{type:'check_phone',phone_model:phone_model,wap:1},function(data,status){
            if(data.status=='success'){
                //
            }else{
                $.toast("�ֻ��ͺ��ظ�", "forbidden");
            }
        });
    }
    function check_info(){
        var phone_model = $('#phone_model').val();
        var phone_cost = $('#phone_cost').val();
        if($.trim(phone_model) == ''){
            $.toast("�������ֻ��ͺ�", "forbidden");
            return false;
        }
        if($.trim(phone_cost) == ''){
            $.toast("������ɱ�", "forbidden");
            return false;
        }
        $.post("/dom/PhoneRent/phone.php",{type:'check_phone',phone_model:phone_model,wap:1},function(data,status){
            if(data.status=='success'){
                $('#add_phone').submit();
            }else{
                $.toast("�ֻ��ͺ��ظ�", "forbidden");
            }
        });
    }
</script>
</html>