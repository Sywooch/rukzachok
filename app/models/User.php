<?php

namespace app\models;
use Yii;
use yii\rbac\DbManager;
use app\components\resize;
use yii\web\UploadedFile;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $password_repeat;
	public $role;
	public $verifyCode;
	public $old_image;

	
	public static function tableName()
    {
        return 'user';
    }

	public function rules()
	{
		return [
			[['username', 'password','phone','role','verifyCode','name','surname'], 'required','on'=>['person','company','customer']],
			[['verifyCode'], 'captcha','captchaAction'=>'reg/captcha','on'=>['person','company','customer']],
			[['password_repeat'], 'required','on'=>['person','company','customer','edit_person']],
			[['password_repeat'], 'password_repeat','on'=>['person','company','customer','edit_person']],
			[['username'], 'is_username','on'=>['person','company','customer']],
			[['username'], 'email','on'=>['person','company','customer','edit_person']],
			[['company'], 'required','on'=>['company']],
			
			[['username', 'password','phone','role','name','surname'], 'required','on'=>['edit_person','edit_customer','edit_company']],
			[['company'], 'required','on'=>['edit_company']],
                        [['sex','body','birth_day','birth_mouth','birth_year'], 'safe','on'=>['edit_person']],
			[['sex','status','children','body','old_image','birth_day','birth_mouth','birth_year'], 'safe','on'=>['edit_customer']],
                        [['body'], 'safe','on'=>['edit_company']],
                       // [['image'], 'file', 'extensions'=>'jpg, gif, png','skipOnEmpty'=>true,'on'=>['edit_person','edit_customer','edit_company']],
		];
	}	
	
	public function attributeLabels()
	{
		return [
			'username'=>'Логин (E-mail)',
			'password'=>'Пароль',
			'password_repeat'=>'Повторить пароль',
			'phone'=>'Телефон',
			'verifyCode'=>'Код проверки',
			'name'=>'Имя',
			'surname'=>'Фамилия',
			'company'=>'Компания',
			'sex'=>'Пол',
			'status'=>'Семейное положение',
			'children'=>'Дети',
			'edu'=>'Образование',
			'work'=>'Работа',
			'langs'=>'Иностранные языки',
			'prava'=>'Водительское удостоверение',
			'body'=>'О себе',
			'image'=>'Изображения',
		];
	}
	
	public function password_repeat($attribute){
		if($this->password != $this->password_repeat)
			$this->addError('password_repeat','Не правильный повтор пароля.');
	}

	public function is_username($attribute)
    {	
		if(User::find()
			//->where( ['username' => $this->username],['id!='.$_GET['id']] )
			->where('username = :username', [':username' => $this->username])
			->exists())
            $this->addError('username','Такой пользователь уже есть.');
    }
    
    public function sendMsg(){
                        $body = 'Вас приветствует сайт Rukzachok';
                        $body .= "\n\r";            
                        $body .= 'Ваш логин: '.$this->username;
                        $body .= "\n\r";
                        $body .= 'Ваш пароль: '.$this->password;

                        
            Yii::$app->mailer->compose()
                ->setTo($this->username)
                ->setFrom(['send@artweb.ua' => 'send'])
                ->setSubject('Rukzachok Ваш пароль')
                ->setTextBody($body)
                ->send();        
        
    }
	
		public function afterSave($insert, $changedAttributes)
		 {
			 parent::afterSave($insert, $changedAttributes);
/*
$auth = new DbManager;
$auth->init();
$role = $auth->createRole('company');
$auth->add($role);
$role = $auth->createRole('customer');
$auth->add($role);
*/
			 // установка роли пользователя
			 $auth = Yii::$app->authManager;
			 $role = $auth->getRole($this->role);
			 if (!$insert) {
				 $auth->revokeAll($this->id);
			 }
			 $auth->assign($role, $this->id);
                         
                         $this->sendMsg();
		 }

	public function beforeSave($insert) {
	

                $this->date_time = new \yii\db\Expression('NOW()');
                
                /**
		if($image = UploadedFile::getInstance($this,'image')){			
			
                        $this->deleteImage($this->old_image);
                        //$this->image = $image;
						$this->image = time() . '_' . rand(1, 1000) . '.' . $image->extension;
                        $image->saveAs('upload/profile/'.$this->image);
			
						$resizeObj = new resize('upload/profile/'.$this->image);
						$resizeObj -> resizeImage(240, 240, 'crop');
                        $resizeObj -> saveImage('upload/profile/ico/'.$this->image, 100);
                    }elseif(!empty($this->old_image)) $this->image = $this->old_image;
                  **/  
                
		return parent::beforeSave($insert);
	}

        public function beforeDelete() {
            //$this->deleteImage($this->image); 
            return parent::beforeDelete();
        }
        
        public function deleteImage($file){ 
                        if(!empty($file)){
                            @unlink('upload/profile/'.$file);
                            @unlink('upload/profile/ico/'.$file);
                           // @unlink('upload/fotos/big/'.$file);
                        }            
        }
        
        
        public function getOld(){
            if(empty($this->birth_year) || empty($this->birth_mouth) || empty($this->birth_day))return;
            $birthday = $this->birth_year.'-'.$this->birth_mouth.'-'.$this->birth_day;    
            if($birthday=="0000-00-00")return;	
            $birthday_timestamp = strtotime($birthday);
            $age = date('Y') - date('Y', $birthday_timestamp);
            if (date('md', $birthday_timestamp) > date('md')) {
              $age--;
            }
            return $age;
             
        }
        
        public function getOfferCustomer(){
            return $this->hasMany(OfferCustomer::className(), ['service_user_id' => 'id'])->where(['done'=>1]);
        }
        
        
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        
        /**Yii::$app->db->createCommand()
                            ->update('user', [ 
                                'time_online' => (time() + (10*60)),
                                ], 'id = '.$id)
                            ->execute(); **/       
        return static::find()->select(['user.*','auth_assignment.item_name as role'])->where(['id'=>$id])->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = user.id')->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
          return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
	
	public function getImageProfile(){
		return !empty($this->image) ? $this->image : 'user_photo.png';
	}	
}
