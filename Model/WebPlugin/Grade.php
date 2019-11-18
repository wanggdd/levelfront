<?php

namespace Model\WebPlugin;

class Model_Grade extends \Model
{
    /**
     * ͨ��grade_id��ȡ�ȼ���Ϣ
     * @param int $id
     * @return mixed
     */
    public static function getGradeByGrade($id = 0){
        if(!$id)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('grade s');
        $obj->addAndWhere('id='.$id);
        $result = $obj->query(false);
        if($result)
            return $result[0];
        return false;
    }

    public static function getGrade($fileds = array()){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('grade s');
        if($fileds){
            foreach($fileds as $key=>$item){
                $obj->addAndWhere($key.'='.$item);
            }
        }

        return $obj->query(false);
    }
    /**
     * ���ݻ�Աid�������Ƿ��ǳ�ʼ�û�
     * @param $user_id ��վ������ID
     * @param $user_user_id ��ԱID
     * @return mixed
     */
    public static function getInfoByUser($user_id,$user_user_id){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('grade s');
        $obj->addAndWhere('user_id='.$user_id.' and user_user_id='.$user_user_id);
        $result = $obj->query(false);
        if($result)
            return $result[0];
        return false;
    }

    //��ȡ��ߵȼ�
    public static function getMaximumGrade($user_id,$type = 'desc'){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('grade s');
        $obj->addAndWhere('user_id='.$user_id);
        $obj->addOrderBy('grade',$type);
        $obj->setLimiter(0,1);
        $result = $obj->query(false);

        return $result;
    }

    public static function upUserGrade($field,$value,$uid){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));

        return $obj->update('member s',[$field=>$value],'user_user_id='.$uid);
    }

    public static function getNextGrade($user_id,$current_grade){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('grade s');
        $obj->addAndWhere('user_id='.$user_id.' and grade>'.$current_grade);
        $obj->addOrderBy('grade','asc');
        $obj->setLimiter(0,1);
        $result = $obj->query(false);

        return $result;
    }

    /**
     * �ж��Ƿ���Ҫ������������Ҫʱ����
     * @param $user_id ��վ������ID
     * @param $user_user_id ��ԱID
     * @return mixed 1����ɹ���>1ֵ������ʧ��
     */
    public static function promote($user_id,$user_user_id){
        //��ȡ��Ա��ǰ�ȼ�
        $member_info = Model_Member::getMemberByUser($user_user_id);
            /*δ�����û����������*/
        if($member_info[0]['status'] != 2)
            return 2;
        if($member_info[0]['grade'] == 0){
            $current_grade = 0;
        }else{
            $grade_info = self::getGradeByGrade($member_info[0]['grade']);
            /*˵���˻�Ա����Ӧ�ĵȼ��ѱ�ɾ��������ʱ��������*/
            if(!$grade_info)
                return 3;
            $current_grade = $grade_info['grade'];
        }

        //�жϵ�ǰ��Ա�Ƿ���ϵͳ��ʼ�û����ǵĻ�����Ҫ������
        $init_info = self::getInfoByUser($user_id,$user_user_id);
        if($init_info){
            return 4;
        }

        //�жϵ�ǰ��Ա�Ƿ��Ѿ�����ߵȼ�
        $max_grade = self::getMaximumGrade($user_id);
            /*������û��ʱ��˵����ǰ��̨��δ���õȼ�*/
        if(!$max_grade)
            return 5;
            /*���ʱ˵���Ѿ�����ߵȼ�������Ҫ����*/
        if($current_grade == $max_grade['grade'])
            return 6;

        //�ж��Ƿ�ﵽ�˽�������������
            /*��ǰû�еȼ�ʱ����������͵ȼ����еȼ�ʱ����������ǰ�ȼ�+1*/
        if($current_grade == 0){
            $up_grade = self::getMaximumGrade($user_id,'asc');
        }else{
            $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
            $obj->from('grade s');
            $obj->addAndWhere('user_id='.$user_id.' and grade>'.$current_grade);
            $obj->addOrderBy('grade','asc');
            $obj->setLimiter(0,1);
            $up_grade = $obj->query(false);
        }
            /*��ȡ��ǰ��Ա���¼�����*/
        $lower_count = Model_Member::getLowerCount($user_user_id);
            /*������������ 1:���ڵ���  2:����*/
        if($up_grade['promote_lower_type'] == 1){
            if($lower_count >= $up_grade['promote_lower_num']){
                //����
                self::upUserGrade('grade',$up_grade['id'],$user_user_id);
                return 1;
            }
        }
        if($up_grade['promote_lower_type'] == 2){
            if($lower_count = $up_grade['promote_lower_num']){
                //����
                self::upUserGrade('grade',$up_grade['id'],$user_user_id);
                return 1;
            }
        }
        return 10;
    }


}