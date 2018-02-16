<?php
 /* @var $this yii\web\View */
 /* @blog \common\models\Blog */
?>

<h1><?= $blog->title ?></h1>
<?=$blog->text ?>
<span class="badge"><?= $blog->author->username ?></span>
<br>

<?php // $blog->CreateDirectory(); 
//echo Yii::getAlias('@images');
//?>
<br>
<?php
//echo dirname(__DIR__);
//$dir = Yii::getAlias('@images') . '/tralalal/';
//yii\helpers\FileHelper::createDirectory($dir);
//?>

<p><img src="http://site.com/uploads/images/blog/1518520415_IPpLHo.png"></p>