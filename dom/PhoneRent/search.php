<?php

//手机信息
include_once $_SERVER['DOCUMENT_ROOT'] . '/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/public.php';

use Model\PhoneRent\Model_Phone;
use Model\PhoneRent\Model_Rent;

$uid = USER_ID;

$type = $_REQUEST['type'] ? $_REQUEST['type'] : 'list';

if($type == 'search'){
    $rent_list = array();
    $phone_model = isset($_POST['phone_model']) ? $_POST['phone_model'] : '';
    $phone_info = Model_Phone::getPhone($uid,$phone_model);
    if($phone_info){
        $rent_list = Model_Rent::getRentList($uid,$phone_info['id']);

    }
    $smarty->assign('phone_info',$phone_info);
    $smarty->assign('rent_list',$rent_list);
}

if($type == 'detail'){
    $rent_id = isset($_GET['rent_id']) ? $_GET['rent_id'] : 0;
    if($rent_id){
        $rent_info = Model_Rent::getRentInfo($uid,$rent_id);
        $phone_info = Model_Phone::getPhoneById($uid,$rent_info['phone_id']);

        //累计租金
        $sum_price = Model_Rent::getSumPrice($uid,$rent_info['phone_id']);

        //租金利润
        $profit = $sum_price - $phone_info['phone_cost'];

        //固定资产估值
        $gudingzichan = $phone_info['phone_cost']*($rent_info['depreciation_price']/100);

        //租赁利润+资产
        $profintzichan = $profit + $gudingzichan;

        $sum_price = number_format($sum_price,2);
        $profit = number_format($profit,2);
        $gudingzichan = number_format($gudingzichan,2);
        $profintzichan = number_format($profintzichan,2);

        $smarty->assign('rent_info',$rent_info);
        $smarty->assign('phone_info',$phone_info);
        $smarty->assign('sum_price',$sum_price);
        $smarty->assign('profit',$profit);
        $smarty->assign('gudingzichan',$gudingzichan);
        $smarty->assign('profintzichan',$profintzichan);
    }
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

$smarty->assign('type',$type);
$smarty->assign('express',$express);
$smarty->display('phonerent/search_rent.tpl');