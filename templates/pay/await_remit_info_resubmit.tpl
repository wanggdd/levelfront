<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/common/reset.css">
    <link rel="stylesheet" href="/public/css/common/pay_info.min.css">
    <script src="/public/js/flexible.min.js"></script>
    <title>待打款</title>
</head>

<body>
<{include file="../commond/left.tpl"}>
<form method="post" action="/dom/NineFenXiao/waitoutactive.php?zz_userid=<{$zz_userid}>" name="form1" id="form1">
    <div id="pay">
        <div class="form-group">
            <div class="form-item">
                <div class="text">拒绝人</div>
                <div class="value"><{$page_info.nick_name}></div>
            </div>
            <div class="form-item">
                <div class="text">拒绝金额</div>
                <div class="value">
                    <i class="letter">￥</i>
                    <span class="price"><{$page_info.promote_money}></span>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="content-box">
                <div class="title">拒绝人二维码</div>
                <div class="content">
                    <img class="content__img" src="<{$page_info.payment_code}>" alt="">
                </div>
            </div>
            <div class="content-box">
                <div class="title">拒绝原因</div>
                <div class="content">
                    <textarea class="content__textarea" name="payment_note" placeholder="请填写备注"><{$page_info.payment_note}></textarea>
                </div>
            </div>
            <div class="content-box">
                <div class="title">上传打款证明</div>
                <div class="content">
                    <input type="file" id="photoFile" style="display: none;" onchange="upload_voucher()">
                    <img class="c-rqcode__img" src="<{$page_info.payment_voucher}>" id="voucher_photo" onclick="uploadPhoto()">
                    <input type="hidden" id="productImg" name="payment_voucher">
                    <a href="javascript:void(0)" onclick="uploadPhoto()">更换凭证</a>
                </div>
            </div>
            <div class="content-box">
                <div class="title">打款备注</div>
                <div class="content">
                    <textarea class="content__textarea" name="payment_note" placeholder="请填写备注"><{$page_info.payment_note}></textarea>
                </div>
            </div>
        </div>
        <input type="hidden" name="record_id" value="<{$record_id}>">
        <input type="hidden" name="form_submit" value="1">

        <button class="submit-btn center-block" type="button" onclick="check_info()">重新提交</button>
    </div>
</form>

</body>
<script type="text/javascript">
    function check_info(){
        var voucher = $('#productImg').val();

        if(voucher == ''){
            alert('请上传打款凭证');
            return false;
        }else{
            $('#form1').submit();
        }
    }
</script>

<script src="/public/js/jquery.min.2.1.1.js"></script>
<script src="/public/js/common.js"></script>
<script src="/public/js/uploader.js"></script>
</html>