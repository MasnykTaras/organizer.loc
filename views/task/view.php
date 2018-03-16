<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model backend\models\Book */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Task', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(Yii::$app->user->can('createTask')):?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php endif;?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',   
            [
                'attribute'=>'user_id',
                'label'=>'User', 
                'content'=>function($model){        
                    return User::findIdentity($model->user_id)->username;
                }
            ],
           
            [
                'label' => 'Priority',
                'value' => $model->getPriorityArray()[$model->priority],
            ],
            [                
                'label'=>'Status',
                'value' => $model->getStatusArray()[$model->status],                
            ],            
            [
                'label' => 'Image',
                'format' => 'raw',
                'value' => function($data){
                     return Html::img('/upload/'. $data->photo, ['width' => '60px']);
                },
            ],
        ],
    ]) ?>

</div>