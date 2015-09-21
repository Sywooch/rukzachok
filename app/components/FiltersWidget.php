<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

use app\models\Filters;
use app\models\ProductsFilters;

class FiltersWidget extends Widget{
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
            if(!empty($_GET['filters']))$l = explode(';',$_GET['filters']);
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
            if(!empty($_GET['filters']))$l = explode(';',$_GET['filters']);
            else $l = array();
            foreach($l as $key=>$q){
             if($id==$q){return true;}
            }
            return false;
        }
	
	public function run(){
            if(!empty($_GET['filters']))$l = explode(';',$_GET['filters']);
            else $l = array();
            
        $out = '';
	$items = Filters::find()->where(['parent_id'=>0])->all();
        foreach($items as $item):
                                $out.='<div class="filters">
					<div class="begin">'.$item->name.'</div>
					<ul>';
                $childs = Filters::find()->where(['parent_id'=>$item->id,'catalog_id'=>$this->catalog_id])->innerJoinWith(['productsFilter'])->innerJoin('mod','mod.product_id=productsFilters.product_id')->orderBy('name DESC');
                foreach($items as $key=>$it){
                    $f = [];$fp = [];
                    foreach($it->childs as $c){
                        
                        if(in_array($c->id, $l)){$f[] = $c->id;$fp[] = $c->parent_id;}
                    }
                    if(count($f)>0 && !in_array($item->id, $fp))$childs->leftJoin('productsFilters as pf_'.$key, 'pf_'.$key.'.product_id = productsFilters.product_id')->andWhere(['pf_'.$key.'.filter_id'=>$f]);                          
                }
                foreach($childs->all() as $child): 
                    $filters = $this->filters_param($child->id);
                    $link = Url::to(['products/index','translit'=>$this->translit,'brends'=>(!empty($_GET['brends'])?$_GET['brends']:null),'filters'=>$filters]);
                    $out.='<li>'.Html::checkbox('filter[]', $this->cheched($child->id), ['value' => $child->id,'onClick'=>"document.location='".urldecode($link)."';"]).' <a href="'.urldecode($link).'">' .$child->name.'</a></li>';
		endforeach;
					$out.='</ul>
				</div>';
        endforeach;            
		return $out;
	}
}
?>