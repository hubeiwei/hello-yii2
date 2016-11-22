<?php

namespace app\modules\backend\controllers;

use app\common\helpers\Message;
use app\models\Music;
use app\models\search\MusicSearch;
use app\modules\backend\controllers\base\ModuleController;
use app\modules\frontend\models\MusicForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * MusicController implements the CRUD actions for Music model.
 */
class MusicController extends ModuleController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Music models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MusicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Music model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $form = new MusicForm();
        $form->scenario = 'update';
        if ($form->load(Yii::$app->request->post())) {
            $form->music_file = UploadedFile::getInstance($form, 'music_file');
            if ($form->validate()) {
                $original_file_name = $model->music_file;//记录原文件名
                $model->setAttributes($form->getAttributes());
                $flow = true;

                //如果上传了文件，上传新文件
                if ($form->music_file) {
                    if (!$model->uploadMusic($form->music_file)) {
                        $form->addError('music_file', '文件上传失败');
                        $flow = false;
                    }
                }

                if ($flow) {
                    if ($model->save(false)) {
                        //如果上传了新文件，删除原文件
                        if ($form->music_file) {
                            unlink(Music::getMusicFullPath($original_file_name));
                        }
                        Message::setSuccessMsg('修改成功');
                        return $this->redirect(['index']);
                    } else {
                        //如果上传了新文件，删除新文件
                        if ($form->music_file) {
                            $model->deleteMusic();
                        }
                        Message::setErrorMsg('修改失败');
                    }
                }
            }
        } else {
            $form->setAttributes($model->getAttributes());
        }

        return $this->render('@app/modules/frontend/views/music/update', [
            'model' => $form,
        ]);
    }

    /**
     * Deletes an existing Music model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            $model->deleteMusic();
            Message::setSuccessMsg('删除成功');
        } else {
            Message::setErrorMsg('删除失败');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Music model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Music the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Music::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
