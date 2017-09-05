<?php

namespace app\modules\admin\models;


use yii\db\ActiveRecord;
use Yii;
class Admin extends ActiveRecord
{


    public static function tableName()
    {
        return "{{%admin}}";
    }

    public function rules()
    {
        return [
            ['admin_id', 'required', 'message' => '管理员ID不能为空',"on"=>["admin_edit","admin_delete"]],
            ['admin_permission', 'required', 'message' => '管理权限不能为空',"on"=>["admin_edit","admin_add"]],
            ['admin_name','required',"message"=>'管理员名称不能为空',"on"=>["admin_edit","admin_add"]],
            ['admin_is_super','required',"message"=>'是否超级管理员不能为空',"on"=>["admin_edit","admin_add"]],
            ['admin_add_time','required',"message"=>'添加时间不能为空',"on"=>["admin_add"]],
            ['admin_eidt_time','required',"message"=>'修改时间不能为空',"on"=>["admin_edit"]],

        ];
    }
    public function admin_add($data=array(), $scenario ='admin_add')
    {
        $this->scenario = $scenario;
        $data["admin_add_time"]=time();
        $this->load($data,"");
        if ($this->validate()){
            $result=$this->save(false);
            if ($result) {
                return $this->admin_id;
            }
            return false;
        }
        return false;
    }

    public  function  admin_edit($data, $scenario = 'admin_edit'){
        $this->scenario = $scenario;
        $data["admin_eidt_time"]=time();

        $data["admin_login_num"]=$data["admin_login_num"]+1;
        $this->load($data,"");
        if ($this->validate()) {
            return (bool)$this->updateAll(
                [
                    'admin_permission'   =>  $data["admin_permission"],
                    'admin_name'     =>  $data["admin_name"],
                    'admin_is_super'         =>  $data["admin_is_super"],
                    'admin_eidt_time'       =>  $data["admin_eidt_time"]
                ],
                'admin_id = :admin_id',
                [':admin_id' => $data['admin_id']]
            );
        }
        return false;
    }

    public  function  admin_delete($admin_id){

        $this->scenario="admin_delete";
        $this->load($data["admin_id"]=$admin_id,"");
        if($this->validate()) {
            if ($this->delete($admin_id)) {
                return true;
            }
        }
        return false;
    }

    public  function  get_view_by_id($admin_id){
        return $this->findOne($admin_id);
    }
}
