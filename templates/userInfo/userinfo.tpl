<{include file='../commond/head.tpl'}>

<{include file='../commond/left.tpl'}>
<div id="user">
    <div class="info">
        <div class="avatar">
            <img class="avatar-image" src="<{$zz_user_info.user_user_head_pic}>" alt="">
            <a href="/dom/NineFenXiao/myinfo.php?zz_userid=<{$zz_user_info.id}>"><img class="write-image" src="/public/images/userInfo/icon-write.png" alt=""></a>
        </div>
        <div class="desc">
            <div class="d-top">
                <div class="name"><{$zz_user_info.user_user_nick_name}></div>
                <{if $zz_user_info.grade_title}>
                    <div class="level"><{$zz_user_info.grade_title}></div>
                <{/if}>
            </div>
            <div class="d-up">�ҵ��ϼ���<{$zz_user_info.higher_user}></div>
        </div>
    </div>
    <div class="handles">
        <!--
        δ������Ѽ������������ͼ��
        -->
        <{if $current_member.status==1 || $current_member.status==2}>
        <div class="item" onclick="location='/dom/NineFenXiao/mytask.php?zz_userid=<{$zz_user_info.id}>';">
            <img class="icon-pending" src="/public/images/userInfo/icon-pending.png" alt="">
            <p>�ҵĴ���</p>
        </div>
        <div class="item" onclick="location='/dom/NineFenXiao/finance.php?zz_userid=<{$zz_user_info.id}>';">
            <img class="icon-money" src="/public/images/userInfo/icon-money.png" alt="">
            <p>��������</p>
        </div>
        <{/if}>
        <!--
        �Ѽ������������ͼ��-->

        <{if $current_member.status==2}>
        <div class="item" onclick="location='/dom/NineFenXiao/mylower.php?zz_userid=<{$zz_user_info.id}>';">
            <img class="icon-branch" src="/public/images/userInfo/icon-branch.png" alt="">
            <p>�ҵ��¼�</p>
        </div>
        <div class="item" onclick="location='/dom/NineFenXiao/invite.php?zz_userid=<{$zz_user_info.id}>';">
            <img class="icon-share" src="/public/images/userInfo/icon-share.png" alt="">
            <p>�������</p>
        </div>
        <{/if}>
    </div>
</div>

<{include file='../commond/footer.tpl'}>