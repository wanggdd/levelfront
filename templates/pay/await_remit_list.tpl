<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="/public/css/common/reset.css">
  <link rel="stylesheet" href="/public/css/pay/await_list.min.css">
  <script src="/public/js/flexible.min.js"></script>
  <title>待打款</title>
</head>

<body>
<{include file="../commond/left.tpl"}>
<div id="pay">
    <ul class="list">
    <{if $status == 1}>
        <{if $task_list1}>
        <li class="item" <{if $task_list1.record_id}>onclick="location='/dom/NineFenXiao/waitoutactive.php?zz_userid=<{$zz_userid}>&record_id=<{$task_list1.record_id}>';"
        <{else}> onclick="location='/dom/NineFenXiao/waitoutactive.php?task_grade=1&enter_member=<{$task_list1.enter_member}>&zz_userid=<{$zz_userid}>&promote_money=<{$task_list1.promote_money}>';"<{/if}>>
            <div class="title">
                <div class="name">激活任务</div>
                <div class="status"><{$task_list1.status_title}></div>
            </div>
            <div class="desc">
                <p>打款给<{$task_list1.nick_name}></p>
            </div>
        </li>
        <{/if}>
        <{if $task_list2}>
        <li class="item" <{if $task_list2.record_id}>onclick="location='/dom/NineFenXiao/waitoutactive.php?zz_userid=<{$zz_userid}>&record_id=<{$task_list2.record_id}>';"
        <{else}> onclick="location='/dom/NineFenXiao/waitoutactive.php?task_grade=2&enter_member=<{$task_list2.enter_member}>&zz_userid=<{$zz_userid}>&promote_money=<{$task_list2.promote_money}>';"<{/if}>>
            <div class="title">
                <div class="name">激活任务</div>
                <div class="status"><{$task_list2.status_title}></div>
            </div>
            <div class="desc">
                <p>打款给<{$task_list2.nick_name}></p>
            </div>
        </li>
        <{/if}>
    <{/if}>
    <{if $status == 2}>
        <{if $task_list}>
        <li class="item" <{if $task_list.record_id}>onclick="location='/dom/NineFenXiao/waitoutup.php?zz_userid=<{$zz_userid}>&record_id=<{$task_list.record_id}>';"
        <{else}> onclick="location='/dom/NineFenXiao/waitoutup.php?task_grade=<{$task_list.task_grade}>&enter_member=<{$task_list.enter_member}>&zz_userid=<{$zz_userid}>&promote_money=<{$task_list.promote_money}>';"<{/if}>>
            <div class="title">
                <div class="name">升级任务</div>
                <div class="status"><{$task_list.status_title}></div>
            </div>
            <div class="desc">
                <p>打款给<{$task_list.nick_name}></p>
            </div>
        </li>
        <{/if}>
    <{/if}>


    </ul>
</div>
<{include file="../commond/footer.tpl"}>