<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/phonerent/weui.min.css">
    <link rel="stylesheet" href="/public/css/phonerent/jquery-weui.min.css">
    <title>���������Ϣ</title>
</head>

<body>
<form name="add_rent" id="add_rent" method="post">
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�ֻ��ͺ�</label></div>
            <div class="weui-cell__bd">
                <{if $type == 'added'}>
                <{$phone_info.phone_model}>
                <{else}>
                <input class="weui-input" name="phone_model" id="phone_model" onblur="check_phone()" placeholder="�������ֻ��ͺ�">
                <{/if}>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label for="" class="weui-label">���޿�ʼ����</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input font-input date-input" type="text" data-toggle='date' id="rent_start_time" name="rent_start_time"  placeholder="��ѡ������" />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label for="" class="weui-label">���޽�������</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input font-input date-input" type="text" data-toggle='date' id="rent_end_time" name="rent_end_time"  placeholder="��ѡ������" />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">������</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="rent_name" id="rent_name">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">ҵ��Ա</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="saler_name" id="saler_name">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�ֹ�Ա</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="store_name" id="store_name">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">������˾</label></div>
            <div class="weui-cell__bd">
                <select class="weui-select" name="express_company" id="express_company">
                    <option value="0">��ѡ���ݹ�˾</option>
                    <{foreach key=key item=item from=$express}>
                    <option value="<{$key}>"><{$item}></option>
                    <{/foreach}>
                </select>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">��������</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="express_number" id="express_number">
            </div>
        </div>
        ƾ֤��Ϣ��
        <div class="form-inp">
            <p class="fi-upload__p">�뾡���ϴ�</p>
            <i class="icon-right"></i>
            <input class="fi-qrcode__file" type="file" id="upload_qrcode" onchange="upload_voucher()">
        </div>
        ���Ӻ�ͬ��<input class="fi-qrcode__file" type="file" id="upload_e_contract" onchange="upload_contract()"><br>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">����ƽ̨</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="rent_platform" id="rent_platform">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�������</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="rent_price" id="rent_price">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�豸�۾���</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="depreciation_price" id="depreciation_price">
            </div>
        </div>
    </div>


    <input type="hidden" name="type" value="add_rent">
    <input type="hidden" name="phone_id" value="<{$phone_info.id}>">
    <{if $type == 'added'}>
    <a href="javascript:;" onclick="check_info2()" class="weui-btn  weui-btn_primary" style="margin:15px;">����</a>
    <{else}>
    <a href="javascript:;" onclick="check_info()" class="weui-btn  weui-btn_primary" style="margin:15px;">����</a>
    <{/if}>

    <a href="/dom/PhoneRent/index.php" class="weui-btn weui-btn_warn" style="margin:15px;">����ҳ</a>
</form>

<script src="/public/js/jquery.min.2.1.1.js"></script>
<script src="/public/js/phonerent_uploader.js"></script>
<script src="/public/js/phonerent/jquery-weui.min.js"></script>
<script src="/public/js/phonerent/fastclick.js"></script>
</body>

<script type="text/javascript">
    $("#rent_start_time").calendar();
    $("#rent_end_time").calendar();
    function check_phone(){
        var phone_model = $('#phone_model').val();
        if($.trim(phone_model) == ''){
            $.toast("�������ֻ��ͺ�", "forbidden");
            return false;
        }else{
            $.post("/dom/PhoneRent/phone.php",{type:'check_phone',phone_model:phone_model,wap:1},function(data,status){
                if(data.status=='success'){
                    $.toast("�ֻ��ͺŲ�����", "forbidden");
                }else{

                }
            });
        }
    }
    function check_info(){
        var phone_model = $('#phone_model').val();
        if($.trim(phone_model) == ''){
            $.toast("�������ֻ��ͺ�", "forbidden");
            return false;
        }else{
            $.post("/dom/PhoneRent/phone.php",{type:'check_phone',phone_model:phone_model,wap:1},function(data,status){
                if(data.status=='success'){
                    $.toast("�ֻ��ͺŲ�����", "forbidden");
                }else{
                    $('#add_rent').submit();
                }
            });
        }
    }
    function check_info2(){
        $('#add_rent').submit();
    }
</script>
</html>