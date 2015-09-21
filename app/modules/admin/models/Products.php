<?php

namespace app\modules\admin\models;
use Yii;
use app\components\Translite;
use app\components\resize;
use yii\web\UploadedFile;

class Products extends \yii\db\ActiveRecord
{
    public $old_image;
    public $catalog_parent;
    public $catalog;
    public $catalog_parent_image;
    public $catalog_image;
    public $brend_name;

    public static function tableName()
    {
        return 'products';
    }
	
	public function rules()
	{
		return [
			[['name','brend_id'], 'required'],
			[['filters','type','catalog_id','catalog_parent_id','old_image','body','params','new','top','akciya','translit','meta_title','meta_keywords','meta_description'], 'safe'],
                        [['image'], 'file', 'extensions'=>'jpg, gif, png', 'skipOnEmpty'=>true],
                    ];
	}	
	
	public function attributeLabels()
	{
		return [
			'name'=>'Название',
			'body_ru'=>'Описание',
                        'char'=>'Характеристики',
			'sort'=>'Сорт.',
                        'image'=>'Изображения',
                        'fasovka'=>'Фасовка',
                        'type'=>'Типы',
                        'brend_id'=>'Бренд',
                        'top'=>'Топ',
                        'new'=>'Новинка',
                        'akciya'=>'Акция',
            'params'=>'Характеристики'
		];
	}
        
	public function beforeSave($insert) {
		
      
                if (!$this->translit)
			$this->translit = Translite::rusencode($this->name);
                
                
		if($image = UploadedFile::getInstance($this,'image')){			
			
                        $this->deleteImage($this->old_image);
                        //$this->image = $image;
			$this->image = time() . '_' . rand(1, 1000) . '.' . $image->extension;
                        $image->saveAs('upload/products/'.$this->image);
			
			$resizeObj = new resize('upload/products/'.$this->image);
			$resizeObj -> resizeImage(134, 200, 'crop');
                        $resizeObj -> saveImage('upload/products/ico/'.$this->image, 100);
			$resizeObj -> resizeImage(280, 400, 'crop');
                        $resizeObj -> saveImage('upload/products/big/'.$this->image, 100);
                }else $this->image = $this->old_image;
                
                

		return parent::beforeSave($insert);
	}
        
        public function afterSave($insert, $changedAttributes) {
                if(!$insert) {
                    ProductsFilters::deleteAll(['product_id' => $this->id]);
                }
                if(is_array($this->filters)) {
                    foreach ($this->filters as $filters) {
                        $ProductsFilters = new ProductsFilters();
                        $ProductsFilters->product_id = $this->id;
                        $ProductsFilters->filter_id = $filters;
                        $ProductsFilters->save();
                    }
                }
                
                
                if(!$insert) {
                    ProductsType::deleteAll(['product_id' => $this->id]);
                }
                if(is_array($this->type)) {
                    foreach ($this->type as $type) {
                        $ProductsType = new ProductsType();
                        $ProductsType->product_id = $this->id;
                        $ProductsType->type_id = $type;
                        $ProductsType->save();
                    }
                }


            if(!$insert) {
                ProductsParams::deleteAll(['product_id' => $this->id]);
            }
            if(!empty($this->params)) {
                $params = explode('=',$this->params);
                foreach($params as $param){
                    if(!empty($param)){
                        $arr = explode('*',$param);
                        $ProductsParams = new ProductsParams();
                        $ProductsParams->product_id = $this->id;
                        $ProductsParams->name = $arr[0];
                        $ProductsParams->size = $arr[1];
                        $ProductsParams->metka = $arr[2];
                        $ProductsParams->save();
                    }
                }
            }
            
            return parent::afterSave($insert, $changedAttributes);
            
        }
        
        public function beforeDelete() {
            $this->deleteImage($this->image); 
            return parent::beforeDelete();
        }
        
        public function getFilters()
        { 
            return $this->hasMany(Filters::className(), ['id' => 'filter_id'])->viaTable(ProductsFilters::tableName(), ['product_id' => 'id']);
        }
        
        public function setFilters($filters)
        {
            $this->filters = $filters;
        }
        
        public function getType()
        { 
            return $this->hasMany(Type::className(), ['id' => 'type_id'])->viaTable(ProductsType::tableName(), ['product_id' => 'id']);
        }
        
        public function setType($type)
        {
            $this->type = $type;
        }
        
        public function getBrends()
        { 
            return $this->hasMany(Brends::className(), ['id' => 'brend_id'])->viaTable(ProductsBrends::tableName(), ['product_id' => 'id']);
        }
        
        public function setBrends($brends)
        {
            $this->brends = $brends;
        }
        
      
        public function getCatalog()
        {
            return $this->hasOne(Catalog::className(), ['id' => 'catalog_id']);
        }
        
        public function getMods()
        {
            return $this->hasMany(Mod::className(), ['product_id' => 'id']);
        } 
        
        public function getFotos()
        {
            return $this->hasMany(Fotos::className(), ['product_id' => 'id']);
        }

        public function getParams(){
            if(empty($this->id))return;
            $params = ProductsParams::find()->where(['product_id' => $this->id])->all();
            $out = [];
            foreach($params as $param){
                $out[] = trim($param->name).'*'.trim($param->size).'*'.trim($param->metka);
            }
            return implode('=',$out);
        }

        public function setParams($params)
        {
            $this->params = $params;
        }
        
        public function deleteImage($file){ 
                        if(!empty($file)){
                            @unlink('upload/products/'.$file);
                            @unlink('upload/products/ico/'.$file);
                            @unlink('upload/products/big/'.$file);
                        }            
        }          
        
        
        
      
	

}
