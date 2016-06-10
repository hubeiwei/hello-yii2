<?php

namespace app\modules\portal\controllers;

use app\models\Music;
use app\models\search\MusicSearch;
use app\modules\core\helpers\EasyHelper;
use app\modules\core\helpers\FileHelper;
use app\modules\core\helpers\UserHelper;
use app\modules\portal\controllers\base\ModuleController;
use app\modules\portal\models\MusicUpdateForm;
use app\modules\portal\models\MusicUploadForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * MusicController implements the CRUD actions for Music model.
 */
class MusicController extends ModuleController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'index',
                    'my-music',
                    'create',
                    'update',
                    'delete',
                ],
                'rules' => [
                    //所有人都能访问index
                    [
                        'allow' => true,
                        'actions' => [
                            'index',
                        ],
                    ],
                    //已登录用户能访问的
                    [
                        'allow' => true,
                        'actions' => [
                            'my-music',
                            'create',
                            'update',
                            'delete',
                        ],
                        'roles' => ['@'],//@已登录，?未登录
                    ],
                ],
            ],
        ];
    }

    /**
     * gii生成的代码，这个方法我还没改过，所以就别研究这个了
     *
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
     * 和上面一样，只是改了个searchMyMusic
     *
     * @return string
     */
    public function actionMyMusic()
    {
        $searchModel = new MusicSearch();
        $dataProvider = $searchModel->searchMyMusic(Yii::$app->request->queryParams);

        return $this->render('my-music', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Music model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /**
         * 自己建一个MusicUploadForm的类来验证文件，
         * 是因为Music的music_file字段是存字符串的
         * 全部规则混在Music里面会导致save不成功
         */
        $form = new MusicUploadForm();

        /**
         * 我的套路是这样的：
         * 在post的数据把MusicUploadForm里面的rules()的字段load下来，然后执行validate()方法来验证rules，
         * 不符合rules返回false，并在MusicUploadForm->error添加了内容，
         * 然后因为我这流程的结构，会继续回到create页面，在create页面如果Model有错误则会在对应字段下显示错误，
         * 同理，因为MusicUploadForm已经load了你提交的内容，所以回到create页面还能看到你原来填写的内容，
         * 因此，create和update两个表单如果没有什么特殊要求的话，可以共用一个生成的表单，这里就共用了_form.php。
         *
         * 你可以把rules()里的某个字段的规则删掉，看看load之后MusicUploadForm的这个字段有没有值。
         * @see MusicUploadForm::rules()
         * @see MusicFormBase::rules()
         */
        if ($form->load(Yii::$app->request->post())) {
            $form->music_file = UploadedFile::getInstance($form, 'music_file');//文件是不能直接收到的，得这样
            if ($form->validate()) {
                $filename = FileHelper::generateFileName();
                $savePath = FileHelper::getMusicFullPath($filename);
                if ($form->music_file->saveAs($savePath)) {
                    $model = new Music();
                    $model->setAttributes($form->getAttributes());
                    $model->music_file = $filename;
                    if ($model->save()) {
                        EasyHelper::setSuccessMsg('添加成功');
                        return $this->redirect(['index']);
                    } else {
                        unlink($savePath);//删除文件
                        EasyHelper::setErrorMsg('添加失败');
                        $form->addErrors($model->getErrors());
                    }
                } else {
                    $form->addError('music_file', '文件上传失败');//向music_file属性添加一个错误
                }
            }
        }

        return $this->render('create', [
            'model' => $form,
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

        if (!UserHelper::isBelongToUser($model->user_id)) {
            EasyHelper::setErrorMsg('不可修改其他人的数据');
            return $this->redirect(['index']);
        }

        $form = new MusicUpdateForm();

        if ($form->load(Yii::$app->request->post())) {
            $form->music_file = UploadedFile::getInstance($form, 'music_file');
            if ($form->validate()) {
                $original_file_name = $model->music_file;//记录原文件名
                $savePath = '';
                $flow = true;

                //如果上传了文件，上传新文件
                if ($form->music_file) {
                    $file_name = FileHelper::generateFileName();
                    $savePath = FileHelper::getMusicFullPath($file_name);
                    $model->music_file = $file_name;
                    if ($form->music_file->saveAs($savePath)) {
                        $form->addError('music_file', '文件上传失败');//上传文件跟这些类没关系，要是失败了就手动给music_file这个属性添加错误
                        $flow = false;
                    }
                }

                if ($flow) {
                    $model->track_title = $form->track_title;
                    $model->visible = $form->visible;
                    if (UserHelper::userIsAdmin()) {
                        $model->status = $form->status;
                    }

                    if ($model->save()) {

                        //如果上传了文件，删除原文件
                        if ($form->music_file) {
                            unlink(FileHelper::getMusicFullPath($original_file_name));
                        }

                        EasyHelper::setSuccessMsg('修改成功');
                        return $this->redirect(['index']);
                    } else {

                        //如果上传了文件，删除新文件
                        if ($form->music_file) {
                            unlink($savePath);
                        }

                        EasyHelper::setErrorMsg('修改失败');
                        $form->addErrors($model->getErrors());//获取两个类相同属性的错误
                    }
                }
            }
        } else {
            $form->setAttributes($model->getAttributes());
        }

        return $this->render('update', [
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

        if (UserHelper::isBelongToUser($model->user_id)) {
            if ($model->delete()) {
                unlink(FileHelper::getMusicFullPath($model->music_file));
                EasyHelper::setSuccessMsg('删除成功');
            } else {
                EasyHelper::setErrorMsg('删除失败');
            }
        } else {
            EasyHelper::setErrorMsg('不能删除其他人的数据');
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
