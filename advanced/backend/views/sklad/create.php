<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Sklad */

$this->title = 'Create Sklad';
$this->params['breadcrumbs'][] = ['label' => 'Sklads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sklad-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
