<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/common/reset.css">
    <link rel="stylesheet" href="/public/css/common/test.min.css">
    <link rel="stylesheet" href="/public/css/pay/await_list.min.css">
    <script src="/public/js/flexible.min.js"></script>
    <title>待收款</title>
</head>

<body>
<{include file='../commond/left.tpl'}>
<div id="pay">
    <ul class="list">
        <{if $record_info}>
        <{foreach key=key item=item from=$record_info}>
        <li class="item" onclick="location='/dom/NineFenXiao/waitenterinfo.php?pid=<{$item.id}>';">
            <div class="title">
                <div class="name"><{$item.task_note}></div>
                <div class="status"><{$item.status_word}></div>
            </div>
            <div class="desc">
                <p>打款给<{$nickname}></p>
                <p>上传凭证时间：<{$item.out_time}></p>
            </div>
        </li>
        <{/foreach}>
        <{/if}>
    </ul>
</div>
</body>

<script src="/public/js/jquery.min.2.1.1.js"></script>
<script src="/public/js/common.js"></script>
</html>