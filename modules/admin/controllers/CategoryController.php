<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\modules\admin\models\Category;
use yii\helpers\ArrayHelper;
use app\helper\helper;
use yii\helpers\Url;
use app\helper\tree;

class CategoryController extends BaseController
{

    public function init(){
        $this->enableCsrfValidation = false;
      /*  Yii::$app->response->format=Response::FORMAT_JSON;*/
    }

    public function actionIndex()
    {
        $this->layout = 'main';
        $areaList =Category::find()->asArray()->all();
        //echo $model->createCommand()->getRawSql();
        foreach($areaList as $r) {
            $r["id"]=$r["category_id"];
            $r["parentId"]=$r["category_parent_id"];
            $r["category_add_time"]=Yii::$app->formatter->asDatetime($r["category_add_time"]);
            if($r["category_image_path"]){
                $r["category_image_path"]="<img src='/uploads/images/".$r["category_image_path"]."' width=25 height=25/>";
            }
            else{
                $r["category_image_path"]="/";
            }
            $r['str_manage'] = '<a  class="btn btn-warning btn-sm update" title="分类修改" data-url="'.Url::toRoute(['category/edit']).'?category_id='.$r['category_id'].'"><i class="fa fa-edit" aria-hidden="true"></i> </a>
                                         <a  class="btn btn-danger btn-sm delete"  title="分类删除" data-id="'.$r['category_id'].'" data-url="'.Url::toRoute(['category/delete']).'?category_id='.$r['category_id'].'"> <i class="fa fa-trash-o fa-lg"></i></a>';
            $array[] = $r;
        }
        $str  = "<tr id='row\$id'>
						<td align='center'><input name='listorders[\$id]' type='text' size='3' value='\$category_sort'></td>
						<td align='center'>\$id</td>
						<td  >\$spacer\$category_name</td>
                        <td  >\$category_image_path</td>
						<td align='center'>\$category_add_time</td>
						<td align='center'>\$str_manage</td>
					</tr>";
        $tree =  new tree ($array);
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─','&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $list = $tree->get_tree(0, $str);
        return $this->render("index", ["list"=>$list]);
    }

    public function actionAdd()
    {
        $this->layout = 'mainNotNavAndFooter';
        $category=new Category();
        if(Yii::$app->request->isPost){
            $categoryData=Yii::$app->request->post();
            $imageInfo = \Yii::$app->mhyUploadsFile->uploadsImage('category_image');
            if($imageInfo["status"]){
                $categoryData["Category"]["category_image_path"]=$imageInfo["data"];
                if($categoryId=$category->categoryAdd($categoryData)) {
                    return $this->success('添加成功',"category/add");
                }
                else{
                    $error=Helper::getFirstError($category);
                    return $this->error($error);
                }
            }
            else{
                return $this->error('图片保存失败');
            }

        }
        $categoryTree=$category->getCategoryTree();
        $categoryList = ArrayHelper::map(
            $categoryTree,
            'category_id',
            'title'
        );
        $category->scenario="categoryAdd";
        return $this->render("add",[
            "category"=>$category,
            "categoryList"=>$categoryList,
        ]);
    }


    public function  actionEdit($category_id){

        $this->layout="mainNotNavAndFooter";
        $categoryModel=new Category();
        $category=$categoryModel->getInfoById($category_id);
        if(Yii::$app->request->isPost){
            $categoryData=Yii::$app->request->post();
            $imageInfo=Yii::$app->mhyUploadsFile->uploadsImage("category_image");
            if($imageInfo["status"]==0&&$imageInfo["data"]!=400){
                return $this->error("图片保存失败");
            }
            if($imageInfo["status"]==1){
                $categoryData["Category"]["category_image_path"]=$imageInfo["data"];
            }
            $categoryData["Category"]["category_id"]=$category_id;
            if($categoryModel->categoryEdit($categoryData)){

                return $this->success("修改成功!",['category/edit',"category_id"=>$category_id]);
            }
            else{
                $error=Helper::getFirstError($categoryModel);
                return $this->error($error);
            }
        }
        $categoryTree=$categoryModel->getCategoryTree();
        $categoryList=ArrayHelper::map($categoryTree,"category_id","title");
        $category->scenario="categoryEdit";
        return $this->render("edit",[
            "category"=>$category,
            "categoryList"=>$categoryList
        ]);
    }


    public function actionDelete($category_id){
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new Category();
        $result=$model->categoryDelete($category_id);
        if($result){
            $returnData=Helper::returnData(true,["id"=>$result],"删除成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"删除失败!");
        }
        return $returnData;
    }
}
