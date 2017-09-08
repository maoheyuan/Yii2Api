<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

class BaseController extends Controller
{
    public  $pageTheme="";
    public function init(){
        $this->enableCsrfValidation = false;
        $this->pageTheme=Yii::$app->params['pageTheme'];
    }
    public function success($message="",$url="",$waitSecond=3)
    {
        if($url==""){
            $url = "javascript:history.back(-1);";
        }
        else{
            $url = Url::toRoute($url, true);
        }
        return $this->renderPartial("/base/success",
            [
                'message'=>$message,
                "jumpUrl"=>$url,
                'waitSecond'=>$waitSecond
            ]
        );
    }

    public function  error($message="",$url="",$waitSecond=3){
        if($url==""){
            $url = "javascript:history.back(-1);";
        }
        else{
            $url = Url::toRoute($url, true);
        }
        return $this->renderPartial("/base/error",
            [
                'message'=>$message,
                "jumpUrl"=>$url,
                'waitSecond'=>$waitSecond
            ]
        );
    }


}
