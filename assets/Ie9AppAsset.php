<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Ie9AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $jsOptions = [
        'condition' => 'It IE 9',
        'position' => \yii\web\View::POS_HEAD,   // 这是设置所有js放置的位置
    ];
    public $js = [
        'js/html5shiv.js',
        'js/respond.js'
    ];


}
