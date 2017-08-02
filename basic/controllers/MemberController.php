<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Member;

class MemberController extends Controller
{



    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $page= Yii::$app->request->get("page");
       /* var_dump(Yii::$app->request->get());
        exit;*/
        $page_limit= Yii::$app->request->get("page_limit");
        Yii::$app->response->format=Response::FORMAT_JSON;
        $memberCount=Member::find()->count();
        $memberList =  Member::find()->offset($page*$page_limit)->limit($page_limit)->asArray()->all();
        return ['code'=>false,'count'=>$memberCount,"data"=>$memberList];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionMemberAdd()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionMemberEdit()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
