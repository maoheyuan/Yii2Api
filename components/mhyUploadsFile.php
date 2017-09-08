<?php
namespace app\components;
use yii\web\UploadedFile;
use Yii;
/**
 * 自定义的组件类文件 mhyUploadsFile.php
 */
class mhyUploadsFile
{
    public  $savePath;
    const  FILE_TYPE_NOT_ALLOW=300;
    const FILE_NOT_EXITS=400;
    const FILE_SAVE_FAIL=500;
    public function uploadsImage($imageName,$savePath="",$suffixArray=array()){

        try{
            if($savePath!=""){
                $this->savePath=$savePath;
            }
            if(!file_exists($this->savePath)){
                mkdir($this->savePath);
            }
            if(empty($suffixArray)){
                $suffixArray=array('gif', 'jpg', 'jpeg', 'png');
            }
            $imageFileObject=UploadedFile::getInstanceByName($imageName);
            if($imageFileObject){
                if(!in_array(strtolower($imageFileObject->extension),$suffixArray)){
                    throw new \Exception('不允许的图片类型!',self::FILE_TYPE_NOT_ALLOW);
                }
                $md5Name=md5(date("Y-m-d H:i:s"));
                $saveImageName=$imageFileObject->baseName."_".$md5Name.'.' .$imageFileObject->extension;
                $saveImagePath=$this->savePath.DIRECTORY_SEPARATOR.$saveImageName;

                if($imageFileObject->saveAs($saveImagePath)){
                    return [
                        "status"=>1,
                        "msg"=>"保存成功",
                        "data"=>$saveImageName
                    ];
                }
                else{
                    throw new \Exception("保存失败",self::FILE_SAVE_FAIL);
                }
            }
            else{
                throw new \Exception('图片不存在!',self::FILE_NOT_EXITS);
            }
        }
        catch(\Exception $e){
            return [
                "status"=>0,
                "msg"=>$e->getMessage(),
                "data"=>$e->getCode()
            ];
        }
    }



}
?>