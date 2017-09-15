<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
    <style>
        .form-control{
            height: auto !important;
        }
    </style>
<?php
$form=ActiveForm::begin([
    "fieldConfig"=>[
        "template"=> '
                <label class="col-sm-2 control-label">{label}</label>
                <div class="col-sm-8">
                {input}{error}
                </div>
                '
    ],
    "options"=>[
        "class"=>"form-horizontal inline-input",
        "enctype"=>"multipart/form-data",
        "method "=>"post",
        "action"=>Url::toRoute(['category/add'])
    ]
]);
?>
<?=$form->field($category,"category_parent_id")->dropDownList($categoryList, ['prompt' => '请选择分类']);?>
<?=$form->field($category,'category_name')->textInput(["class"=>"form-control"]);?>
<?=$form->field($category,"category_image_path")->fileInput(["class"=>"form-control","name"=>"category_image"]);?>
<?=$form->field($category,"category_status")->radioList([1 => '启用', 2 => '禁用'], ["class"=>"form-control"]);?>
<?=$form->field($category,"category_sort")->textInput(["class"=>"form-control","value"=>100]); ?>
<div class="form-group">
    <div class=" col-sm-8">
    </div>
    <div class=" col-sm-4">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']); ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']); ?>

    </div>
</div>
<?php ActiveForm::end(); ?>