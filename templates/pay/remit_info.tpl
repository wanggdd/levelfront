<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/common/reset.css">
    <link rel="stylesheet" href="/public/css/common/pay_info.min.css">
    <script src="/public/js/flexible.min.js"></script>
    <title>����¼</title>
</head>

<body>
<div id="pay">
    <div class="form-group">
        <div class="form-item">
            <div class="text">�տ���</div>
            <div class="value"><{$user_info.nick_name}></div>
        </div>
        <div class="form-item">
            <div class="text">�տ���</div>
            <div class="value">
                <i class="letter">��</i>
                <span class="price"><{$record.payment_money}></span>
            </div>
        </div>
        <div class="form-item">
            <div class="text">�տ�ʱ��</div>
            <div class="value"><{$record.enter_time}></div>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="content-box">
            <div class="title">�տ��˶�ά��</div>
            <div class="content">
                <img class="content__img" src="<{$member.payment_code}>" alt="">
            </div>
        </div>
        <div class="content-box">
            <div class="title">���ƾ֤</div>
            <div class="content">
                <img class="content__img" src="<{$record.payment_voucher}>" alt="">
            </div>
        </div>
        <div class="content-box">
            <div class="title">��ע</div>
            <div class="content">
                <div class="content-remark">
                    <{$record.payment_note}>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group mt20">
        <div class="form-item">
            <div class="text">�ύʱ��</div>
            <div class="value"><{$record.out_time}></div>
        </div>
    </div>
</div>
</body>

<script src="/public/js/jquery.min.2.1.1.js"></script>
<script src="/public/js/common.js"></script>

</html>