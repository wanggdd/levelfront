<?php
/**
 * �ܾ��տ��
 */
include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

use Model\WebPlugin\Model_PaymentRecord;

$userid = USER_USER_ID;
$nickname = USER_USER_NICK_NAME;
$pid = $_GET['pid']?$_GET['pid']:$_POST['pid'];
$records = Model_PaymentRecord::getRecord(array('id'=>$pid));
$record_info = $records[0];
if($userid!=$record_info['enter_member']){
    die('deny1');
}

if(!empty($_POST)){
    $refuse_reason = $_POST['refuse_reason'];
    $status = Model_PaymentRecord::updateSet($pid,['refuse_reason'=>$refuse_reason,'status'=>3]);
    if($status){
        //�ܾ��ɹ�����ת��ַ��ȷ��
        header('location:/dom/ninefenxiao/waitenter.php');
    }
}

$smarty->assign('pid',$pid);
$smarty->display('pay/refuse_info.tpl');