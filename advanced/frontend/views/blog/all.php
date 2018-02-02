<?php

 /* @var $this yii\web\View */
 /* $dataProvider \yii\data\ActiveDataProvider */

use yii\bootstrap\Html;
use yii\widgets\ListView;

//$blog = $dataProvider->getModels();
?>

<div class="body-content">
    
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_one',
    ]); ?>

    <!--<div class="row">-->
        <?php // foreach($blog as $one): ?>
        <!--<div class="col-lg-12">-->
            <!--<h2><? echo $one->title ?></h2>-->

            <!--<p><? echo $one->text ?></p>-->
            <!--<? echo Html::a('Продобнее', ['blog/one', 'url' => $one->url], ['class' => 'btn btn-success']) ?>-->
        <!--</div>-->
        <?php // endforeach ?>
    <!--</div>-->

</div>

