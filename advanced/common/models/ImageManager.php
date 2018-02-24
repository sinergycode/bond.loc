<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "image_manager".
 *
 * @property int $id
 * @property string $name
 * @property string $class
 * @property int $item_id
 * @property string $alt
 */
class ImageManager extends \yii\db\ActiveRecord
{
    public $attachment; // добавляем
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image_manager';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'class', 'item_id'], 'required'],
            [['item_id', 'sort'], 'integer'],
            [['sort'], 'default', 'value' => function($model) {
                                                $count = ImageManager::find()->andWhere(['class' => $model->class])->count();
                                                return ($count > 0) ? $count++ : 0;
            }],
            [['name', 'class', 'alt'], 'string', 'max' => 150],
            [['attachment'], 'image'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'class' => 'Class',
            'item_id' => 'Item ID',
            'alt' => 'alt',
        ];
    }
    
    public function getImageUrl() {
        if($this->name) {
            $path = str_replace('admin.', '', Url::home(true)) . 'uploads/images/' . $this->class . '/' . $this->name;
        }else {
            $path = str_replace('admin.', '', Url::home(true)) . 'uploads/images/no-image.svg';
        } 
        return  $path;
    }
    
    public function beforeDelete() {
        if(parent::beforeDelete()) {
            ImageManager::updateAllCounters(['sort' => -1], [
                'and', ['class' => 'blog', 'item_id' => $this->item_id], ['>', 'sort', $this->sort]
            ]);
            return true;
        }else {
            return false; 
        }
    }
}
