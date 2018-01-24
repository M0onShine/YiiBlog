<?php

namespace backend\controllers;


use common\models\Post;
use Yii;
use backend\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

/**
 * PostController implements the CRUD actions for Content model.
 */
class PostController extends BaseController
{


    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->selectNoText()->with('categories')->with('author')->orderByCid(),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);

    }


    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
        $model->allowComment=true;
        $model->allowFeed=true;
        $model->allowPing=true;

        if(Yii::$app->request->isPost){

            if($model->load(Yii::$app->request->post())){
                $model->inputCategories=Yii::$app->request->post('inputCategories',[]);
                $model->inputTags=Yii::$app->request->post('inputTags',[]);
                $model->inputAttachments=Yii::$app->request->post('inputAttachments',[]);
                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->isPost){

            if($model->load(Yii::$app->request->post())){
                $model->inputCategories=Yii::$app->request->post('inputCategories',[]);
                $model->inputTags=Yii::$app->request->post('inputTags',[]);
                $model->inputAttachments=Yii::$app->request->post('inputAttachments',[]);
                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Content model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::find()->andWhere(['cid'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
