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

class CategoryController extends Controller
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

            $r['str_manage'] = '<a  class="btn btn-warning btn-sm update" title="会员修改" data-url="'.Url::toRoute(['category/update']).'?category_id='.$r['category_id'].'"><i class="fa fa-edit" aria-hidden="true"></i> </a>
                                         <a  class="btn btn-danger btn-sm delete"  title="会员删除" data-id="'.$r['category_id'].'" data-url="'.Url::toRoute(['category/delete']).'?category_id='.$r['category_id'].'"> <i class="fa fa-trash-o fa-lg"></i></a>';
            $array[] = $r;
        }
        $str  = "<tr id='row\$id'>
						<td align='center'><input name='listorders[\$id]' type='text' size='3' value='\$category_sort'></td>
						<td align='center'>\$id</td>
						<td  >\$spacer\$category_name</td>

						<td align='center'>\$category_add_time</td>
						<td align='center'>\$str_manage</td>
					</tr>";
        $tree =  new tree ($array);
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─','&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $list = $tree->get_tree(0, $str);
        return $this->render("index", ["list"=>$list]);
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
