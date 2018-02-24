<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sklad */

$this->title = 'Update Sklad: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Sklads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sklad-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
