<?php
 /* @var $this yii\web\View */
 /* @blog \common\models\Blog */
?>

<h1><?= $blog->title ?></h1>
<?=$blog->text ?>
<span class="badge"><?= $blog->author->username ?></span>
<br>