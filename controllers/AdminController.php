<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Admin;
use yii\helpers\ArrayHelper;
use app\helper\Helper;

class AdminController extends Controller
{

    public function init(){
        $this->enableCsrfValidation = false;
        Yii::$app->response->format=Response::FORMAT_JSON;
    }

    public function actionIndex()
    {
        $start_time=Yii::$app->request->get("start_time");
        $end_time=Yii::$app->request->get("end_time");
        $admin_name=Yii::$app->request->get("admin_name","");
        $page= Yii::$app->request->get("page",0);
        $page_limit= Yii::$app->request->get("page_limit",20);
        $model=Admin::find();
        if($start_time){
            $model->andWhere([">=","admin_add_time",strtotime($start_time)]);
        }
        if($end_time){
            $model->andWhere(["<=","admin_add_time",strtotime($end_time)]);
        }
        if($admin_name){
            $model->where(["like","admin_name",$admin_name]);
        }
        //echo $model->createCommand()->getRawSql();
        $goodsCount=$model->count();
        $goodsList =$model->offset($page*$page_limit)->limit($page_limit)->asArray()->all();
        $createPage= Helper::create_page($goodsCount,$page,$page_limit);
        return [
            'status'=>true,
            "prev_page"=>$createPage["prev_page"],
            "next_page"=>$createPage["next_page"],
            'count_page'=>$createPage["count_page"],
            'first_page'=>$createPage["first_page"],
            'last_page'=>$createPage["last_page"],
            "list"=>$goodsList
        ];
    }

    public function actionCreate()
    {

        $model=new Admin();
        $post=Yii::$app->request->post();
        $result=$model->admin_add($post);
        if($result){
            $returnData=Helper::returnData(true,["id"=>$result],"新增成功!");
        }
        else{
            $error=Helper::getFirstError($model);
            $returnData=Helper::returnData(false,$error,"新增成功!");
        }
        return $returnData;

    }


    public function  actionUpdate($admin_id){
        $model=new Admin();
        $post=Yii::$app->request->post();
        $post["admin_id"]=$admin_id;
        $result=$model->admin_edit($post);
        if($result){

            $returnData=Helper::returnData(true,["id"=>$result],"修改成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"修改失败!");
        }
        return $returnData;
    }

    public  function  actionView($admin_id){
        $model=new Admin();
        $result=$model->get_view_by_id($admin_id);
        $result=ArrayHelper::toArray($result);
        if($result){
            $returnData=Helper::returnData(true,$result,"查找成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"查找失败!");
        }
        return $returnData;
    }
    public function actionDelete($admin_id){
        $model=new Admin();
        $result=$model->goods_delete($admin_id);
        if($result){
            $returnData=Helper::returnData(true,["id"=>$result],"删除成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"删除失败!");
        }
        return $returnData;
    }




}
