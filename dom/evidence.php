<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

$userid = USER_USER_ID;
$username = USER_USER_NAME;
$avatar = USER_USER_HEAD_PIC;

use Model\WebPlugin\Model_PaymentRecord;

$id = $_POST['payment_id'];
$payment_voucher = $_POST['img'];
$payment_info = Model_PaymentRecord::getRecord($id);
if(!$payment_info){
    header('Content-type: application/json');
    echo json_encode(['status'=>'fail','msg'=>'no user']);
    exit;
}
$rs = Model_PaymentRecord::saveEvidence($id,$payment_voucher);
header('Content-type: application/json');
if($rs){
    echo json_encode(['status'=>'success','msg'=>'success']);
}else{
    echo json_encode(['status'=>'fail','msg'=>'Evidence set fail']);
}