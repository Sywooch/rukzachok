<?php

namespace app\models;

class OrdersProducts extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'orders_products';
    }
    
    public function rules()
    {
        return [
            [['order_id'], 'required'],
            //['email', 'email'],
            [['product_name','name','cost','count','sum_cost','mod_id','art'], 'safe'],
        ];
    }
    
    
	public function attributeLabels()
	{
		return [
			'product_name'=>'Продукт',
			'name'=>'Вид',
                        'art'=>'Артикул',
                        'cost'=>'Цена за один',
			'count'=>'Кол.',
                        'sum_cost'=>'Сумма',
		];
	}

    public function getMod()
    {
        return $this->hasOne(Mod::className(), ['id' => 'mod_id']);
    }
}  