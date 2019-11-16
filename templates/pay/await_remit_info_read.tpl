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
    <div id="pay">
        <div class="form-group">
            <div class="form-item">
                <div class="text">待收款人</div>
                <div class="value"><{$page_info.nick_name}></div>
            </div>
            <div class="form-item">
                <div class="text">待打款金额</div>
                <div class="value">
                    <i class="letter">￥</i>
                    <span class="price"><{$page_info.promote_money}></span>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="content-box">
                <div class="title">收款人二维码</div>
                <div class="content">
                    <img class="content__img" src="<{$page_info.payment_code}>" alt="">
                </div>
            </div>
            <div class="content-box">
                <div class="title">打款证明</div>
                <div class="content">
                    <img class="c-rqcode__img" src="<{$page_info.payment_voucher}>">
                </div>
            </div>
            <div class="content-box">
                <div class="title">打款备注</div>
                <div class="content">
                    <p class="content__textarea" name="payment_note"><{$page_info.payment_note}></p>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-item">
                <div class="text">提交时间</div>
                <div class="value"><{$page_info.out_time}></div>
            </div>
        </div>
    </div>

</body>

<script src="/public/js/jquery.min.2.1.1.js"></script>
<script src="/public/js/common.js"></script>
<script src="/public/js/uploader.js"></script>
</html>