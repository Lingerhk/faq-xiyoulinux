<?php

/**
 * Created by PhpStorm.
 * User: wangbo
 * Date: 2015/8/13
 * Time: 14:30
 */
require_once "oauth.class.php";
require_once "db_function.class.php";

class user
{
    private $ret;//״̬
    private $userid;
    private $name;
    private $sex;
    private $imgs;
    private $db;

    function __construct(){
        if(isset($_SESSION['userid']) && ($_SESSION['userid'] != 0)){
            $this->userid = $_SESSION['userid'];
            $this->name = $_SESSION['name'];
            $this->sex = $_SESSION['sex'];
            $this->imgs = $_SESSION['imgs'];
            $this->ret = 0;
        }
        else {
            $this->userid = 0;
            $this->ret = -1;
        }
        $this->db = new db_sql_functions();
    }

    //��תQQ��֤�û���½��Ϣ����֤�ɹ�����ture ���򷵻�false
    public function user_login_qq(){
        header("Location:/oauth/login.php");
        return true;
    }

    //��ת�ڲ�ƽ̨��֤�û���½��Ϣ����֤�ɹ�����ture ���򷵻�false
    public function user_login_linux(){
        return false;
    }

    //�˳���ǰ�û����ɹ�����ture ���򷵻�false
    public function user_login_out(){
        //���session
        //���cookie
        session_unset();
        if(isset($_COOKIE[session_name()])){
            setcookie(session_name(),'',time()-3600);
        }
        session_destroy();
        return true;
    }

    //��ȡ��ǰ��½�û���Ϣ
    public function user_get_login(){
        //�����û�����
        $tmp = array($this->ret,$this->userid,$this->name,$this->sex,$this->imgs);
        $tmp = json_encode($tmp);
        return $tmp;
    }

    //��ȡ����������Ϣ
    public function user_getinfo($userid){
        //ͨ�����ݿ��ѯ�û�����
        //get_userinfo
        $result = $this->db->get_userinfo($userid);
        if ($result){
            $tmp = array("ret"=>"0");
            $t = array_combine($tmp,$result);
            return json_encode($t);
        }else{
            $tmp = array("ret"=>"-1");
            return json_encode($tmp);
        }
    }

    //��ȡ�û�Ȩ�ޣ��������ݱ��б�ʶȨ�޵��ֶ�����Ӧ��ֵ
    public function user_get_privilege($user_id){
        $result = $this->db->get_userinfo($user_id);
        if ($result){
            return $result['privilege'];
        }
        return false;
    }
}