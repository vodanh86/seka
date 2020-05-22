<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'role')->dropDownList(['20' => 'Admin', '15' => 'User', '5' => 'Customer']) ?>
    <?= $form->field($model, 'status')->dropDownList(['10' => 'Active', '0' => 'Banned']) ?>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
