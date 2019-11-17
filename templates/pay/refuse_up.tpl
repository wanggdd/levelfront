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
<{include file="../commond/left.tpl"}>
<form method="post" action="/dom/NineFenXiao/waitoutup.php?zz_userid=<{$zz_userid}>" name="form1" id="form1">
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
                    <div class="content-remark">
                        <{$page_info.refuse_reason}>
                    </div>
                </div>
            </div>
            <div class="content-box">
                <div class="title">打款凭证</div>
                <div class="content">
                    <img class="c-rqcode__img" src="<{$page_info.payment_voucher}>" alt="" id="voucher_photo">
                    <div class="content-again">
                        <input type="file" id="photoFile" style="display: none;" onchange="upload_voucher()">
                        <span class="again-text" onclick="uploadPhoto()">更换凭证</span>
                        <input type="hidden" id="productImg" name="payment_voucher" value="<{$page_info.payment_voucher}>">
                    </div>
                </div>
            </div>
            <div class="content-box">
                <div class="title">打款备注</div>
                <div class="content">
                    <textarea class="content__textarea" placeholder="请填写备注" name="payment_note"><{$page_info.payment_note}></textarea>
                </div>
            </div>
        </div>
        <div class="form-group mt20">
            <div class="form-item">
                <div class="text">提交时间</div>
                <div class="value"><{$page_info.out_time}></div>
            </div>
        </div>
        <input type="hidden" name="record_id" value="<{$record_id}>">
        <input type="hidden" name="form_submit" value="2">
        <input type="hidden" name="task_grade" value="<{$page_info.task_grade}>">
        <input type="hidden" name="promote_money" value="<{$page_info.promote_money}>">
        <input type="hidden" name="enter_member" value="<{$page_info.enter_member}>">
        <button class="submit-btn center-block" type="submit">重新提交</button>
    </div>
</form>

</body>

<script src="/public/js/jquery.min.2.1.1.js"></script>
<script src="/public/js/common.js"></script>
<script src="/public/js/uploader.js"></script>
</html>