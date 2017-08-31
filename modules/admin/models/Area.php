<?php

namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use Yii;
class Admin extends ActiveRecord
{


    public static function tableName()
    {
        return "{{%area}}";
    }

    /*
     CREATE TABLE `mhy_area` (
      `area_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '地区ID',
      `area_name` char(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '地区名称',
      `area_parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
      `area_add_id` int(11) NOT NULL DEFAULT '0' COMMENT '创建人ID',
      `area_sort` int(11) DEFAULT '100',
      `area_level` int(11) NOT NULL COMMENT '级别 0省 1市 2区/县',
      `area_edit_time` int(11) DEFAULT '0' COMMENT '修改时间',
      `area_add_time` int(11) DEFAULT NULL COMMENT '新增时间',
      PRIMARY KEY (`area_id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='地区管理表';
    */
    public function rules()
    {
        return [
            ['area_id', 'required', 'message' => '地区ID不能为空',"on"=>["admin_edit","admin_delete"]],
            ['area_name', 'required', 'message' => '地区名称不能为空',"on"=>["admin_edit","admin_add"]],
            ['area_parent_id','required',"message"=>'创建人ID不能为空',"on"=>["admin_edit","admin_add"]],
            ['area_sort','required',"message"=>'排序不能为空',"on"=>["admin_edit","admin_add"]],
            ['area_level','required',"message"=>'级别不能为空',"on"=>["admin_edit","admin_add"]],
            ['area_add_time','required',"message"=>'添加时间不能为空',"on"=>["admin_add"]],
            ['area_edit_time','required',"message"=>'修改时间不能为空',"on"=>["admin_edit"]],

        ];
    }


    public function area_add($data=array(), $scenario ='area_add')
    {
        $this->scenario = $scenario;
        $data["area_add_time"]=time();
        $this->load($data,"");
        if ($this->validate()){
            $result=$this->save(false);
            if ($result) {
                return $this->area_id;
            }
            return false;
        }
        return false;
    }


    public  function  area_edit($data, $scenario = 'area_edit'){
        $this->scenario = $scenario;
        $data["area_edit_time"]=time();

        $this->load($data,"");
        if ($this->validate()) {
            return (bool)$this->updateAll(
                [
                    'area_name'   =>  $data["area_name"],
                    'area_parent_id'     =>  $data["area_parent_id"],
                    'area_sort'         =>  $data["area_sort"],
                    'area_level'       =>  $data["area_level"],
                    'area_edit_time'         =>  $data["area_edit_time"]

                ],
                'area_id = :area_id',
                [':area_id' => $this->area_id]
            );
        }
        return false;
    }


    public  function  area_delete($area_id){

        $this->scenario="area_delete";
        $this->load($data["area_id"]=$area_id,"");
        if($this->validate()) {
            if ($this->delete($area_id)) {
                return true;
            }
        }
        return false;

    }

    public  function  get_view_by_id($area_id){
       return $this->findOne($area_id);
    }
}
