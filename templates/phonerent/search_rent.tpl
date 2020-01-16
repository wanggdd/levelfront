<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/phonerent/weui.min.css">
    <link rel="stylesheet" href="/public/css/phonerent/jquery-weui.min.css">
    <title>��ѯ</title>
</head>

<body>
<{if $type=='list'}>
<form name="search_rent" id="search_rent" method="post">
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�ֻ��ͺ�</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="phone_model" id="phone_model" placeholder="�������ֻ��ͺ�">
            </div>
        </div>

    </div>
    <input type="hidden" name="type" value="search">
    <a href="javascript:;" onclick="form_submit()" class="weui-btn weui-btn_primary" style="margin:15px;">����</a>
    <a href="/dom/PhoneRent/index.php" class="weui-btn weui-btn_warn" style="margin:15px;">����ҳ</a>
</form>
<{/if}>
<{if $type=='search'}>
    <{if $rent_list}>
    <div class="weui-cells">
        <{foreach key=key item=item from=$rent_list}>
        <a class="weui-cell weui-cell_access" href="/dom/PhoneRent/search.php?type=detail&rent_id=<{$item.id}>&wap=1">
            <div class="weui-cell__bd">
                <p>��������: <{$item.rent_start_time}> - <{$item.rent_end_time}></p>
            </div>
            <div class="weui-cell__ft">
            </div>
        </a>
        <{/foreach}>
    </div>
    <a href="/dom/PhoneRent/index.php" class="weui-btn weui-btn_warn" style="margin:15px;">����ҳ</a>
    <{else}>
    <div style="text-align: center;margin:15px;">��������Ϣ,�����²���</div>
    <form name="search_rent" id="search_rent" method="post">
        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">�ֻ��ͺ�</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" name="phone_model" id="phone_model" placeholder="�������ֻ��ͺ�">
                </div>
            </div>

        </div>
        <input type="hidden" name="type" value="search">
        <a href="javascript:;" onclick="form_submit()" class="weui-btn weui-btn_primary" style="margin:15px;">����</a>
        <a href="/dom/PhoneRent/index.php" class="weui-btn weui-btn_warn" style="margin:15px;">����ҳ</a>
    </form>
    <{/if}>
<{/if}>

<{if $type=='detail'}>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�ֻ��ͺ�</label></div>
            <div class="weui-cell__bd">
                <{$phone_info.phone_model}>
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">���޿�ʼ����</label></div>
            <div class="weui-cell__bd">
                <{$rent_info.rent_start_time}>
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">���޽�������</label></div>
            <div class="weui-cell__bd">
                <{$rent_info.rent_end_time}>
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">������</label></div>
            <div class="weui-cell__bd">
                <{$rent_info.rent_name}>
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">ҵ��Ա</label></div>
            <div class="weui-cell__bd">
                <{$rent_info.saler_name}>
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�ֹ�Ա</label></div>
            <div class="weui-cell__bd">
                <{$rent_info.store_name}>
            </div>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">������˾</label></div>
        <div class="weui-cell__bd">
            <{$express[$rent_info.express_company]}>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">��������</label></div>
        <div class="weui-cell__bd">
            <{$rent_info.express_number}><a href="/dom/PhoneRent/express.php?express_com=<{$rent_info.express_company}>&express_num=<{$rent_info.express_number}>&wap=1">�鿴����</a>
        </div>
    </div>
    ƾ֤��Ϣ��

    ���Ӻ�ͬ��<br>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">����ƽ̨</label></div>
            <div class="weui-cell__bd">
                <{$rent_info.rent_platform}>
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�ֻ��ɱ�</label></div>
            <div class="weui-cell__bd">
                ��<{$phone_info.phone_cost}>
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�������</label></div>
            <div class="weui-cell__bd">
                ��<{$rent_info.rent_price}>
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�ۼ����</label></div>
            <div class="weui-cell__bd">
                ��<{$sum_price}>
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�������</label></div>
            <div class="weui-cell__bd">
                ��<{$profit}>
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�豸�۾���</label></div>
            <div class="weui-cell__bd">
                <{$rent_info.depreciation_price}>%
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">�̶��ʲ�����</label></div>
            <div class="weui-cell__bd">
                ��<{$gudingzichan}>
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">��������+�ʲ�</label></div>
            <div class="weui-cell__bd">
                ��<{$profintzichan}>
            </div>
        </div>
    </div>
    <a href="javascript:;" onclick="del_rent()" id="show-confirm" class="weui-btn weui-btn_warn" style="margin:15px;">ɾ��</a>
    <a href="/dom/PhoneRent/index.php" class="weui-btn weui-btn_warn" style="margin:15px;">����ҳ</a>
<{/if}>

<script src="/public/js/jquery.min.2.1.1.js"></script>
<script src="/public/js/phonerent/jquery-weui.min.js"></script>
</body>
<script type="text/javascript">
    function del_rent(){
        var rent_id = '<{$rent_info.id}>';
        $.confirm({
            title: 'ɾ��',
            text: 'ȷ��ɾ����',
            onOK: function () {
                $.post("/dom/PhoneRent/rent.php",{type:'del',rent_id:rent_id,wap:1},function(data,status){
                    window.location.href = '/dom/PhoneRent/rent.php?type=list&phone_id=<{$phone_info.id}>&wap=1';
                });
            },
            onCancel: function () {
            }
        });
    }
    function form_submit(){
        var phone_model = $('#phone_model').val();
        if($.trim(phone_model) == ''){
            $.toast("�������ֻ��ͺ�", "forbidden");
            return false;
        }else{
            $.post("/dom/PhoneRent/phone.php",{type:'check_phone',phone_model:phone_model,wap:1},function(data,status){
                if(data.status=='success'){
                    $.toast("�ֻ��ͺŲ�����", "forbidden");
                }else{
                    $('#search_rent').submit();
                }
            });
        }

    }
</script>
</html>