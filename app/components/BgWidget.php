<?php
namespace app\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\View;
use app\models\Bg;

class BgWidget extends Widget{
	public $bg;
	
	public function init(){
		parent::init();
                $view = Yii::$app->getView();
                $view->registerJs("
                    var heightR = $('.f').height();// высота экрана
                    var widthR = $(window).width();// ширина экрана

                    $('#bg').css({'height':heightR+100}); 
                ", View::POS_READY, 'bg');                 
		$this->bg = Bg::find()->orderBy('RAND()')->one();
	}
	
	public function run(){         
		return '<a id="bg" style="width:100%;height:100%;position:absolute;z-index:-1;background: url('.Yii::$app->request->baseUrl.'/upload/bg/'.$this->bg->image.') center top no-repeat;" href="'.$this->bg->url.'" title="'.$this->bg->title.'"></a>
';
	}
}
?>