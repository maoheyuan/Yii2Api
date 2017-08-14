<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Banner;
use yii\helpers\ArrayHelper;
use app\helper\helper;

class BannerController extends Controller
{

    public function init(){
        $this->enableCsrfValidation = false;
    }

    public function actionIndex()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $page= Yii::$app->request->get("page");
        $page_limit= Yii::$app->request->get("page_limit");
        $memberCount=Banner::find()->count();
        $memberList =  Banner::find()->offset($page*$page_limit)->limit($page_limit)->asArray()->all();
        return [
            'code'=>true,
            'count'=>$memberCount,
            "data"=>$memberList
        ];
    }

    public function actionCreate()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $returnData=array();
        $model=new Banner();
        $post=Yii::$app->request->post();
        $result=$model->banner_add($post);
        if($result){
            $returnData=Helper::returnData(true,["id"=>$result],"删除成功!");
        }
        else{

            $returnData=Helper::returnData(false,[],"删除失败!");
        }
        return $returnData;

    }


    public function  actionUpdate($member_id){
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new Banner();
        $post=Yii::$app->request->post();
        $post["member_id"]=$member_id;
        $result=$model->banner_edit($post);
        if($result){
            $returnData=Helper::returnData(true,["id"=>$result],"修改成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"修改失败!");
        }
        return $returnData;
    }

    public  function  actionView($member_id){
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new Banner();
        $result=$model->get_view_by_id($member_id);
        $result=ArrayHelper::toArray($result);
        if($result){
            $returnData=Helper::returnData(true,$result,"查找成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"查找失败!");
        }
        return $returnData;
    }


    public function actionDelete($member_id){
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new Banner();
        $result=$model->banner_delete($member_id);
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
