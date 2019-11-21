<?php
//待收款任务

include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

use Model\WebPlugin\Model_PaymentRecord;

$uid = USER_ID;
$userid = USER_USER_ID;
$nickname = USER_USER_NICK_NAME;
$username = USER_USER_NAME;

$record_info = Model_PaymentRecord::getWaitEnterList($uid,$userid);
if($record_info){
    foreach($record_info as $key=>$item){
        if($item['status'] == 1){
            $record_info[$key]['status_word'] = '待确认收款';
        }else if($item['status'] == 3){
            $record_info[$key]['status_word'] = '已拒绝';
        }
        $record_info[$key]['task_type'] = '升级任务';
        if($item['payment_type'] == 2)
            $record_info[$key]['task_type'] = '激活任务';

        $record_info[$key]['out_time'] = date('Y-m-d H:i:s',$item['out_time']);
    }
}


$smarty->assign('record_info',$record_info);
$smarty->assign('nickname',$nickname);
$smarty->assign('zz_userid',$userid);
$smarty->assign('username',$username);
$smarty->display('pay/await_gathering_list.tpl');