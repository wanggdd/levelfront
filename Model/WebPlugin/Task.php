<?php

//���������ͼ���
namespace Model\WebPlugin;

class Model_Task extends \Model
{
    //�Ѿ�������˵������б�(�ж��Լ���ǰ����ʲô�ȼ����ҵ������Լ��ȼ������һ�������ϲ����㣬�Ƿ��д��ڴ˵ȼ����ˡ� ��û�о͸��˵ȼ���Ĭ���˴��)
    /**
     * @param $user_id int  ��ǰ��վ����ID
     * @param $user_user_id int  ��ǰ��ԱID
     */
    public static function getThree($user_id,$user_user_id){
        $return = array();
        //�Ȼ�ȡ��ǰ��Ա�ĵȼ�
        $member = Model_Member::getMemberByUser($user_id,$user_user_id);
        if(!$member[0]['higher_id'])
            return $return;
        $current_grade = $member[0]['grade'];

        //��õ�ǰ�ȼ�������ֵ
        $current_info = Model_Grade::getGradeByGrade($current_grade,$user_id);
        //������д��ڵ�ǰ�ȼ��ĵȼ����
        $up_info = Model_Grade::getNextGrades($user_id,$current_info['grade']);
        if(!$up_info)
            return $return;

        $grade_ids = '';
        foreach($up_info as $key=>$item){
            $grade_ids .= $grade_ids ? ','.$item['id'] : $item['id'];
        }

        //���ϲ�3�㣬�Ƿ��еȼ����ڵ�ǰ�ȼ��Ļ�Ա
        $task_member = array();
        $member1 = Model_Member::getInfoByGrades($user_id,$member[0]['higher_id'],$grade_ids);
        if(!$member1){
            $member2 = Model_Member::getInfoByGrades($user_id,$member1['higher_id'],$grade_ids);
            if(!$member2){
                $member3 = Model_Member::getInfoByGrades($user_id,$member2['higher_id'],$grade_ids);
                if(!$member3){
                    //û��ʱ��ȡϵͳĬ��ֵ
                    $sys_up = Model_Grade::getNextGrade($user_id,$current_info['grade']);
                    $member4 = Model_Member::getMemberByUser($user_id,$sys_up['user_user_id']);
                    if($member4)
                        $task_member = $member4[0];

                }else{
                    $task_member = $member3;
                }
            }else{
                $task_member = $member2;
            }
        }else{
            $task_member = $member1;
        }

        //���һ�ȡ����user_id���û���
        if($task_member){
            $user_info = Model_User::getUserById($user_id,$task_member['user_user_id']);
            $return['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
            $return['enter_member'] = $task_member['user_user_id'];

            //�ȼ���Ϣ
            $last_grade = Model_Grade::getGradeByGrade($task_member['grade'],$user_id);
            $return['promote_money']    = $last_grade['promote_money'];
            $return['grade_title']      = '����'.$last_grade['title'].'����';
            $return['promote_type']     = 2;
            $return['out_member']       = $user_user_id;
            $return['task_grade']       = $last_grade['id'];
        }
        return $return;
    }

    //δ������˵ĵھŲ㼶��������û�оŲ㣬�͸�ϵͳ���õ���ߵȼ���Ĭ�ϻ�Ա��
    /**
     * @param $user_id int  ��ǰ��վ����ID
     * @param $user_user_id int  ��ǰ��ԱID
     */
    public function getNine($user_id,$user_user_id){
        //��ȡϵͳ��ǰ�ȼ��Ĳ���
        $max_grade = Model_Grade::getGradeCount($user_id);
        //��ǰ�û����ϼ�
        $member = Model_Member::getMemberByUser($user_id,$user_user_id);
        $higher_id = $member[0]['higher_id'];
        $i = 1;
        $member_info = array();
        while($i <= $max_grade){
            $info = $this->nineUser($user_id,$higher_id);
            if(!$info){
                break;
            }
            $member_info = $info['member_info'];
            $higher_id = $info['higher_id'];
            $i++;
        }

        $grade = Model_Grade::getMaximumGrade($user_id);
        $level = $i-1;
        $return = array();
        $return['promote_type']     = 2;
        $return['task_grade']       = 2;
        $return['promote_money']    = $grade[0]['promote_money'];
        $return['status_title']     = '�����';
        if($level == $max_grade){
            $return['out_member'] = $user_user_id;
            $return['enter_member'] = $member_info['user_user_id'];
            $user_info = Model_User::getUserById($user_id,$member_info['user_user_id']);
            $return['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
        }else{
            //var_dump($grade);exit;
            //û�в鵽�ھŲ㣬����Ĭ�ϵ���
            if($grade['user_user_id']){
                $return['out_member']   = $user_user_id;
                $return['enter_member'] = $grade['user_user_id'];
                $user_info = Model_User::getUserById($user_id,$grade['user_user_id']);
                $return['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
                //����Ĭ�ϴ����
                $setting_info = Model_Setting::getSetting($user_id);
                $money = $setting_info['noactive_active_money'];
                $return['promote_money'] = $money;
            }else{
                return false;
            }
        }
        return $return;
    }


    public function nineUser($user_id,$higher_id){
        $member = Model_Member::getMemberByUser($user_id,$higher_id);
        if($member){
            return array('higher_id'=>$member[0]['higher_id'],'member_info'=>$member[0]);
        }else{
            return false;
        }
    }

}
