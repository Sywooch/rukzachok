<?php
namespace app\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;
use yii\web\Session;

class CompareWidget extends Widget{
	public $out;
	
	public function init(){
		parent::init();
                $session=new Session;
                $session->open();
		if(!empty($session['compare'])){
                    $this->out = '<a href="'.Url::to(['products/compare']).'" title="Сравнение">Сравнение</a>';
                }
	}
	
	public function run(){         
		return $this->out;
	}
}
?>