<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/8
 * Time: 14:58
 */

namespace app\helper;


class Helper {
    public static  function returnData($status=false,$data=[],$tip=""){
        $returnData["status"]=$status;
        $returnData["tip"]=$tip;
        $returnData["data"]=$data;

        return $returnData;
    }

    public  static  function getFirstError($model){
        return  array_values($model->getFirstErrors())[0];
    }


    public static  function create_page($count,$curent_page,$page_limit){

        $count_page=$count/$page_limit;
        $pageInfo=array();
        $pageInfo["curent_page"]=$curent_page;
        $pageInfo["prev_page"]=$curent_page-1>=0 ?$curent_page-1:0;
        $pageInfo["next_page"]=$curent_page+1<=$count_page?$curent_page+1:$count_page;
        $pageInfo["first_page"]=0;
        $pageInfo["last_page"]=$count_page;
        $pageInfo["count_page"]=$count_page;
        return $pageInfo;
    }

}