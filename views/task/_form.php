<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <?= $form->field($model, 'priority')->dropDownList($model->getPriorityArray()) ?> 

    <?= $form->field($model, 'status')->dropDownList($model->getStatusArray()) ?> 
    <?php if($model->id){ ?>
        <?= Html::img('/upload/' . $model->getCurrentFile($model->id)[0], ['alt' => 'Image', 'width' => '60px']) ?>
    <?php } ?>
     <?= $form->field($model, 'photo')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
