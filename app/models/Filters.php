<?php

namespace app\models;

class Filters extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'catalog_filters';
    }
    
        public function getProductsFilter()
        {
            return $this->hasMany(ProductsFilters::className(), ['filter_id' => 'id']);
        }
        
        
        public function getChilds()
        {
            return $this->hasMany(self::className(), ['parent_id' => 'id']);
        }          
    
}   