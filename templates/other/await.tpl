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
<div id="await">
    <div class="form-item">
        <div class="form-text">待打款</div>
        <!-- 已上传收款二维码 -->
        <div class="form-inp">
            <span><{$pay_record}></span>
            <i class="icon-right"></i>
        </div>
    </div>
    <div class="form-item">
        <div class="form-text">待收款</div>
        <!-- 已上传收款二维码 -->
        <div class="form-inp">
            <span><{$reward_record}></span>
            <i class="icon-right"></i>
        </div>
    </div>
</div>
</body>

</html>