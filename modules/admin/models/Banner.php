<?php

namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use Yii;
class Banner extends ActiveRecord
{


    public static function tableName()
    {
        return "{{%banner}}";
    }


    public function bannerAdd($data=array())
    {
        if ($this->load($data)&&$this->validate()){
            $this->banner_add_time = time();
            if ($this->save(false)) {

                return $this->banner_id;
            }
            return false;
        }
        return false;
    }


    public  function  bannerEdit($data){
        if ($this->load($data)&&$this->validate()) {
            return (bool)$this->updateAll(
                [
                    'banner_id'         =>  $data["banner"]["banner_id"],
                    'banner_name'       =>  $data["banner"]["banner_name"],
                    'banner_image'      =>  $data["banner"]["banner_image"],
                    'banner_status'     =>  $data["banner"]["banner_status"],
                    'banner_category'   =>  $data["banner"]["banner_category"],
                    'banner_start_time' =>  $data["banner"]["banner_start_time"],
                    'banner_end_time'   =>  $data["banner"]["banner_end_time"],
                    'banner_add_time'   =>  $data["banner"]["banner_add_time"],
                    'banner_edit_time'  =>  $data["banner"]["banner_edit_time"],
                    'banner_sort'       =>  $data["banner"]["banner_sort"]
                ],
                'banner_id = :banner_id',
                [':banner_id' => $data["banner"]["banner_id"]]
            );
        }
        return false;
    }


    public  function  bannerDelete($banner_id){
        $data["Banner"]["banner_id"]=$banner_id;
        if($this->load($data)&&$this->validate()) {
            if ($this->delete()) {
                return true;
            }
        }
        return false;
    }

    public  function  getInfoById($banner_id){
       return $this->findOne($banner_id);
    }
}
