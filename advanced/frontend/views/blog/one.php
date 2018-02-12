<?php
 /* @var $this yii\web\View */
 /* @blog \common\models\Blog */
?>

<h1><?= $blog->title ?></h1>
<?=$blog->text ?>
<span class="badge"><?= $blog->author->username ?></span>
<br>

<?php // $blog->CreateDirectory(); ?>

<p><img src="http://admin.site.com/uploads/images/blog/1518330415_CPs7Bh.png"></p>