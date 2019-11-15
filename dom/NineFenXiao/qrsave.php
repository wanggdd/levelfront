<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/public.php';

$userid = $zz_userid;
$username = USER_USER_NAME;
$avatar = USER_USER_HEAD_PIC;

use Model\WebPlugin\Model_Member;

$qrcode = $_POST['qrcode'];
$member_info = Model_Member::getMemberByUser($userid);
if(!$member_info){
    header('Content-type: application/json');
    echo json_encode(['status'=>'fail','msg'=>'no user']);
    exit;
}
$rs = Model_Member::updateQrcode($userid,$qrcode);
header('Content-type: application/json');
if($rs){
    echo json_encode(['status'=>'success','msg'=>'success']);
}else{
    echo json_encode(['status'=>'fail','msg'=>'qrcode set fail']);
}