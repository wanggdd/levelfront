<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/common/reset.css">
    <link rel="stylesheet" href="/public/css/userinfo/editinfo.min.css">

    <script src="/public/js/flexible.min.js"></script>
    <title>编辑资料</title>
</head>

<body>
<{include file='../commond/left.tpl'}>
<div id="user">
    <div class="form-item">
        <div class="form-text">头像</div>
        <div class="form-inp">
            <img class="fi_image" src="/public/images/userInfo/icon-avatar.png" alt="">
            <input type="file" class="fi-avatar__file" id="upload_avatar">
        </div>
    </div>
    <div class="form-item">
        <div class="form-text">昵称</div>
        <div class="form-inp">
            <input class="fi-text" type="text" value="中俄混血儿">
        </div>
    </div>
    <div class="form-item">
        <{if $qrcode neq ""}>
        <div class="form-text">收款二维码</div>
        <!-- 已上传收款二维码 -->
        <div class="form-inp">
            <i class="icon-qrcode" id="show_modal"></i>
            <i class="icon-right"></i>
        </div>
        <{else}>
        <!-- 未上传收款二维码 -->
        <div class="form-inp">
            <p class="fi-upload__p">请尽快上传</p>
            <i class="icon-right"></i>
            <input class="fi-qrcode__file" type="file" id="upload_qrcode" onchange="upload_qrcode()">
        </div>
        <{/if}>
    </div>
</div>

<div class="modal">
    <div class="mask close_modal"></div>
    <div class="content">
        <!-- 如果使用上传插件请为img标签加上  -->
        <img class="c-rqcode__img" src="<{$qrcode}>" alt="">
        <p class="c-text__p">
            <a href="javascript:void(0)" onclick="uploadPhoto()">更改收钱二维码</a>
            <input type="file" id="photoFile" style="display: none;" onchange="upload()">
            <img id="preview_photo" src="" width="200px" height="200px">
        </p>
    </div>
</div>
</body>

<script src="/public/js/jquery.min.2.1.1.js"></script>
<script src="/public/js/common.js"></script>
<script src="/public/js/uploader.js"></script>
</html>