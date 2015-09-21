<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\admin\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
   // public $basePath = '@webroot';
   // public $baseUrl = '@web';
    public $sourcePath = '@app/modules/admin/assets';
	public $css = [
        'css/admin.css',
    ];
    public $js = [
        //'js/jquery-1.11.3.min.js',
        //'js/site.js',
    ];
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
