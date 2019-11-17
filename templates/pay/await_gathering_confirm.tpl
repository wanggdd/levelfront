<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/common/reset.css">
    <link rel="stylesheet" href="/public/css/common/pay_info.min.css">
    <script src="/public/js/flexible.min.js"></script>
    <title>待确认收款</title>
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
            <div class="text">打款金额</div>
            <div class="value">
                <i class="letter"></i>
                <span class="price"><{$record.payment_money}></span>
            </div>
        </div>
        <div class="form-item">
            <div class="text">打款时间</div>
            <div class="value"><{$record.out_time|date_format:'%Y-%m-%d'}></div>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="content-box">
            <div class="title">打款凭证</div>
            <div class="content">
                <img class="content__img" src="<{$record.payment_voucher}>" alt="">
            </div>
        </div>
        <div class="content-box">
            <div class="title">打款备注</div>
            <div class="content">
                <div class="content-remark">
                    <{$record.payment_note}>
                </div>
            </div>
        </div>
        <div class="content-box mb120">
            <div class="title">收款人二维码</div>
            <div class="content">
                <img class="content__img" src="<{$pay_qrcode}>" alt="">
            </div>
        </div>
    </div>

    <div class="handle-btns">
        <div class="refuse-btn" onclick="location='/dom/ninefenxiao/refuseinfo.php?pid=<{$record.id}>'">拒绝收款</a></div>
        <div class="confirm-btn" id="show_modal">确认收款</div>
    </div>
</div>

<div class="modal">
    <div class="mask close_modal"></div>
    <div class="content">
        <div class="content-wrning">仔细查证凭证无问题，确认操作后无法撤回下级根据此操作会成功晋升等级</div>
        <!-- 关闭弹窗，在想点击的地方加上 close_modal -->
        <div class="content-btns">
            <div class="cancel-btn close_modal">取消</div>
            <div class="confirm-btn close_modal" onclick="confirm_commit(<{$record.id}>)">确认</div>
        </div>
    </div>
</div>
</body>

<script src="/public/js/jquery.min.2.1.1.js"></script>
<script src="/public/js/common.js"></script>
<script>
    function confirm_commit(payment_id) {
        var user_id = <{$user_id}>;
        $.post("/dom/NineFenXiao/waitenterinfo.php",{pid:payment_id,type:'confirm'},function(data,status){
            if(data.status=='success'){
                window.location.reload();
            }else{
                alert('提交错误,请重试');
            }
        });

    }

</script>

</html>