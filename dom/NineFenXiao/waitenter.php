<?php
//待收款任务

include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

use Model\WebPlugin\Model_PaymentRecord;

$userid = USER_USER_ID;
$nickname = USER_USER_NICK_NAME;

$record_info = Model_PaymentRecord::getWaitEnterList($userid);
if($record_info){
    foreach($record_info as $key=>$item){
        if($item['status'] == 1){
            $record_info[$key]['status_word'] = '待确认收款';
        }else if($item['status'] == 3){
            $record_info[$key]['status_word'] = '已拒绝';
        }
        $record_info[$key]['out_time'] = date('Y-m-d H:i:s',$item['out_time']);
    }
}

$smarty->assign('record_info',$record_info);
$smarty->assign('nickname',$nickname);
$smarty->assign('zz_userid',$userid);
$smarty->display('pay/await_gathering_list.tpl');