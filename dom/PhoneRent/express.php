<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/public.php';

$express_com = $_REQUEST['express_com'] ? $_REQUEST['express_com'] : 'yunda';
$express_num = $_REQUEST['express_num'] ? $_REQUEST['express_num'] : '4303521384190';
//4303521384188
//yunda
//��������
$post_data = array();
$post_data["customer"] = '8EAEA17D0D53340DC22FC64B34E39AD7';
$key= 'rpNMDQtU6457' ;
$post_data["param"] = '{"com":"'.$express_com.'","num":"'.$express_num.'"}';

$url='http://poll.kuaidi100.com/poll/query.do';
$post_data["sign"] = md5($post_data["param"].$key.$post_data["customer"]);
$post_data["sign"] = strtoupper($post_data["sign"]);
$o="";
foreach ($post_data as $k=>$v)
{
    $o.= "$k=".urlencode($v)."&";		//Ĭ��UTF-8�����ʽ
}
$post_data=substr($o,0,-1);
$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
$data = str_replace("\"",'"',$result );
$data = json_decode($data,true);

$status = '��δ�鵽��Ϣ�����Ժ����²鿴!';
if(isset($data['data'])){
    switch ($data['state']){
        case 0:
            $status = '��;';
            break;
        case 1:
            $status = '����';
            break;
        case 2:
            $status = '����';
            break;
        case 3:
            $status = 'ǩ��';
            break;
        case 4:
            $status = '��ǩ';
            break;
        case 5:
            $status = '�ɼ�';
            break;
        case 6:
            $status = '�˻�';
            break;
        default:
            $status = '��δ�鵽��Ϣ�����Ժ����²鿴!';
    }
    //var_dump($data['data']);exit;
    $smarty->assign('data',$data['data']);

}else{
    $status = '��δ�鵽��Ϣ�����Ժ����²鿴!';
}

$smarty->assign('status',$status);
$smarty->display('phonerent/express.tpl');
?>