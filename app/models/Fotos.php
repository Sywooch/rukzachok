<?php

namespace app\models;

class Fotos extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'products_fotos';
    }

    public function getImageAvator(){
        return (is_file('upload/fotos/ico/'.$this->image))?$this->image:'notpic.gif';
    }
    
}  