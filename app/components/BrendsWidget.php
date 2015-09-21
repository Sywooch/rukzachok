<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

use app\models\Brends;
use app\models\ProductsFilters;

class BrendsWidget extends Widget{
	public $message;
        public $translit;
        public $catalog_id;
	
	public function init(){
		parent::init();
		if($this->message===null){
			$this->message= 'Welcome User';
		}else{
			$this->message= 'Welcome '.$this->message;
		}
	}
        
        private function filters_param($id){
            if(!empty($_GET['brends']))$l = explode(';',$_GET['brends']);
            else $l = array();
            $f=0;
            foreach($l as $key=>$q){
             if($id==$q){$f++;unset($l[$key]);}
            }

            if($f==0)$l[] = $id;

            sort($l);
            return !empty($l)?implode(";",$l):null;
        }
        
        private function cheched($id){
            if(!empty($_GET['brends']))$l = explode(';',$_GET['brends']);
            else $l = array();
            foreach($l as $key=>$q){
             if($id==$q){return true;}
            }
            return false;
        }
	
	public function run(){
            if(!empty($_GET['brends']))$l = explode(';',$_GET['brends']);
            else $l = array();
            
        $out = '';


                                $out.='<div class="filters">
					<div class="begin">Бренды</div>
					<ul>';
                $childs = Brends::find()->innerJoinWith(['products'])->innerJoin('mod','mod.product_id=products.id')->orderBy('id');
                $childs->andWhere(['products.catalog_id'=>$this->catalog_id]);    
                foreach($childs->all() as $child): 
                    $filters = $this->filters_param($child->id);
                    $link = Url::to(['products/index','translit'=>$this->translit,'brends'=>$filters,'filters'=>(!empty($_GET['filters'])?$_GET['filters']:null)]);
                    $out.='<li>'.Html::checkbox('brends[]', $this->cheched($child->id), ['value' => $child->id,'onClick'=>"document.location='".urldecode($link)."';"]).' <a href="'.urldecode($link).'">' .$child->name.'</a></li>';
		endforeach;
					$out.='</ul>
				</div>';
           
		return $out;
	}
}
?>