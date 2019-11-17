<?php
/**
 * 拒绝收款功能
 */
include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

use Model\WebPlugin\Model_PaymentRecord;

$userid = $zz_userid;
$nickname = USER_USER_NICK_NAME;
$pid = $_GET['pid']?$_GET['pid']:$_POST['pid'];
$records = Model_PaymentRecord::getRecord(array('id'=>$pid));
$record_info = $records[0];
if($userid!=$record_info['enter_member']){
    die('deny1');
}

if(!empty($_POST)){
    $refuse_reason = $_POST['refuse_reason'];
    $status = Model_PaymentRecord::updateSet($pid,['refuse_reason'=>$refuse_reason,'refuse_time'=>time(),'status'=>3]);
    if($status){
        //拒绝成功后跳转地址需确定
        header('location:/dom/ninefenxiao/waitenter.php');
    }
}
$out_member = \Model\WebPlugin\Model_User::getUserById($record_info['out_member']);
$out_name = $out_member[0]['user_name'];
//收款人
$enter_member = \Model\WebPlugin\Model_User::getUserById($record_info['enter_member']);
$enter_name = $enter_member[0]['user_name'];
$smarty->assign('pid',$pid);
$smarty->assign('user_id',$userid);
$smarty->assign('out_name',$out_name);
$smarty->assign('enter_name',$enter_name);
$smarty->assign('record',$record_info);
if($record_info['status']==3){
    $smarty->display('pay/enterrefuse.tpl');
}else {
    $smarty->display('pay/refuse_info.tpl');
}