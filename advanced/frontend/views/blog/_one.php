<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="col-lg-12">
    <h2><?= $model->title ?><span class="badge"><?= $model->author->username ?></span></h2>
    <?= $model->text ?>
    <?= \yii\bootstrap\Html::a('продобнее', ['blog/one', 'url'=> $model->url], ['class' => 'btn btn-success']) ?>
</div>

