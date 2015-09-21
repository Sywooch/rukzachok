<?php

namespace app\models;
use app\models\Products;

class Brends extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'catalog_brends';
    }
        public function getProducts()
        {
            return $this->hasMany(Products::className(), ['brend_id' => 'id']);
        }     
}  