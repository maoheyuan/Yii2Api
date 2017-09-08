<?php
namespace app\components;
use yii\web\UploadedFile;
/**
 * 自定义的组件类文件 mhyUploadsFile.php
 */
class mhyUploadsFile
{
    public  $savePath;
    public function uploadsImage($imageName,$savePath="",$suffixArray=array()){
        if($savePath!=""){
            $this->savePath=$savePath;
        }
        if(empty($suffixArray)){
            $suffixArray=array('gif', 'jpg', 'jpeg', 'png');
        }

        $imageFileObject=UploadedFile::getInstanceByName($imageName);
        if($imageFileObject){
            if(!in_array(strtolower($imageFileObject->extension),$suffixArray)){
                return false;
            }
            $md5Name=md5(date("Y-m-d H:i:s"));
            $saveImageName=$imageFileObject->baseName."_".$md5Name.'.' .$imageFileObject->extension;
            $saveImagePath=$this->savePath.DIRECTORY_SEPARATOR.$saveImageName;
            if($imageFileObject->saveAs($saveImagePath)){
                return $saveImageName;
            }
        }
        return false;
    }

}
?>