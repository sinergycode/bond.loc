<?php

namespace frontend\controllers;

use common\models\Blog;
use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

/**
 * @author user1
 */
class BlogController extends Controller{
    
    public function actionIndex() {
        $blogs = Blog::find()->with('author')->andWhere(['status_id' => 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $blogs,
            'pagination' => [
                'pagesize' => 10,
            ],
        ]);
        return $this->render('all', ['dataProvider' => $dataProvider]);
    }

    public function actionOne($url) {
        if($blog = Blog::find()->andWhere(['url' => $url])->one()) {
            
            return $this->render('one', ['blog' => $blog]);  
        }
        throw new \yii\web\NotFoundHttpException('Ой, нет такого блога!');
    }
    
}
