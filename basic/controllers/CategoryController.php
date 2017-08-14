<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Category;
use yii\helpers\ArrayHelper;
use app\helper\helper;

class CategoryController extends Controller
{

    public function init(){
        $this->enableCsrfValidation = false;
        Yii::$app->response->format=Response::FORMAT_JSON;
    }

    public function actionIndex()
    {

        $page= Yii::$app->request->get("page");
        $page_limit= Yii::$app->request->get("page_limit");
        $memberCount=Category::find()->count();
        $memberList =  Category::find()->offset($page*$page_limit)->limit($page_limit)->asArray()->all();
        return [
            'code'=>true,
            'count'=>$memberCount,
            "data"=>$memberList
        ];
    }

    public function actionCreate()
    {
        $returnData=array();
        $model=new Category();
        $post=Yii::$app->request->post();
        $result=$model->category_add($post);
        if($result){
            $returnData=Helper::returnData(true,["id"=>$result],"删除成功!");
        }
        else{

            $returnData=Helper::returnData(false,[],"删除失败!");
        }
        return $returnData;

    }


    public function  actionUpdate($category_id){
        $model=new Category();
        $post=Yii::$app->request->post();
        $post["member_id"]=$category_id;
        $result=$model->category_edit($post);
        if($result){
            $returnData=Helper::returnData(true,["id"=>$result],"修改成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"修改失败!");
        }
        return $returnData;
    }

    public  function  actionView($category_id){
        $model=new Category();
        $result=$model->get_view_by_id($category_id);
        $result=ArrayHelper::toArray($result);
        if($result){
            $returnData=Helper::returnData(true,$result,"查找成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"查找失败!");
        }
        return $returnData;
    }


    public function actionDelete($category_id){
        $model=new Category();
        $result=$model->category_delete($category_id);
        if($result){
            $returnData=Helper::returnData(true,["id"=>$result],"删除成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"删除失败!");
        }
        return $returnData;
    }

    protected  function  getFirstError($model){

      return  array_values($model->getFirstErrors())[0];
    }


}
