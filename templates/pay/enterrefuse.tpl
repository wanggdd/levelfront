<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/common/reset.css">
    <link rel="stylesheet" href="/public/css/common/pay_info.min.css">
    <script src="/public/js/flexible.min.js"></script>
    <title>已拒绝</title>
</head>

<body>
<{include file='../commond/left.tpl'}>
<div id="pay">
    <div class="form-group">
        <div class="form-item">
            <div class="text">打款人</div>
            <div class="value"><{$out_name}></div>
        </div>
        <div class="form-item">
            <div class="text">拒绝金额</div>
            <div class="value">
                <i class="letter"></i>
                <span class="price"><{$record.payment_money}></span>
            </div>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="content-box">
            <div class="title">拒绝原因</div>
            <div class="content">
                <div class="content-remark">
                    <{$record.refuse_reason}>
                </div>
            </div>
        </div>
        <div class="content-box">
            <div class="title">打款凭证</div>
            <div class="content">
                <img class="content__img" src="<{$record.payment_voucher}>" alt="">
            </div>
        </div>
    </div>
    <div class="form-group mt20">
        <div class="form-item">
            <div class="text">拒绝时间</div>
            <div class="value"><{$record.refuse_time|date_format:'%Y-%m-%d'}></div>
        </div>
    </div>
</div>
</body>

<script src="/public/js/jquery.min.2.1.1.js"></script>
<script src="/public/js/common.js"></script>
</html>