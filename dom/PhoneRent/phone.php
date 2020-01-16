<?php

//手机信息
include_once $_SERVER['DOCUMENT_ROOT'] . '/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/public.php';

use Model\PhoneRent\Model_Phone;
use Model\PhoneRent\Model_Rent;

$uid = USER_ID;
$tpl = 'phonerent/phone_list.tpl';

$type = $_REQUEST['type'] ? $_REQUEST['type'] : 'list';

//手机列表
$phoneList = Model_Phone::getPhoneList($uid);
$smarty->assign('phoneList',$phoneList);

if($type == 'add'){
    $tpl = 'phonerent/add_phone.tpl';
}

if($type=='check_phone'){ //验证手机
    header('Content-type: application/json');
    $phone_model = $_POST['phone_model'];
    $phone_info = Model_Phone::checkPhone($uid,$phone_model);
    if($phone_info){
        echo json_encode(['status' => 'fails']);
    }else{
        echo json_encode(['status' => 'success']);
    }
    exit;
}

if($type=='del'){ //删除
    header('Content-type: application/json');
    $phone_model = $_POST['phone_model'];
    $phone_info = Model_Phone::getPhone($uid,$phone_model);

    Model_Phone::updateStatus($phone_info['id']);
    $rent_list = Model_Rent::getRentList($uid,$phone_info['id']);
    if($rent_list){
        foreach($rent_list as $key=>$item){
            Model_Rent::updateStatus($item['id']);
        }
    }

    echo json_encode(['status' => 'success']);//, 'msg' => 'confirm success']);
    exit;
}

if($type == 'add_phone'){ //添加手机
    $data = array(
        'user_id' => $uid,
        'phone_model' => $_POST['phone_model'],
        'phone_cost'  => $_POST['phone_cost'],
        'create_time' => time()
    );

    $result = Model_Phone::insertPhone($data);
    header('Location:/dom/PhoneRent/phone.php?type=list&wap=1');
}

if($type == 'detail'){
    $tpl = 'phonerent/phone_detail.tpl';
    $phone_model = $_REQUEST['phone_model'] ? $_REQUEST['phone_model'] : '';
    $phoneInfo = Model_Phone::getPhone($uid,$phone_model);
    $smarty->assign('phoneInfo',$phoneInfo);
}

$smarty->display($tpl);