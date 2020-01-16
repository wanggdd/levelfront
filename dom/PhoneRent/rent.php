<?php

//手机信息
include_once $_SERVER['DOCUMENT_ROOT'] . '/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/public.php';

use Model\PhoneRent\Model_Phone;
use Model\PhoneRent\Model_Rent;

$uid = USER_ID;
$tpl = 'phonerent/add_rent.tpl';

$type = $_REQUEST['type'] ? $_REQUEST['type'] : '';
$phone_id = $_REQUEST['phone_id'] ? $_REQUEST['phone_id'] : 0;

//手机信息
$phone_info = Model_Phone::getPhoneById($uid,$phone_id);

if($type == 'add_rent'){ //添加租赁信息
    $data = $_POST;
    if(isset($data['phone_model'])){
        $phone_info = Model_Phone::getPhone($uid,$data['phone_model']);
        $data['phone_id'] = $phone_info['id'];
    }
    unset($data['phone_model']);
    unset($data['type']);


    $data['user_id'] = $uid;
    $data['create_time'] = time();
//var_dump($data);exit;
    $result = Model_Rent::insertRent($data);

    header("location:rent.php?type=list&phone_id=".$data['phone_id']);
}

if($type == 'list'){
    $tpl = 'phonerent/rent_list.tpl';

    $rentList = Model_Rent::getRentList($uid,$phone_id);
    $smarty->assign('rentList',$rentList);
    $smarty->assign('phone_id',$phone_id);
}

if($type == 'del'){
    $rent_id = $_REQUEST['rent_id'] ? $_REQUEST['rent_id'] : 0;
    Model_Rent::updateStatus($rent_id);

    echo json_encode(['status' => 'success']);
    exit;
}

//快递设置
$express = array(
    'shunfeng'  => '顺丰快递',
    'yuantong'  => '圆通快递',
    'yunda'     => '韵达快递',
    'shentong'  => '申通快递',
    'zhongtong' => '中通快递',
    'tiantian'  => '天天快递',
    'ems'       => 'EMS邮政'
);

//var_dump($phone_info);exit;
$smarty->assign('type',$type);
$smarty->assign('phone_info',$phone_info);
$smarty->assign('express',$express);
$smarty->display($tpl);