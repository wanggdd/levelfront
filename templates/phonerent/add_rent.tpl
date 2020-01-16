<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/phonerent/weui.min.css">
    <link rel="stylesheet" href="/public/css/phonerent/jquery-weui.min.css">
    <title>添加租赁信息</title>
</head>

<body>
<form name="add_rent" id="add_rent" method="post">
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">手机型号</label></div>
            <div class="weui-cell__bd">
                <{if $type == 'added'}>
                <{$phone_info.phone_model}>
                <{else}>
                <input class="weui-input" name="phone_model" id="phone_model" onblur="check_phone()" placeholder="请输入手机型号">
                <{/if}>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label for="" class="weui-label">租赁开始日期</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input font-input date-input" type="text" data-toggle='date' id="rent_start_time" name="rent_start_time"  placeholder="请选择日期" />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label for="" class="weui-label">租赁结束日期</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input font-input date-input" type="text" data-toggle='date' id="rent_end_time" name="rent_end_time"  placeholder="请选择日期" />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">租赁人</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="rent_name" id="rent_name">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">业务员</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="saler_name" id="saler_name">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">仓管员</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="store_name" id="store_name">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">物流公司</label></div>
            <div class="weui-cell__bd">
                <select class="weui-select" name="express_company" id="express_company">
                    <option value="0">请选择快递公司</option>
                    <{foreach key=key item=item from=$express}>
                    <option value="<{$key}>"><{$item}></option>
                    <{/foreach}>
                </select>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">物流单号</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="express_number" id="express_number">
            </div>
        </div>
        凭证信息：
        <div class="form-inp">
            <p class="fi-upload__p">请尽快上传</p>
            <i class="icon-right"></i>
            <input class="fi-qrcode__file" type="file" id="upload_qrcode" onchange="upload_voucher()">
        </div>
        电子合同：<input class="fi-qrcode__file" type="file" id="upload_e_contract" onchange="upload_contract()"><br>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">租赁平台</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="rent_platform" id="rent_platform">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">单笔租金</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="rent_price" id="rent_price">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">设备折旧率</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="depreciation_price" id="depreciation_price">
            </div>
        </div>
    </div>


    <input type="hidden" name="type" value="add_rent">
    <input type="hidden" name="phone_id" value="<{$phone_info.id}>">
    <{if $type == 'added'}>
    <a href="javascript:;" onclick="check_info2()" class="weui-btn  weui-btn_primary" style="margin:15px;">保存</a>
    <{else}>
    <a href="javascript:;" onclick="check_info()" class="weui-btn  weui-btn_primary" style="margin:15px;">保存</a>
    <{/if}>

    <a href="/dom/PhoneRent/index.php" class="weui-btn weui-btn_warn" style="margin:15px;">回首页</a>
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
            $.toast("请输入手机型号", "forbidden");
            return false;
        }else{
            $.post("/dom/PhoneRent/phone.php",{type:'check_phone',phone_model:phone_model,wap:1},function(data,status){
                if(data.status=='success'){
                    $.toast("手机型号不存在", "forbidden");
                }else{

                }
            });
        }
    }
    function check_info(){
        var phone_model = $('#phone_model').val();
        if($.trim(phone_model) == ''){
            $.toast("请输入手机型号", "forbidden");
            return false;
        }else{
            $.post("/dom/PhoneRent/phone.php",{type:'check_phone',phone_model:phone_model,wap:1},function(data,status){
                if(data.status=='success'){
                    $.toast("手机型号不存在", "forbidden");
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