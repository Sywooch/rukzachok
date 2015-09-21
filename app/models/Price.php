<?php

namespace app\models;

use Yii;

class Price extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'price';
    }
    
    public function attributeLabels()
    {
        return [
            'product_name' => 'Название',
            'date_time'=>'Дата',
        ];
    }    
    
	public function beforeSave($insert) {
            $this->user_id = Yii::$app->user->id;
            $this->date_time = new \yii\db\Expression('NOW()');
            return parent::beforeSave($insert);
	}
        
        public function beforeDelete() {
            return parent::beforeDelete();
        } 
        
        public function getProduct()
        { 
          return $this->hasOne(Products::className(), ['id' => 'product_id']);
        }          
    
}    
