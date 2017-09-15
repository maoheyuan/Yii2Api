<?php

namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use Yii;
use app\helper\tree;
class Category extends ActiveRecord
{


    public static function tableName()
    {
        return "{{%category}}";
    }


    public function rules()
    {
        return [
            ['category_id', 'required', 'message' => '分类ID不能为空',"on"=>["categoryEdit","categoryDelete"]],
            ['category_name', 'required', 'message' => '分类名不能为空',"on"=>["categoryEdit","categoryAdd"]],
            ['category_parent_id','required',"message"=>'父级ID不能为空',"on"=>["categoryEdit","categoryAdd"]],
            ['category_sort','required',"message"=>'排序不能为空',"on"=>["categoryEdit","categoryAdd"]],
           /* ['category_add_time','required',"message"=>'创建时间不能为空',"on"=>["categoryAdd"]],*/
           /* ['category_edit_time','required',"message"=>'修改时间不能为空',"on"=>["categoryEdit"]],*/
            ['category_image_path','required',"message"=>'分类图片不能为空',"on"=>["categoryAdd"]],
            ['category_status','required',"message"=>'分类状态不能为空',"on"=>["categoryEdit","categoryAdd"]]

        ];
    }

    public  function  attributeLabels(){
        return [
            "category_id"=>"编号",
            "category_name"=>"名称",
            "category_parent_id"=>"父级",
            "category_sort"=>"排序",
            "category_status"=>"状态",
            "category_image_path"=>"图片"
        ];
    }

    public function categoryAdd($data=array())
    {
        $this->scenario = "categoryAdd";
        if ($this->load($data)&&$this->validate()){
            $this->category_add_time = time();
            if ($this->save(false)) {
                return $this->category_id;
            }
            return false;
        }
        return false;
    }

    public  function  categoryEdit($data){
        $this->scenario="categoryEdit";
        if ($this->load($data)&&$this->validate()) {
            $categoryData=array();
            $categoryData['category_name']        = $data['Category']["category_name"];
            $categoryData['category_parent_id']        = $data['Category']["category_parent_id"];
            if(isset($data['Category']["category_image_path"])){
                $categoryData['category_image_path']     = $data['Category']["category_image_path"];
            }
            $categoryData['category_sort']    = $data['Category']["category_sort"];
            $categoryData['category_status']  = $data['Category']["category_status"];
            $categoryData['category_edit_time'] = time();
            return $this->updateAll($categoryData,'category_id = :category_id',[':category_id' =>$data['Category']["category_id"]]);
        }

        return false;
    }


    public  function  categoryDelete($category_id){

        $this->scenario="categoryDelete";
        $data["Category"]["category_id"]=$category_id;
        if($this->load($data)&&$this->validate()) {
            $categoryInfo=$this->findOne($category_id);
            if(empty($categoryInfo)){
                return false;
            }
            if ($categoryInfo->delete()) {
                return true;
            }

        }
        return false;

    }


    public  function  getInfoById($category_id){
       return $this->findOne($category_id);
    }



    public function  getCategoryTree()
    {
        try{
            $categoryList = Category::find()->asArray()->all();
            foreach($categoryList as $r) {
                $r["id"]=$r["category_id"];
                $r["parentid"]=$r["category_parent_id"];
                $r["title"]=$r["category_name"];
                $array[] = $r;
            }
            $tree = new tree (array());
            $categoryTree=$tree->getTree($array);
            $categoryTree = $tree->setPrefix($categoryTree);

            return $categoryTree;
        }catch(\Exception $e){
            $this->error($e->getMessage());
        }
    }

}
