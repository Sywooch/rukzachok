<?php

namespace app\modules\admin\models;
use Yii;

class Orders extends \yii\db\ActiveRecord
{
    public $labels;
    public static function tableName()
    {
        return 'orders';
    }
	
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['user_id','adress','body','total','status','email','patronymic','surname',
                            'comment','labels','date_dedline','phone','phone2','numbercard','delivery',
                            'declaration','stock','consignment','payment', 'insurance',
                            'amount_imposed','shipping_by','city','date_time', 'id' ], 'safe'],
                        //[['image'], 'file', 'extensions'=>'jpg, gif, png', 'skipOnEmpty'=>true],
                    ];
	}	
	
	public function attributeLabels()
	{
		return [
			'id'=>'№ заказа',
                        'name'=>'Имя',
			'phone'=>'Телефон',
                        'phone2'=>'Телефон 2',
			'adress'=>'Адрес',
                        'body'=>'Сообщение',
                        'reserve'=>'Резерв',
                        'status'=>'Статус',
                        'email'=>'E-mail',
                        'patronymic'=>'Очество',
                        'surname'=>'Фамилия',
                        'total'=>'Сумма',
                        'labels'=>'Метки',
                        'label'=>'Метка',
                        'comment'=>'Комментарий менеджера',
                        'date_dedline'=>'Дедлайн',
                        'numbercard'=>'№ карточки',
                        'delivery'=>'Доставка',
                        'declaration'=>'Декларация №',
                        'stock'=>'№ склада',
                        'consignment'=>'№ накладной',
                        'payment'=>'Способ оплаты',
                        'insurance'=>'Страховка',
                        'amount_imposed'=>'Сумма наложенного',
                        'shipping_by'=>'Отправка за счет',
                        'city'=>'Город'
		];
	}
        
	public function beforeSave($insert) {
		return parent::beforeSave($insert);
	}
        
        public function beforeDelete() {
            return parent::beforeDelete();
        }
        
        public function getUser()
        { 
          return $this->hasOne(User::className(), ['id' => 'user_id']);
        }
        

        
}        