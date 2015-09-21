<?php

namespace app\models;
use app\models\ProductsType;

class Type extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'catalog_type';
    }
    
        public function getProductsType()
        {
            return $this->hasMany(ProductsType::className(), ['type_id' => 'id']);
        }      
        public function getProductsFasovka()
        {
            return $this->hasMany(ProductsFasovka::className(), ['product_id'=>'ProductsType.product_id']);
        }     
}  