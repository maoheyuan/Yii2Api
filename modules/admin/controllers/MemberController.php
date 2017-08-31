<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Member;
use yii\helpers\ArrayHelper;
use app\helper\page;

class MemberController extends Controller
{
    public  $layout = 'main';
    public  $pageTheme="";
    public function init(){
        $this->enableCsrfValidation = false;
        $this->pageTheme=Yii::$app->params['pageTheme'];
    }

    public function actionIndex()
    {
        $getData=Yii::$app->request->get();
        $startTime=Yii::$app->request->get("startTime");
        $endTime=Yii::$app->request->get("endTime");
        $key=Yii::$app->request->get("key","");
        $content=Yii::$app->request->get("content","");
        $pageLimit= Yii::$app->request->get("limit");
        if($pageLimit=="") {
            $pageLimit=20;
        }
        $model=Member::find();
        if($startTime){
            $model->andWhere([">=","admin_add_time",strtotime($startTime)]);
        }
        if($endTime){
            $model->andWhere(["<=","admin_add_time",strtotime($endTime)]);
        }
        if($content){
            if($key=="admin_id"){
                $model->where(["admin_id"=>$content]);
            }
            else{
                $model->where(["like","admin_name",$content]);
            }
        }
        $count=$model->count();
        $page       = new page($count);
        if($this->pageTheme!=""){
            $page->setConfig('theme',$this->pageTheme);
        }
        $show       = $page->show();
        $memberList =$model->offset($page->firstRow)->limit($page->listRows)->asArray()->all();
        return $this->render("index", ["memberList"=>$memberList,"page"=>$show,"request"=>$getData]);
    }

    public function actionCreate()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $returnData=array();
        $model=new Member();
        $post=Yii::$app->request->post();
        $result=$model->member_add($post);
        if($result){
            $returnData["code"]=true;
            $returnData["tip"]="新增成功!";
            $returnData["data"]=["id"=>$result];
        }
        else{

            $error=$this->getFirstError($model);
            $returnData["code"]=false;
            $returnData["tip"]="新增失败!";
            $returnData["data"]=$error;
        }
        return $returnData;

    }


    public function  actionUpdate($member_id){
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new Member();
        $post=Yii::$app->request->post();
        $post["member_id"]=$member_id;
        $result=$model->member_edit($post);
        if($result){
            $returnData["code"]=true;
            $returnData["tip"]="修改成功!";
            $returnData["data"]=["id"=>$result];
        }
        else{
            $returnData["code"]=false;
            $returnData["tip"]="修改失败!";
            $returnData["data"]=[];
        }
        return $returnData;
    }

    public  function  actionView($member_id){
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new Member();
        $result=$model->get_view_by_id($member_id);
        $result=ArrayHelper::toArray($result);
        if($result){
            $returnData["code"]=true;
            $returnData["tip"]="查找成功!";
            $returnData["data"]=$result;
        }
        else{
            $returnData["code"]=false;
            $returnData["tip"]="查找失败!";
            $returnData["data"]=[];
        }
        return $returnData;
    }


    public function actionDelete($member_id){
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new Member();
        $result=$model->member_delete($member_id);
        if($result){
            $returnData["code"]=true;
            $returnData["tip"]="删除成功!";
            $returnData["data"]=["id"=>$result];
        }
        else{
            $returnData["code"]=false;
            $returnData["tip"]="删除失败!";
            $returnData["data"]=[];
        }
        return $returnData;
    }

    protected  function  getFirstError($model){

      return  array_values($model->getFirstErrors())[0];
    }


}
