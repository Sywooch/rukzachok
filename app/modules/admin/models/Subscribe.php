<?php

namespace app\modules\admin\models;

class Subscribe extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'subscribe';
    }
    
    public function rules()
    {
        return [
            [['email','sale'], 'required'],
            [['email'], 'email'],
            [['email'], 'is_email'],
        ];
    }
    
    public function is_email($attribute){
		if(self::find()
			->where('email = :email', [':email' => $this->email])
			->exists())
            $this->addError('email','Такой email уже есть.');        
    }
    
}   