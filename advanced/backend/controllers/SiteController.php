<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\base\DynamicModel;
use yii\web\Response;
use yii\helpers\Json;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'save-redactor-image', 'native-imperavi'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'native-imperavi' => [
                      'class' => 'vova07\imperavi\actions\UploadFileAction',
                      'url' => 'http://admin.site.com/public_html/uploads/images/blog/',
//                      'url' => 'http://site.com/public_html/uploads/images/blog/',
                      'path' => '@images/blog',
                      'unique' => false,
              ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionSaveRedactorImage($sub = 'main') {
        $this->enableCsrfValidation = false;
        if(Yii::$app->request->isPost) {
            $dir = Yii::getAlias('@images') . '/' . $sub . '/';
            if(!file_exists($dir)) {
                FileHelper::createDirectory($dir);
            }
//            $result_link = str_replace('admin.', '', Url::home(true)) . '/uploads/images/' . $sub . '/';
            $result_link = Url::home(true) . 'uploads/images/' . $sub . '/';
            $file = UploadedFile::getInstanceByName('file');
            $model = new DynamicModel(compact('file'));
            $model->addRule('file', 'image')->validate();
            
            if($model->hasErrors()) {
                $result = [
                    'error' => $model->getFirstError('file')
                ];
            }else {
                $model->file->name = strtotime('now') . '_' . Yii::$app->getSecurity()->generateRandomString(6) . '.' . $model->file->extension;
                if($model->file->saveAs($dir . $model->file->name)) {
//                    $imag = Yii::$app->image->load($dir . $model->file->name);
//                    $imag->resize(800, NULL, Yii\image\drivers\Image::PRECISE)->save($dir . $model->file->name, 85);
                    $result = ['filelink' => $result_link . $model->file->name, 'filename'=>$model->file->name];
                }else {
                    $result = [
                        'error' => Yii::t('vova07/imperavi', 'ERROR_CAN_NOT_UPLOAD_FILE')
                    ];
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;
        }else {
            throw new \yii\web\BadRequestHttpException('Only POST is allowed');
        }
    }
    
}
