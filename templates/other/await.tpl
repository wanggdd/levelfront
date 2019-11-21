<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/common/reset.css">
    <link rel="stylesheet" href="/public/css/other/await.min.css">
    <script src="/public/js/flexible.min.js"></script>
    <title>待办任务</title>
</head>

<body>
<{include file='../commond/left.tpl'}>
<div id="await">
    <div class="form-item" onclick="location='/dom/NineFenXiao/waitout.php?zz_userid=<{$zz_userid}>&username=<{$username}>&wap=1';">
        <div class="form-text">待打款</div>
        <!-- 已上传收款二维码 -->
        <div class="form-inp">
            <span><{$pay_record}></span>
            <i class="icon-right"></i>
        </div>
    </div>
    <div class="form-item" onclick="location='/dom/NineFenXiao/waitenter.php?zz_userid=<{$zz_userid}>&username=<{$username}>&wap=1';">
        <div class="form-text">待收款</div>
        <!-- 已上传收款二维码 -->
        <div class="form-inp">
            <span><{$reward_record}></span>
            <i class="icon-right"></i>
        </div>
    </div>
</div>
<{include file='../commond/footer.tpl'}>