<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii;
use yii\base\DynamicModel ;
use app\modules\admin\models\Admin;
/**
 * Default controller for the `admin` module
 */
class PublicController extends Controller
{


    public  $layout = 'mainNotNavAndFooter';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public  function  actionLogin(){

        $adminName=Yii::$app->request->post("adminName","");
        $password=Yii::$app->request->post("password","");
        if(Yii::$app->request->isPost){
            $session = Yii::$app->session;
            $validate = DynamicModel::validateData(
                compact('adminName', 'password'),
                [
                    ['adminName','required', 'message' => '用户不能为空'],
                    ['password', 'required', 'message' => '密码不能为空'],
                ]
            );
            if ($validate->hasErrors()) {
                $session->setFlash('loginError',array_values($validate->getFirstErrors())[0]);
                return $this->render("login",['adminName' => $adminName]);
            }
            $adminInfo=Admin::find()->where(['admin_name' => $adminName])->orderBy('admin_id DESC')->asArray()->one();
            if(!$adminInfo){
                $session->setFlash('loginError',"用户不存在!");
                return $this->render("login",["adminName"=>$adminName]);
            }
            if(md5($password)!=$adminInfo['admin_password']){
                $session->setFlash('loginError',"密码不正确!");
                return $this->render("login");
            }
            $session->set('adminInfo', $adminInfo);
            return $this->redirect(["default/index"]);
        }
        return $this->render("login",["adminName"=>$adminName]);
    }
}
