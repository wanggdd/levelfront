<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/common/reset.css">
    <link rel="stylesheet" href="/public/css/common/pay_info.min.css">
    <script src="/public/js/flexible.min.js"></script>
    <title>��ȷ���տ�</title>
</head>

<body>
<{include file='../commond/left.tpl'}>
<div id="pay">
    <div class="form-group">
        <div class="form-item">
            <div class="text">�����</div>
            <div class="value"><{$out_name}></div>
        </div>
        <div class="form-item">
            <div class="text">�����</div>
            <div class="value">
                <i class="letter"></i>
                <span class="price"><{$record.payment_money}></span>
            </div>
        </div>
        <div class="form-item">
            <div class="text">���ʱ��</div>
            <div class="value"><{$record.out_time|date_format:'%Y-%m-%d'}></div>
        </div>
    </div>
    <div class="content-wrapper">
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
        <div class="content-box mb120">
            <div class="title">�տ��˶�ά��</div>
            <div class="content">
                <img class="content__img" src="<{$pay_qrcode}>" alt="">
            </div>
        </div>
    </div>

    <div class="handle-btns">
        <div class="refuse-btn" onclick="location='/dom/ninefenxiao/refuseinfo.php?pid=<{$record.id}>'">�ܾ��տ�</a></div>
        <div class="confirm-btn" id="show_modal">ȷ���տ�</div>
    </div>
</div>

<div class="modal">
    <div class="mask close_modal"></div>
    <div class="content">
        <div class="content-wrning">��ϸ��֤ƾ֤�����⣬ȷ�ϲ������޷������¼����ݴ˲�����ɹ������ȼ�</div>
        <!-- �رյ������������ĵط����� close_modal -->
        <div class="content-btns">
            <div class="cancel-btn close_modal">ȡ��</div>
            <div class="confirm-btn close_modal" onclick="confirm_commit(<{$record.id}>)">ȷ��</div>
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
                alert('�ύ����,������');
            }
        });

    }

</script>

</html>