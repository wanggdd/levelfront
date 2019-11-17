<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/common/reset.css">
    <link rel="stylesheet" href="/public/css/common/pay_info.min.css">
    <script src="/public/js/flexible.min.js"></script>
    <title>拒绝收款原因</title>
</head>

<body>
<{include file='../commond/left.tpl'}>
<div id="pay">
    <form method="post" id="myform">
    <div class="content-wrapper">
        <div class="content-box">
            <div class="title">拒绝原因</div>

            <div class="content">
                <input type="hidden" name="pid" value="<{$pid}>">
                <textarea class="content__textarea" placeholder="请填写备注" name="refuse_reason"></textarea>
            </div>
        </div>
    </div>
    <div class="handle-btns">
        <div class="refuse-btn">返回</div>
        <div class="confirm-btn" onclick="form_submit()">确认</div>
    </div>
    </form>
</div>
</body>
<script src="/public/js/jquery.min.2.1.1.js"></script>
<script>
    function form_submit(){
        $("#myform").submit();
    }

</script>

</html>