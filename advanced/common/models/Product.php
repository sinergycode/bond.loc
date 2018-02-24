<?php

namespace common\models;

use Yii;
use common\models\Sklad;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $sklad_id
 * @property string $title
 * @property int $cost
 * @property int $type_id
 * @property string $text
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sklad_id', 'title', 'type_id'], 'required'],
            [['sklad_id', 'cost', 'type_id', 'date'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sklad_id' => 'Sklad ID',
            'title' => 'Title',
            'cost' => 'Cost',
            'date' => 'Дата',
            'type_id' => 'Type ID',
            'text' => 'Text',
        ];
    }
    
    public static function getTypeList() { // поскольку типов продукта несколько, то держать из в отдельную таблицу нету смысла
        return [
            'первый','второй','третий'
        ];
    }
    
    public function getSklad() {
        return $this->hasOne(Sklad::className(), ['id' => 'sklad_id']);
    }
    
    public function getSkladName() {
        return (isset($this->sklad)) ? $this->sklad->title : 'Не задан';
    }
    
    public function getTypeName() {
        $list = $this->getTypeList();
        return $list[$this->type_id];
    }
}
