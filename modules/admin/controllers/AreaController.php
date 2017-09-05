<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Area;
use yii\helpers\ArrayHelper;
use app\helper\Helper;
use app\helper\page;
use app\helper\tree;
use yii\helpers\Url;
class AreaController extends BaseController
{

    public function init(){
        $this->enableCsrfValidation = false;
    }
    public function actionIndex(){
        $this->layout = 'main';
        $areaList =Area::find()->asArray()->all();
        //echo $model->createCommand()->getRawSql();
        foreach($areaList as $r) {
            $r["id"]=$r["area_id"];
            $r["parentId"]=$r["area_parent_id"];
            if($r["area_level"]==0||$r["area_level"]==1){
                $r['str_manage'] = '<a class="btn btn-primary btn-sm update" title="新增二级1" data-url="'.Url::toRoute(['area/add']).'?area_id='.$r['area_id'].'"><i class="fa fa-plus" aria-hidden="true"></i> </a>';
            }
            else{
                $r['str_manage']  ='<a class="btn btn-primary btn-sm" title="新增二级2" disabled="disabled" ><i class="fa fa-plus" aria-hidden="true"></i> </a>';
            }
            $r['str_manage'] .= '<a  class="btn btn-warning btn-sm update" title="会员修改" data-url="'.Url::toRoute(['area/update']).'?area_id='.$r['area_id'].'"><i class="fa fa-edit" aria-hidden="true"></i> </a>
                                         <a  class="btn btn-danger btn-sm delete"  title="会员删除" data-id="'.$r['area_id'].'" data-url="'.Url::toRoute(['area/delete']).'?area_id='.$r['area_id'].'"> <i class="fa fa-trash-o fa-lg"></i></a>';
            $array[] = $r;
        }
        $str  = "<tr id='row\$id'>
						<td align='center'><input name='listorders[\$id]' type='text' size='3' value='\$area_sort'></td>
						<td align='center'>\$id</td>
						<td  >\$spacer\$area_name</td>

						<td align='center'>\$area_add_time</td>
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
        if(Yii::$app->request->isPost){
            $model=new Area();
            $post=Yii::$app->request->post();
            if($post["area_parent_id"]=="0"){
                $post["area_level"]=0;
            }
            else{
                $areaParentInfo=Area::find()->where(["area_id"=>$post["area_parent_id"]])->asArray()->one();
                $post["area_level"]=$areaParentInfo["area_level"]+1;
            }
            $result=$model->area_add($post);
            if($result){
                return $this->sucess("新增成功",'/admin/admin/add');
            }
            else{
                $error=Helper::getFirstError($model);
                return $this->error($error);
            }
        }
        else{
            $areaId=Yii::$app->request->get("area_id",0);
            if($areaId==0){
                $areaList[]=[
                    "area_id"=>0,
                    "area_name"=>"一级"
                ];
            }
            else{
                $areaList=Area::find()->where(["area_id"=>$areaId])->asArray()->all();
            }
            return $this->render("add",['areaList'=>$areaList]);
        }
    }

    public function  actionUpdate($area_id){

        $this->layout = 'mainNotNavAndFooter';

        $model=new Area();
        $areaInfo=$model::findOne(['area_id'=>$area_id]);
        if(Yii::$app->request->isPost){
            $post=Yii::$app->request->post();
            $post["area_id"]=$area_id;
            $post["area_level"]=$areaInfo->area_level;
            $result=$model->area_edit($post);
            if($result){
                return $this->sucess("修改成功");
            }
            else{
                $error=Helper::getFirstError($model);
                return $this->error($error." 修改失败!");
            }
        }
        else{
            if($areaInfo['area_parent_id']==0){
                $areaList[]=[
                    "area_id"=>0,
                    "area_name"=>"一级"
                ];
            }
            else{
                $areaList=Area::find()->where(["area_id"=>$areaInfo['area_parent_id']])->asArray()->all();
            }
            return $this->render("update",['areaInfo'=>$areaInfo,"areaList"=>$areaList]);
        }
    }

    public  function  actionView($area_id){
        $model=new Area();
        $result=$model->get_view_by_id($area_id);
        $result=ArrayHelper::toArray($result);
        if($result){
            $returnData=Helper::returnData(true,$result,"查找成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"查找失败!");
        }
        return $returnData;
    }

    public function actionDelete($area_id){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model=new Area();
        $result=$model->area_delete($area_id);
        if($result){
            $returnData=Helper::returnData(true,["id"=>$result],"删除成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"删除失败!");
        }
        return $returnData;
    }


}
