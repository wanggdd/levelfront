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
        $member = Model_Member::getMemberByUser($user_user_id);
        if(!$member[0]['higher_id'])
            return $return;
        $grade_id = $member[0]['grade'];
        //$grade_info = Model_Grade::getGradeByGrade($grade_id);
        //if($grade_info){
            $current_grade = $grade_id;
            //��ǰ�޵ȼ�ʱ�������͵ȼ�
            $max_grade = Model_Grade::getMaximumGrade($user_id);
            if($current_grade == $max_grade['id']){
                $up_info = $max_grade;
            }else{
                //��ȡ��ǰ�ȼ���������һ��
                $up_info = Model_Grade::getNextGrade($user_id,$current_grade);
            }

            $return['promote_money']    = $up_info['promote_money'];
            $return['grade_title']      = '����'.$up_info['title'].'����';
            $return['promote_type']     = 2;
            $return['out_member']       = $user_user_id;
            $return['task_grade']       = $up_info['id'];

            //���ϲ�3�㣬�Ƿ��еȼ�����һ���Ļ�Ա
            $task_member = array();
            $member1 = Model_Member::getInfoByGradeId($member[0]['higher_id'],$up_info['id']);
            if(!$member1){
                $member2 = Model_Member::getInfoByGradeId($member1['higher_id'],$up_info['id']);
                if(!$member2){
                    $member3 = Model_Member::getInfoByGradeId($member2['higher_id'],$up_info['id']);
                    if(!$member3){
                        //û��ʱ��ȡϵͳĬ��ֵ
                        $member4 = Model_Member::getMemberByUser($up_info['user_user_id']);
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
                $user_info = Model_User::getUserById($task_member['user_user_id']);
                $return['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
                $return['enter_member'] = $task_member['user_user_id'];
            }else{
                //û��ʱ�����ҵȼ�Ĭ�ϵ���
                $info = Model_Grade::getGrade(array('user_id'=>$user_id,'id'=>$up_info['id']));
                if($info[0]['user_user_id']){
                    $user_info = Model_User::getUserById($info[0]['user_user_id']);
                    $return['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
                    $return['enter_member'] = $task_member['user_user_id'];
                    //����Ĭ�ϴ����
                    $setting_info = Model_Setting::getSetting($user_id);
                    $money = $setting_info['noactive_active_money'];
                    $return['promote_money'] = $money;
                }

            }
            //$return['task_member'] = $task_member;
            return $return;
        //}
    }

    //δ������˵ĵھŲ㼶��������û�оŲ㣬�͸�ϵͳ���õ���ߵȼ���Ĭ�ϻ�Ա��
    /**
     * @param $user_id int  ��ǰ��վ����ID
     * @param $user_user_id int  ��ǰ��ԱID
     */
    public function getNine($user_id,$user_user_id){
        //��ȡϵͳ��ǰ���ȼ�
        $max_grade = Model_Grade::getGradeCount($user_id);
        //��ǰ�û����ϼ�
        $member = Model_Member::getMemberByUser($user_user_id);
        $higher_id = $member[0]['higher_id'];
        $i = 1;
        $member_info = array();
        while($i <= $max_grade){
            $info = $this->nineUser($higher_id);
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
            $user_info = Model_User::getUserById($member_info['user_user_id']);
            $return['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
        }else{
            //var_dump($grade);exit;
            //û�в鵽�ھŲ㣬����Ĭ�ϵ���
            if($grade['user_user_id']){
                $return['out_member']   = $user_user_id;
                $return['enter_member'] = $grade['user_user_id'];
                $user_info = Model_User::getUserById($grade['user_user_id']);
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


    public function nineUser($higher_id){
        $member = Model_Member::getMemberByUser($higher_id);
        if($member){
            return array('higher_id'=>$member[0]['higher_id'],'member_info'=>$member[0]);
        }else{
            return false;
        }
    }

}
