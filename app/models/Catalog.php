<?php

namespace app\models;

class Catalog extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'catalog';
    }
    
    static public function getCatalogs($parent_id = 0){
       return self::find()->where(['parent_id'=>$parent_id])->orderBy('sort ASC')->with('childs')->all(); 
    }
    
    public function getChilds()
    {
        return $this->hasMany(self::className(), ['parent_id' => 'id'])->orderBy('sort ASC');
    }
    
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }   
    
}    