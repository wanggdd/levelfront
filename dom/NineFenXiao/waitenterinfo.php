<?php
/*
 * 代收款与确认收款功能
 */
include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

use Model\WebPlugin\Model_PaymentRecord;
use Model\WebPlugin\Model_Member;
use Model\WebPlugin\Model_Grade;
use Model\WebPlugin\Model_User;

$uid = USER_ID;//网站所属人id
$userid = $zz_userid;
$username = USER_USER_NAME;
$nickname = USER_USER_NICK_NAME;
$pid = $_GET['pid']?$_GET['pid']:$_POST['pid'];
$records = Model_PaymentRecord::getRecord($uid,array('id'=>$pid));
$record_info = $records[0];
if($userid!=$record_info['enter_member']){
    die('deny1');
}

if(!empty($_POST)){
    $pid = $_POST['pid'];
    $type = $_POST['type'];
    if($type=='confirm'){ //待确认更新为确认或者取消
        header('Content-type: application/json');
        $pay_record = Model_PaymentRecord::getRecord($uid,['id'=>$pid]);
        if(!$pay_record){
            echo json_encode(['status' => 'fails', 'msg' => 'record fails']);
            exit;
        }
        $pay_record_info = $pay_record[0];
        $out_uid = $pay_record_info['out_member'];
        $enter_member = $pay_record_info['enter_member'];
        $up_status = Model_PaymentRecord::updateStatus($pid,2);
        if($up_status) {
            $act_finish_count = Model_PaymentRecord::getActFinishRecord($uid,$out_uid);
            if($act_finish_count>=2){
                Model_Member::active($out_uid,$uid);
            }

            $pro_stat = Model_Grade::promote($uid,$enter_member);
            echo json_encode(['status' => 'success', 'msg' => $pro_stat]);
        }else{
            echo json_encode(['status' => 'fails', 'msg' => 'confirm fails']);
        }
        exit;
    }
}

//打款人
$out_member = Model_User::getUserById($uid,$record_info['out_member']);
$out_name = $out_member[0]['user_name'];
//收款人
$enter_member = Model_User::getUserById($uid,$record_info['enter_member']);
$enter_name = $enter_member[0]['user_name'];
$member_infos = Model_Member::getMemberByUser($uid,$record_info['enter_member']);
$pay_qrcode = $member_infos[0]['payment_code'];

$smarty->assign('out_name',$out_name);
$smarty->assign('user_id',$userid);
$smarty->assign('username',$username);
$smarty->assign('enter_name',$enter_name);
$smarty->assign('pay_qrcode',$pay_qrcode);
$smarty->assign('record',$record_info);
if($record_info['status']==1) {
    $smarty->display('pay/await_gathering_confirm.tpl');
}else if($record_info['status']==2){
    $smarty->display('pay/gathering_info.tpl');
}else {
    $smarty->display('pay/enterrefuse.tpl');
}