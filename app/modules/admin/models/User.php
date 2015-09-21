<?php

namespace app\modules\admin\models;

use Yii;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $password_repeat;
	
	public static function tableName()
    {
        return 'user';
    }
	
	public function rules()
	{
		return [
			[['username', 'password'], 'required'],
                        [['group_id'], 'safe'],
			[['password_repeat'], 'required', 'on'=>'save'],
			[['password_repeat'], 'password_repeat', 'on'=>'save'],
			[['username'], 'is_username', 'on'=>'save'],
		];
	}	
	
	public function attributeLabels()
	{
		return [
			'username'=>'Логин',
			'password'=>'Пароль',
			'password_repeat'=>'Повторить пароль',
                        'group_id'=>'Группа',
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
			->where('username = :username and id != :id', [':username' => $this->username, ':id' => $this->id])
			->exists())
            $this->addError('username','Такой пользователь уже есть.');
    }


		public function afterSave($insert, $changedAttributes)
		 {
			 parent::afterSave($insert, $changedAttributes);
			 if($insert){
                         // установка роли пользователя
			 $auth = Yii::$app->authManager;
			 $role = $auth->getRole('admin');
			 if (!$insert) {
				 $auth->revokeAll($this->id);
			 }
			 $auth->assign($role, $this->id);
                         }
		 }


		public function afterDelete(){
			parent::afterDelete();
			$auth = Yii::$app->authManager;
			$auth->revokeAll($this->id);
		}	


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
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
        
        public function getGroup()
        { 
          return $this->hasOne(UserGroup::className(), ['id' => 'group_id']);
        }          
}
