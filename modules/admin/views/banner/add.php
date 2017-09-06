<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>

<?php
    if (Yii::$app->session->hasFlash('info')) {
        echo '<div class="alert alert-danger well-sm" role="alert">'.Yii::$app->session->getFlash('info').'</div>';
    }
    $form=ActiveForm::begin([
         "fieldConfig"=>[
             "template"=> '{label}{input}{error}'
         ],
         "options"=>[
             "class"=>"form-horizontal",
             "enctype"=>"multipart/form-data",
             "method "=>"post",
             "action"=>Url::toRoute(['area/add'])
         ]
    ]);
    echo $form->field($model,'banner_name')->textInput(["class"=>"form-control","id"=>"banner_name","name"=>"banner_name"]);
    echo $form->field($model,"banner_image")->fileInput(["class"=>"form-control","id"=>"banner_image","name"=>"banner_image"]);
    echo $form->field($model,"banner_status")->inline(true)->radioList(
        [1 => '启用', 2 => '禁用'],
        ["class"=>"form-control","id"=>"banner_status","name"=>"banner_status"]
    );
    /*echo $form->field($model,"banner_category")->dropDownList(array(), ['id' => 'banner_category']);*/
    echo $form->field($model,"banner_sort")->textInput(["class"=>"form-control","id"=>"banner_sort","name"=>"banner_sort"]);

?>

<div class="form-group">
    <div class="col-sm-2"></div>
    <div class=" col-sm-8">
        <?php echo Html::submitButton('提交', ['class' => 'btn btn-primary']); ?>
        <?php echo Html::resetButton('重置', ['class' => 'btn btn-default']); ?>

    </div>
</div>


<?php ActiveForm::end(); ?>