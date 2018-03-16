<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\models\User;


/* @var $this yii\web\View */
/* @var $searchModel app\models\Searchtask */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Yii::$app->user->can('createTask') ?    Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) : '' ?>
    </p>   
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'created',           
             [
                'attribute'=>'user_id',
                'label'=>'User', 
                'content'=>function($model){        
                    return User::findIdentity($model->user_id)->username;
                }
            ],
            
            [
                'attribute'=>'priority',
                'label'=>'Priority',                  
                'content'=>function($model){
                    return $model->getPriorityArray()[$model->priority];
                }
            ],
            [
                'attribute'=>'status',
                'label'=>'Status',
                'content'=>function($model){
                     return $model->getStatusArray()[$model->status];
                }
            ],            
            [
                'label' => 'Image',
                'format' => 'raw',
                'value' => function($model){
                     return Html::img('/upload/'. $model->photo, ['width' => '60px']);
                },
            ],
           
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {link}',
                'buttons' => [
                    'link' => function ($url,$model,$key) {
                        return Html::a('Done', ['task/status-update', 'id' =>$model->id], ['class' => 'btn btn-sm btn-primary']);
                    },
                ],
               'visibleButtons' => [
                   'delete' => Yii::$app->user->can('createTask'),
                   'update' => Yii::$app->user->can('createTask'),
                   'link' => function ($model) {                       
                        return Yii::$app->user->can('updateTask', ['author_id' => $model->user_id]);                                             
                   }
               ],
            ],            
        ],
        
    ]); ?>
  <?php Pjax::end(); ?>
  <?=  !Yii::$app->user->isGuest ? 
       Html::a('All Done', ['task/all-status-update' , 'id'=>Yii::$app->user->id], [
      'class' => 'btn btn-sm btn-primary update-status', 
      'data' => [
            'confirm' =>'Are you sure you want to update all item?',
            'pjax' => 0,            
        ],
      ]) : '' ?>
 
</div>

