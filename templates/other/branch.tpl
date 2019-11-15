<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/common/reset.css">
    <link rel="stylesheet" href="/public/css/other/branch.min.css">
    <script src="/public/js/flexible.min.js"></script>
    <title>我的下级</title>
</head>

<body>

<div id="branch">
  <div class="lower-level">
    <div class="people">
      <span class="num"><{$count}></span>
      <span class="letter">人</span>
    </div>
    <div class="text">下级人数</div>
  </div>
    <{if $lowerList}>
    <ul class="list">
        <{foreach key=key item=item from=$lowerList}>
        <li class="item">
            <div class="avatar">
                <img class="avatar__img" src="<{$item.pic}>" alt="">
            </div>
            <div class="info">
                <div class="name"><{$item.nick_name}></div>
                <div class="time"><{$item.create_time}></div>
            </div>
            <div class="level"><{$item.grade}></div>
        </li>
        <{/foreach}>
    </ul>
    <{/if}>
</div>

<{include file='../commond/footer.tpl'}>