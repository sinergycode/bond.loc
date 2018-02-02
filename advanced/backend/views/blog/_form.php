<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\ArrayHelper;
use common\models\Tag;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'text')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'formatting' => ['p', 'blockquote', 'h2'],
            'plugins' => [
                'clips',
                'fullscreen',
            ],
        ],
    ]); ?>
    
    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_id')->dropDownList(['off', 'on']) ?>

    <?= $form->field($model, 'sort')->textInput() ?>
    
    <?= $form->field($model, 'tags_array')->widget(kartik\select2\Select2::classname(), [
        'data' => ArrayHelper::map(Tag::find()->all(), 'id', 'name'),
        'value' => ArrayHelper::map($model->tags, 'id', 'name'),
        'language' => 'ru',
        'options' => [
            'placeholder' => 'Выбрать тэг ...', 
            'multiple' => true
            ],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => true,
            'maximumInputLength' => 10,
        ],
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
