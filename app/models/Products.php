<?php

namespace app\models;
use Yii;
use app\models\Fasovka;
use app\models\Type;
use app\models\Brends;

class Products extends \yii\db\ActiveRecord
{
    public $fasovka;
    public $type;
    public $brends;
    public $filter;
    public $maxCost = 100;
    public $minCost = 1;
    
    public static function tableName()
    {
        return 'products';
    }
    
	public function rules()
	{
		return [
			[['fasovka','type','brends','minCost','maxCost'], 'safe'],
                    ];
	}    
    
	public function attributeLabels()
	{
		return [
			'fasovka'=>'Фасовка',
                        'type'=>'Типы',
                        'brends'=>'Бренды',
                        'maxCost'=>'до',
                        'minCost'=>'от',
		];
	}
        
        public function getCatalog()
        {
            return $this->hasOne(Catalog::className(), ['id' => 'catalog_id']);
        }         
        public function getMods()
        {
            return $this->hasMany(Mod::className(), ['product_id' => 'id'])->where('active=0 and cost>0');
        }
        public function getCost()
        {
            return $this->hasOne(Mod::className(), ['product_id' => 'id'])->where('active=0 and cost>0')->orderBy('cost');
        }
        public function getFilter()
        {
            return $this->hasMany(ProductsFilters::className(), ['product_id' => 'id']);
        }
        public function getType()
        {
            return $this->hasMany(ProductsType::className(), ['product_id' => 'id']);
        }
        public function getBrend()
        {
            return $this->hasOne(Brends::className(), ['id' => 'brend_id']);
        }        
        public function getFotos()
        {
            return $this->hasMany(Fotos::className(), ['product_id' => 'id']);
        }
        public function getParams()
        {
            return $this->hasMany(ProductsParams::className(), ['product_id' => 'id']);
        }
        public function getImageAvator(){
            return (is_file('upload/products/ico/'.$this->image))?$this->image:'notpic.gif';
        }
        
        
        
        public function fasovkaAll($catalog_id){
            $fasovka = Fasovka::find()->where(['catalog_id'=>$catalog_id])->innerJoinWith(['productsFasovka']);
             if(!empty($this->type)){
               $fasovka->leftJoin('productsType', 'productsType.product_id = productsFasovka.product_id')->andWhere(['productsType.type_id'=>$this->type]);
             }
             if(!empty($this->brends)){
               $fasovka->leftJoin('productsBrends', 'productsBrends.product_id = productsFasovka.product_id')->andWhere(['productsBrends.brend_id'=>$this->brends]);
             }
             return $fasovka->asArray()->orderBy('name')->all();
        }
        
        public function typeAll($catalog_id){
            $type = Type::find()->where(['catalog_id'=>$catalog_id])->innerJoinWith(['productsType']);
                if(!empty($this->fasovka)){
                    $type->leftJoin('productsFasovka', 'productsFasovka.product_id = productsType.product_id')->andWhere(['productsFasovka.fasovka_id'=>$this->fasovka]);
                }
                if(!empty($this->brends)){
                    $type->leftJoin('productsBrends', 'productsBrends.product_id = productsType.product_id')->andWhere(['productsBrends.brend_id'=>$this->brends]);
                } 
             return $type->asArray()->orderBy('name')->all();
        } 
        
        public function brendsAll($catalog_id){
            $brends = Brends::find()->where(['catalog_id'=>$catalog_id])->innerJoinWith(['productsBrends']);
                if(!empty($this->fasovka)){
                    $brends->leftJoin('productsFasovka', 'productsFasovka.product_id = productsBrends.product_id')->andWhere(['productsFasovka.fasovka_id'=>$this->fasovka]);
                }
                if(!empty($this->type)){
                    $brends->leftJoin('productsType', 'productsType.product_id = productsBrends.product_id')->andWhere(['productsType.type_id'=>$this->type]);
                }  
             return $brends->asArray()->orderBy('name')->all();
        }        
      
} 