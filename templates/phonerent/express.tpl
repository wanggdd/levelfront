<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/phonerent/weui.min.css">
    <link rel="stylesheet" href="/public/css/phonerent/jquery-weui.min.css">
    <title>快递信息</title>
</head>

<body>

<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">物流状态</label></div>
        <div class="weui-cell__bd">
            <{$status}>
        </div>
    </div>

    <{if $data}>
    <div style="padding: 15px;">
        <{foreach key=key item=item from=$data}>
            <div style="margin-bottom: 4px;">
                <div><{$item.context}></div>
                <div style="font-size: 12px;"><{$item.time}></div>
            </div>
        <{/foreach}>
    </div>
    <{/if}>

</div>


</html>