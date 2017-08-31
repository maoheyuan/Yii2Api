<?php

namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use Yii;
class Category extends ActiveRecord
{


    public static function tableName()
    {
        return "{{%category}}";
    }


    /*CREATE TABLE `mhy_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '2B分类ID',
  `category_name` char(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名',
  `category_parent_id` int(11) NOT NULL COMMENT '父级ID',
  `category_sort` int(11) DEFAULT '0' COMMENT '排序',
  `category_add_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `category_edit_time` int(11) NOT NULL DEFAULT '0' COMMENT '最近修改时间',
  `category_image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '分类图片',
  `category_status` int(2) NOT NULL DEFAULT '1' COMMENT '分类状态1启用2禁用',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品分类表';*/

    public function rules()
    {
        return [
            ['category_id', 'required', 'message' => '分类ID不能为空',"on"=>["category_edit","category_delete"]],
            ['category_name', 'required', 'message' => '分类名不能为空',"on"=>["category_edit","category_add"]],
            ['category_parent_id','required',"message"=>'父级ID不能为空',"on"=>["category_edit","category_add"]],
            ['category_sort','required',"message"=>'排序不能为空',"on"=>["category_edit","category_add"]],
            ['category_add_time','required',"message"=>'创建时间不能为空',"on"=>["category_edit","category_add"]],
            ['category_edit_time','required',"message"=>'修改时间不能为空',"on"=>["category_edit","category_add"]],
            ['category_image_path','required',"message"=>'分类图片不能为空',"on"=>["category_edit","category_add"]],
            ['category_status','required',"message"=>'分类状态不能为空',"on"=>["category_edit","category_add"]]

        ];
    }


    public function category_add($data=array(), $scenario ='category_add')
    {
        $this->scenario = $scenario;
        $this->load($data,"");
        if ($this->validate()){
            $this->category_add_time = time();
            $result=$this->save(false);
            if ($result) {
                return $this->category_id;
            }
            return false;
        }
        return false;
    }


    public  function  banner_edit($data, $scenario = 'banner_edit'){
        $this->scenario = $scenario;

        $this->load($data,"");
        if ($this->validate()) {
            return (bool)$this->updateAll(
                [
                    'banner_id'         =>  $data["banner_id"],
                    'banner_name'       =>  $data["banner_name"],
                    'banner_image'      =>  $data["banner_image"],
                    'banner_status'     =>  $data["banner_status"],
                    'banner_category'   =>  $data["banner_category"],
                    'banner_start_time' =>  $data["banner_start_time"],
                    'banner_end_time'   =>  $data["banner_end_time"],
                    'banner_add_time'   =>  $data["banner_add_time"],
                    'banner_edit_time'  =>  $data["banner_edit_time"],
                    'banner_sort'       =>  $data["banner_sort"]
                ],
                'category_id = :category_id',
                [':category_id' => $this->category_id]
            );
        }
        return false;
    }


    public  function  category_delete($category_id){

        $this->scenario="category_delete";
        $this->load($data["category_id"]=$category_id,"");
        if($this->validate()) {

            if ($this->delete($category_id)) {
                return true;
            }
        }
        return false;

    }


    public  function  get_view_by_id($category_id){
       return $this->findOne($category_id);
    }
}
