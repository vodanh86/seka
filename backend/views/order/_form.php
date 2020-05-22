<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'status')->dropDownList([
        \common\models\Order::STATUS_NEW => 'Mới', 
        \common\models\Order::STATUS_WAIT_CONFIRM => 'Chờ xác nhận',
        \common\models\Order::STATUS_CONFIRM => 'Đã xác nhận', 
        \common\models\Order::STATUS_ORDER => 'Đã order',
        \common\models\Order::STATUS_CHINA_STORE => 'Hàng về kho Trung Quốc', 
        \common\models\Order::STATUS_VIETNAM_STORE => 'Hàng về kho Việt Nam',
        \common\models\Order::STATUS_PARTIAL_SHIP => 'Hàng giao 1 phần', 
        \common\models\Order::STATUS_SHIP => 'Hàng đã giao',   
        \common\models\Order::STATUS_BILL => 'Đã xuất hoá đơn', 
        \common\models\Order::STATUS_CANCEL => 'Đã huỷ đơn',
     ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
