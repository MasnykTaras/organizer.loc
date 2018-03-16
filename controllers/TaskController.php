<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Task;
use app\models\SearchTask;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\UploadPhoto;
use yii\web\UploadedFile;

class TaskController extends Controller
{
     public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup', 'create', 'index', 'update', 'delete', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup', 'index'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'create', 'index', 'update', 'delete', 'view'],
                        'roles' => ['@'],
                    ],
                   
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchTask();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post())) {
            
            $file = new UploadPhoto();
             if(UploadedFile::getInstance($model, 'photo')) {
                 
                $file->photo = UploadedFile::getInstance($model, 'photo');

                $model->photo = $file->photo->name;

                if ($file->upload()) {

                   $model->save();

                    return $this->redirect(['index']);
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
     /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            
             if(!empty(UploadedFile::getInstance($model, 'photo'))){
                $file = new UploadPhoto();
                $file->photo = UploadedFile::getInstance($model, 'photo');
                $model->photo = $file->photo->name;
                if (!$file->upload()) {
                     return $this->render('update', [
                        'model' => $model,
                    ]); 
                }
            }else{
                $model->photo = $model->getCurrentFile($model->id)[0];
            }     
             if($model->save()){
              return $this->redirect(['view', 'id' => $model->id]);  
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
     /**
     * Deletes an existing Task model.
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
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionStatusUpdate($id)
    {       
        Task::updateAll(['status' => Task::DONETASK], "id = $id");
        
        return $this->redirect('index');
    }
     public function actionAllStatusUpdate($id)
    {
        if($id == 1){
            Task::updateAll(['status' => Task::DONETASK]);
        }else{
            Task::updateAll(['status' => Task::DONETASK], "user_id = $id");
        }
        return $this->redirect('index');
              
        
    }
    
}