<?php
//待打款任务

include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

use Model\WebPlugin\Model_PaymentRecord;
use Model\WebPlugin\Model_User;
use \Model\WebPlugin\Model_Member;

$uid = USER_ID;
$userid = USER_USER_ID;
$tpl = 'pay/await_remit_info.tpl';

//当前页面提交---添加
if(isset($_POST['form_submit']) && $_POST['form_submit'] == '1'){
    //向payment_record表中添加数据
    if(!$_POST['record_id']){
        $data = array(
            'user_id' => $uid,
            'out_member' => $userid,
            'enter_member'  => $_POST['enter_member'],
            'payment_money' => $_POST['promote_money'],
            'out_time'      => time(),
            'status'        => 1,
            'payment_voucher'   => $_POST['payment_voucher'],
            'payment_note'      => $_POST['payment_note'],
            'payment_type'      => 2,
            'task_grade'        => $_POST['task_grade']
        );
        $result = Model_PaymentRecord::insertRecord($data);
        if($result){
            header('location:/dom/ninefenxiao/waitout.php?zz_userid='.$userid);
        }else{
            echo "";
        }
    }
}

//当前页面提交---修改
if(isset($_POST['form_submit']) && $_POST['form_submit'] == '2'){
    //向payment_record表中添加数据
    $data = array(
        'out_time'      => time(),
        'status'        => 1,
        'payment_voucher'   => $_POST['payment_voucher'],
        'payment_note'      => $_POST['payment_note']
    );
    $result = Model_PaymentRecord::updateSet($_POST['record_id'],$data);
    if($result){
        header('location:/dom/ninefenxiao/waitout.php?zz_userid='.$userid);
    }else{
        echo "";
    }

}

$record_id = isset($_REQUEST['record_id']) ? $_REQUEST['record_id'] : 0;
if(isset($_REQUEST['record_id'])){
    $record = Model_PaymentRecord::getRecord(array('id'=>$record_id));
    //获取打款人基本信息
    $user_info = Model_User::getUserById($record[0]['enter_member']);
    $page_info['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];

    //收款人member信息
    $member = Model_Member::getMemberByUser($record[0]['enter_member']);
    $page_info['payment_code'] = $member[0]['payment_code'];
    $page_info['promote_money'] = $record[0]['payment_money'];
    $page_info['payment_note']  = $record[0]['payment_note'];
    $page_info['payment_voucher']   = $record[0]['payment_voucher'];
    $page_info['out_time']   = date("Y-m-d H:i:s",$record[0]['out_time']);

    //待收款
    if($record[0]['status'] == 1){
        $tpl = 'pay/await_remit_info_read.tpl';
    }else if($record[0]['status'] == 3) {
        $page_info['refuse_reason']   = $record[0]['refuse_reason'];
        $tpl = 'pay/refuse.tpl';//已经拒绝的
    }else if($record[0]['status']==2){
        //（对方）收款信息
        $record_info = $record[0];
        $record_info['out_time'] = date('Y-m-d H:i:s',$record_info['out_time']);
        $record_info['enter_time'] = date('Y-m-d H:i:s',$record_info['enter_time']);
        $smarty->assign('record',$record_info);
        $tpl = 'pay/remit_info.tpl';
    }

    //$record = Model_PaymentRecord::getRecord(array('out_member'=>$user_id,'payment_type'=>2,'task_grade'=>1));
}else{
    //任务表没有记录的情况
    $task_grade = $_REQUEST['task_grade'];
    $enter_member = $_REQUEST['enter_member'];

    //待收款人基本信息
    $user_info = Model_User::getUserById($enter_member);
    $page_info['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];

    //收款人member信息
    $member = Model_Member::getMemberByUser($enter_member);
    $page_info['payment_code'] = $member[0]['payment_code'];
    $page_info['promote_money'] = $_REQUEST['promote_money'];
    $page_info['task_grade']    = $task_grade;
    $page_info['enter_member']  = $enter_member;
}

$smarty->assign('page_info',$page_info);
$smarty->assign('record_id',$record_id);
$smarty->assign('zz_userid',$userid);
$smarty->display($tpl);
