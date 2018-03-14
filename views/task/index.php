<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;


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
        <?= Yii::$app->user->isGuest ?  '' :  Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
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
            'user',
            
            [
                'attribute'=>'priority',
                'label'=>'Status',                
                'content'=>function($model){
                     return $model->getPriorityArray()[$model->priority];
                }
            ],
            [
                'attribute'=>'status',
                'label'=>'Status',
                'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'name'];
                },
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
               'visible' => !Yii::$app->user->isGuest,
                
            ],            
        ],
        
    ]); ?>
  <?php Pjax::end(); ?>
  <?=  Yii::$app->user->isGuest ?  '' : 
       Html::a('All Done', ['task/all-status-update'], [
      'class' => 'btn btn-sm btn-primary update-status', 
      'data' => [
            'confirm' =>'Are you sure you want to update all item?',
            'pjax' => 0,            
        ],
      ])?>
 
</div>

