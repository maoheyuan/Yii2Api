<?php

namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use Yii;
class Area extends ActiveRecord
{


    public static function tableName()
    {
        return "{{%area}}";
    }

    public function rules()
    {
        return [
            ['area_id', 'required', 'message' => '地区ID不能为空',"on"=>["area_edit","area_delete"]],
            ['area_name', 'required', 'message' => '地区名称不能为空',"on"=>["area_edit","area_add"]],
            ['area_parent_id','required',"message"=>'创建人ID不能为空',"on"=>["area_edit","area_add"]],
            ['area_sort','required',"message"=>'排序不能为空',"on"=>["area_edit","area_add"]],
            ['area_level','required',"message"=>'级别不能为空',"on"=>["area_edit","area_add"]],
            ['area_add_time','required',"message"=>'添加时间不能为空',"on"=>["area_add"]],
            ['area_edit_time','required',"message"=>'修改时间不能为空',"on"=>["area_edit"]],

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
        $data["area_id"]=$area_id;
        $this->load($data,"");
        if($this->validate()) {
            $areaInfo=$this->findOne(["area_id"=>$area_id]);
            if ($areaInfo->delete()) {
                return true;
            }
        }
        return false;
    }

    public  function  get_view_by_id($area_id){
       return $this->findOne($area_id);
    }
}
