<?php

namespace backend\controllers;

use backend\components\BaseController;
use common\models\Attachment;
use Yii;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
/**
 * MediaController implements the CRUD actions for Content model.
 */
class MediaController extends BaseController
{

    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Attachment::find()->with('post')->with('page')->with('author')->orderByCid(),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
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
     * @return Attachment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attachment::find()->andWhere(['cid'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
