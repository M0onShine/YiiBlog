<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace backend\controllers;

use common\components\Upload;
use common\models\Attachment;
use common\models\Category;
use common\models\Post;
use Yii;

use backend\components\BaseController;
use common\models\LoginForm;
use yii\helpers\Html;
use yii\web\Response;


/**
 * 控制台
 * @package backend\controllers
 */
class SiteController extends BaseController
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    /**
     * 概要
     * @return string
     */
    public function actionIndex()
    {
        $recentPublishedPost=Post::find()->selectNoText()->recentPublished()->all();
        $postCount=Post::find()->published()->count();
        $categoryCount=Category::find()->count();
        //todo: 评论数量 最新回复
        return $this->render('index',[
            'recentPublishedPost'=>$recentPublishedPost,
            'postCount'=>$postCount,
            'categoryCount'=>$categoryCount,
        ]);
    }

    /**
     * 个人设置
     * @return string
     */
    public function actionProfile(){
        $model=Yii::$app->user->identity;
        $model->scenario='profile';

        if(Yii::$app->request->isPost){

            if($model->load(Yii::$app->request->post())&&$model->save()){
                return $this->redirect(['profile']);
            }

        }

        return $this->render('profile',['model'=>$model]);
    }


    /**
     * 登录
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
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
     * 退出
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * 上传文件
     * @return array
     */
    public function actionUpload(){
        Yii::$app->response->format=Response::FORMAT_JSON;

        //error ['err'=>1,'msg'=>'error message']
        //success ['err'=>0,'msg'=>'success message','data'=>['id'=>'','name'=>'','url'=>'','isImage'=>'']]
        $upload=new Upload([
            'savePath'=>Attachment::SAVE_PATH,
        ]);
        if($upload->checkFileInfoAndSave()){
            //保存到数据库
            $attachment=new Attachment();
            $attachment->title=$upload->originalFileName;
            $attachment->text=[
                'name'=>Html::encode($upload->originalFileName),
                'path'=>Yii::getAlias(Attachment::WEB_URL.$upload->saveRelativePath),
                'minetype'=>$upload->fileMimeType,
                'ext'=>$upload->fileExt,
                'size'=>$upload->filesize,
            ];
            $attachment->save(false);
            return [
                'err'=>0,
                'msg'=>'上传成功',
                'data'=>[
                    'id'=>$attachment->cid,
                    'name'=>Html::encode($upload->originalFileName),
                    'url'=>Yii::getAlias(Attachment::WEB_URL.$upload->saveRelativePath),
                    'isImage'=>in_array($upload->fileMimeType,Attachment::$imageMineType),
                ],
            ];

        }else{
            return ['err'=>1,'msg'=>$upload->error];
        }

    }
}
