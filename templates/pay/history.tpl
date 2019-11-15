<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/common/reset.css">
    <link rel="stylesheet" href="/public/css/pay/history.min.css">
    <link rel="stylesheet" href="/public/css/lib/mobileSelect/mobileSelect.css">
    <script src="/public/js/flexible.min.js"></script>
    <title>明细</title>
</head>

<body>
<{include file='../commond/left.tpl'}>
<div id="history">
    <form name="time_form" id="time_form" method="post" action="">
    <div class="top-bar">
        <div class="time">
            <i class="icon-time"></i>
            <span class="text"><i class="time-year"><{$year}></i>年<i class="time-month"><{$month}></i>月</span>
        </div>
        <div class="time-tab">
            <div class="time-tab-item active" id="show_month">按月</div>
            <div class="time-tab-item" id="show_year">按年</div>
        </div>
    </div>
        <input type="hidden" name="year" id="form_year" value="<{$year}>">
        <input type="hidden" name="month" id="form_month" value="<{$month}>">
    </form>
    <div class="container">
        <div class="tab">
            <div class="tab-item active">
                <div class="num"><{$out_sum}></div>
                <div class="text">打款</div>
            </div>
            <div class="tab-item">
                <div class="num"><{$enter_sum}></div>
                <div class="text">收款</div>
            </div>
        </div>
        <div class="list-wrap">
            <div class="list active">
                <{if $out_record}>
                    <{foreach key=key item=item from=$out_record}>
                        <div class="item">
                            <div class="avatar">
                                <img class="avatar__img" src="<{$item.pic}>" alt="">
                            </div>
                            <div class="info">
                                <div class="name">打款给<{$item.enter_user}></div>
                                <div class="task"><{$item.payment_type}></div>
                                <div class="time"><{$item.out_time}></div>
                            </div>
                            <div class="money">-<{$item.payment_money}></div>
                            <i class="icon-right"></i>
                        </div>
                    <{/foreach}>
                <{/if}>
            </div>

            <div class="list">
                <{if $enter_record}>
                    <{foreach key=key item=item from=$enter_record}>
                    <div class="item"onclick="window.open('/dom/NineFenXiao/enter.php?id=<{$item.id}>')">
                        <div class="avatar">
                            <img class="avatar__img" src="<{$item.pic}>" alt="">
                        </div>
                        <div class="info">
                            <div class="name">收款来自<{$item.enter_user}></div>
                            <div class="task"><{$item.payment_type}></div>
                            <div class="time"><{$item.out_time}></div>
                        </div>
                        <div class="money">+<{$item.payment_money}></div>
                        <i class="icon-right"></i>
                    </div>
                    <{/foreach}>
                <{/if}>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/public/js/jquery.min.2.1.1.js"></script>
<script src="/public/css/lib/mobileSelect/mobileSelect.min.js"></script>
<script src="/public/js/history.js"></script>

</html>