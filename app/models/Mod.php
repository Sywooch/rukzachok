<?php

namespace app\models;
use yii\web\Session;

class Mod extends \yii\db\ActiveRecord
{   public $count;
    public $sum_cost;
    public $product_name;
    //public $image;
    public $translit;
    public $translit_rubric;
    private $data;
    
    public static function tableName()
    {
        return 'mod';
    }

    public function getImageAvator(){
        return (is_file('upload/mod/ico/'.$this->image))?$this->image:'notpic.gif';
    }
    
	public function addBasket($mod_id,$count){
		$session=new Session;
                $session->open();
                $data = $session['basket'];
                $i = 0; 
		if(isset($session['basket'])){
		foreach($session['basket'] as $key=>$basket){
			if($mod_id == $basket['id']){$data[$key]['count'] += $count;$session['basket'] = $data;$i++;}
		}}
                if($i == 0){$data[] = array('id'=>$mod_id, 'count'=>$count);$session['basket'] = $data;}
		//print_r($_SESSION['basket']);
	}   
        
	public function rowBasket(){
		$session=new Session;
                $session->open();            
		$cost = 0;$count = 0;
		if(isset($session['basket']) && count($session['basket'])){
			
			foreach($session['basket'] as $product){
				//$cost += ($this->getModCost($product['id'])*$product['count']);
				$count += $product['count'];
			}
			//$count = count($_SESSION['basket']);	
		}
		return  (object) array('cost'=>$cost,'count'=>$count);
	}
        
        
	public function getBasketMods(){
		$session=new Session;
                $session->open(); 
                $products = array();
		if(empty($session['basket']))return array();
                foreach($session['basket'] as $product){
			$row = Mod::find()->select(['mod.*','products.name as product_name','products.image','products.translit','catalog.translit as translit_rubric'])
                                ->where(['mod.id'=>$product['id']])
                                ->leftJoin('products', 'products.id = mod.product_id')
                                ->leftJoin('catalog', 'catalog.id = products.catalog_id')
                                ->one();
			$row->count = $product['count'];
			$row->sum_cost = $product['count'] * $row->cost;
			$products[] = $row;
		}
	return $products;	
	}
        
	public function getSumCost(){
            	$session=new Session;
                $session->open(); 
		$cost = 0;
		if(empty($session['basket']))return false;
                foreach($session['basket'] as $product){
			$cost += ($this->getModCost($product['id'])*$product['count']);
		}
	return $cost;	
	}
        
        private function getModCost($mod_id){
            $mod = Mod::find()->where(['id'=>$mod_id])->one();
            return $mod->cost;
        }
        
	public function updateBasket($row){
		$session=new Session;
                $session->open();            
		
                //$data = array();

			if($row['count']>0) $this->data[] = array('id'=>$row['id'], 'count'=>$row['count']);
                        $session['basket'] = $this->data;    
	}
        
        public function clearBasket(){
           $session=new Session;
            $session->open();
            $session['basket'] = null;
        }
        
        public function deleteBasketMod($id){
		$session=new Session;
                $session->open();
                $basket = $session['basket'];
                foreach($basket as $key=>$product){
                    if($id == $product['id'])unset($basket[$key]);
                }
                $session['basket'] = $basket;
        }        
    
}  