<?php

namespace app\modules\admin\models;
use Yii;
use app\components\Translite;
use app\components\resize;
use yii\web\UploadedFile;

class Label extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'orders_label';
    }
	

   public function getNl(){
       return $this->name;
   }     
        
        
       
      
	

}
