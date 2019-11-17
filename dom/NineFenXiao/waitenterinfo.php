<?php
/*
 * 代收款与确认收款功能
 */
include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

use Model\WebPlugin\Model_PaymentRecord;
use Model\WebPlugin\Model_Member;
use Model\WebPlugin\Model_Grade;

$userid = $zz_userid;
$admin_id = USER_ID;
$nickname = USER_USER_NICK_NAME;
$pid = $_GET['pid']?$_GET['pid']:$_POST['pid'];
$records = Model_PaymentRecord::getRecord(array('id'=>$pid));
$record_info = $records[0];
if($userid!=$record_info['enter_member']){
    die('deny1');
}

if(!empty($_POST)){
    $pid = $_POST['pid'];
    $type = $_POST['type'];
    if($type=='confirm'){ //待确认更新为确认或者取消
        header('Content-type: application/json');
        $pay_record = Model_PaymentRecord::getRecord(['id'=>$pid]);
        if(!$pay_record){
            echo json_encode(['status' => 'fails', 'msg' => 'record fails']);
            exit;
        }
        $pay_record_info = $pay_record[0];
        $out_uid = $pay_record_info['out_member'];
        $up_status = Model_PaymentRecord::updateStatus($pid,2);
        if($up_status) {
            $act_finish_count = Model_PaymentRecord::getActFinishRecord($out_uid);
            if($act_finish_count>=2){
                Model_Member::active($out_uid);
            }
            $member = Model_Member::getMemberByUser($out_uid);
            if($member&&$member[0]['status']==2){
                 Model_Grade::promote($admin_id,$out_uid);
            }

            echo json_encode(['status' => 'success', 'msg' => '']);
        }else{
            echo json_encode(['status' => 'fails', 'msg' => 'confirm fails']);
        }
        exit;
    }
}

//打款人
$out_member = \Model\WebPlugin\Model_User::getUserById($record_info['out_member']);
$out_name = $out_member[0]['user_name'];
//收款人
$enter_member = \Model\WebPlugin\Model_User::getUserById($record_info['enter_member']);
$enter_name = $enter_member[0]['user_name'];
$member_infos = \Model\WebPlugin\Model_Member::getMemberByUser($record_info['enter_member']);
$pay_qrcode = $member_infos[0]['payment_code'];

$smarty->assign('out_name',$out_name);
$smarty->assign('user_id',$userid);
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