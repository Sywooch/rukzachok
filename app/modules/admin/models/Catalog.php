<?php

namespace app\modules\admin\models;
use Yii;
use app\components\Translite;
use app\components\resize;
use yii\web\UploadedFile;

class Catalog extends \yii\db\ActiveRecord
{
    public $old_image;
    
    public static function tableName()
    {
        return 'catalog';
    }
	
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['parent_id','sort','old_image','body','translit','meta_title','meta_keywords','meta_description'], 'safe'],
                        [['image'], 'file', 'extensions'=>'jpg, gif, png', 'skipOnEmpty'=>true],
                    ];
	}	
	
	public function attributeLabels()
	{
		return [
			'name'=>'Название',
			'body'=>'Описание',
			'sort'=>'Сорт.',
                        'parent_id'=>'Родитель',
                        'image'=>'Изображения',
		];
	}
        
	public function beforeSave($insert) {
		
                if(empty($this->parent_id))$this->parent_id = 0;
            
                if (!$this->translit)
			$this->translit = Translite::rusencode($this->name);
                
                
		if($image = UploadedFile::getInstance($this,'image')){			
			
                        $this->deleteImage($this->old_image);
                        //$this->image = $image;
			$this->image = time() . '_' . rand(1, 1000) . '.' . $image->extension;
                        $image->saveAs('upload/catalog/'.$this->image);
			
			$resizeObj = new resize('upload/catalog/'.$this->image);
			$resizeObj -> resizeImage(195, 186, 'crop');
                        $resizeObj -> saveImage('upload/catalog/ico/'.$this->image, 100);
		}else $this->image = $this->old_image;                

		return parent::beforeSave($insert);
	}
        
        public function beforeDelete() {
            $this->deleteImage($this->image); 
            return parent::beforeDelete();
        }
        
        public function deleteImage($file){ 
                        if(!empty($file)){
                            @unlink('upload/catalog/'.$file);
                            @unlink('upload/catalog/ico/'.$file);
                        }            
        }          
        
        
        
    public function getDataTree($type = 'list',$parent_id = 0,$level = -1,&$list = array())
    {	
	//global $key;
	//print_r($arr);
		$res = Catalog::find()->where(
								'parent_id=:parent_id',
								[':parent_id'=>$parent_id]
                                                               
								)->orderBy('id')->all();
                //print_r($res);exit;
		$level++;
		
		foreach($res as $row){
			//$row->level = $level;
			$row->name = str_repeat("---", $level) . $row->name;
			$list[] = $row;
			$this->getDataTree($type,$row->id,$level, $list);
			
		}

		return  $list ;
    }        
	

}

