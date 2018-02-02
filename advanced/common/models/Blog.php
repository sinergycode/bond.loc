<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $url
 * @property int $status_id
 * @property int $sort
 */
class Blog extends \yii\db\ActiveRecord
{
    
    public $tags_array;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            [['url'], 'unique'],
            [['text'], 'string'],
            [['status_id', 'sort'], 'integer'],
            [['sort'], 'integer', max => 99, 'min' => '1' ],
            [['title', 'url'], 'string', 'max' => 150],
            [['tags_array'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'url' => 'Url',
            'status_id' => 'Status ID',
            'sort' => 'Сортировка',
            'tags_array' => 'Тэги',
            'tagsAsString' => 'Тэги',
            'author.username' => 'Автор',
        ];
    }
    
    // возвращяет массив который будет использован в gridView
    public static function getStatusList() {
        return ['off', 'on'];    
    }
    
    public function getStatusName() {
        $list = self::getStatusList();
        return $list[$this->status_id];
    }
    
    public function getAuthor() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getBlogTag() {
        return $this->hasMany(BlogTag::className(), ['blog_id' => 'id']);
    }
    
    public function getTags() {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->via('blogTag');
    }

    // это событие запускается когда удаляется один блог $blog. Т.е. если мы удалим блог, то надо удалить и 
    // все связанные тэг. Мы удаляем не сами тэги из Teg а только связи из BlogTag для данного блога
    public function beforeDelete() {
        if(parent::beforeDelete()){
            BlogTag::deleteAll(['blog_id' => $this->id]);
            return true;
        }else {
            return false;
        }
    }
        
    // функия для index.php
    public function getTagsAsString() {
        $arr = ArrayHelper::map($this->tags, 'id', 'name');
        return  implode(', ', $arr);
    }
    
    // когда произошел запрос в базе данных - модели $blog заполнилась данными
    // нужно чтобы сразу после этого она в свою переменную $tags_array засунула данные из модели
    // происходит когда мы загрузили данные из базы в модель: когда мы нажимаем update в эту форму подтягиваются тэги которые связаны. 
    // Массив с объектами который хранится скармливаем виждету Select2 (tag-ключ, tag-значение - так нужно виждету)
    public function afterFind() {
//        $this->tags_array = $this->tags; // $blog->tags - от getTags. Запишется массив данных из таблицы tags с id = tag_id
        
        // альтернатива с сайте TRENER
        $this->tags_array = ArrayHelper::map($this->tags, 'name', 'name');
    }
    
//    // данные из $tags_array нужно сохранить
//    public function afterSave($insert, $changedAttributes) {
//        parent::afterSave($insert, $changedAttributes); // это объязательно для того чтобы срабатывала какая-то базовая логика
//
//        // После parent::afterSave можно написать любой произвольный код который мы хотим чтобы выполнился 
//        // после того как происходит сохранение модели $blog; В данном случае сохраним модель $blog_tag.
//        $arr = ArrayHelper::map($this->tags, 'id', 'id'); // здесь будут записи которые на данный момент существют
//        foreach ($this->tags_array as $one) { // перебор массива который содержит записи из таблицы tags с id = tag_id
//            if(!in_array($one, $arr)) { // если запись из tags с id = tag_id еще нету
//                $model = new BlogTag;
//                $model->blog_id = $this->id; // $this = $blog
//                $model->tag_id = $one; // 
//                $model->save();
////                echo 'else';
//            }
//            if(isset($arr[$one])) { // каждую запись которую записываем в  bd удаляем из $arr
//                unset($arr[$one]); 
//            }
//        }
//        // в $arr останутся только те записи которые нужно удалить
//        BlogTag::deleteAll(['tag_id'=>$arr,'blog_id' => $this->id]); // им можно пользоватся если в модели BlogTag 
//        // не добавлена какая-то логика в beforeDelete, afterDelete, 
//    }
    
    // альтернатива TRENER
    public function afterSave($insert, $changedAttributes) {
        
        parent::afterSave($insert, $changedAttributes);
        
        if(is_array($this->tags_array)) { // $this-tags_array может быть Null если убрать все тэги а так он массив
            $old_tags = ArrayHelper::map($this->tags, 'name', 'id'); // заганяем в эту переменную через нашу связь тэги. Здесь попадут данные которые були до сохранения - то что было
            foreach ($this->tags_array as $one_new_tag) { // $tags_array получаем через update (load через виджет) - то что нужно 
                if(isset($old_tags[$one_new_tag])) { // перебираем новые тэги (то что нужно)
                    unset($old_tags[$one_new_tag]); // проверяем существует ли в старых тегах элемент с ключем нового тэга. Если да то удаляем это значение. Здесь остаются только тэги которые надо удалить
                }else {
                    if($tg = $this->createNewTag($one_new_tag)) { // если не найдено тогда запускаем функцию которая создает тэг
                        Yii::$app->session->addFlash('success', 'Добавлен тег ' . $one_new_tag);
                    } else {
                        Yii::$app->session->addFlash('error', 'Тэг ' . $one_new_tag .  ' не добавился');
                    }
                }
            }
            BlogTag::deleteAll(['and', ['blog_id' => $this->id], ['tag_id' => $old_tags]]); // удалить все тэги в которых есть соответсвующие связи
        }else { // если удалили все тэги для блога 
            BloTag::deleteAll(['blog_id' => $this->id]); // то убираем в связывающую таблицу соответсвующие связи
        }
    }
    
    public function createNewTag($new_tag) {
        if(!$tag = Tag::find()->andWhere(['name' => $new_tag])->one()) { // ищем если есть уже такие тэги (при создании)
            $tag = new Tag(); // если нету, то создаем
            $tag->name = $new_tag;
            if(!$tag->save()) { // если произошли ошибки при сохранении 
                $tag = null;
            }
        } // если такой тэг нашелся, то все ок, новый создавать не надо
        if($tag instanceof Tag) { // если новый тэг сохранился то здесь имеем объект который является экземпляром класса Tag
            $blog_tag = new BlogTag(); // создаем новую связь
            $blog_tag->blog_id = $this->id;
            $blog_tag->tag_id = $tag->id;
            if($blog_tag->save()) { // если связь сохранилась
                return $blog_tag->id;
            }
        }
        return false;
    }
}
