<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Sklad;
use common\models\Product;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sklad_id')->dropDownList(Sklad::getList()) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cost')->textInput() ?>
    
    <?= $form->field($model,'date')->widget(DateControl::className(), []) ?>

    <?= $form->field($model, 'type_id')->dropDownList(Product::getTypeList()) ?> 
    <!--поскольку в модель можно передать что угодно лучще обращатся сразу к класу а не к $model-->

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
