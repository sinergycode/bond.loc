<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Sklad;
use common\models\Product;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([ // gidview обернут в Pjax чтобы небыло перезагрузки страницы
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute' => 'sklad_id', 'value' => 'skladName', 'filter' => Sklad::getList()],
                                                //Product function
            
            ['attribute' => 'sklad_name', 'value' => 'skladName', ],
            
            'title',
            'cost',
            
            ['attribute' => 'date', 'format' => 'date', 'value' => 'date', 'filter' => kartik\field\FieldRange::widget([
                'type' => kartik\field\FieldRange::INPUT_DATE,
                'name1' => 'from_date',
                'name2' => 'to_date'
            ])],
            
            ['attribute' => 'type_id', 'value' => 'typeName', 'filter' => Product::getTypeList()],
            
            //'text:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php $this->registerJs("
 $('.grid-view tbody tr').on('click', function() {
 var data = $(this).data();
 console.log(data.key);
 });
");

?>