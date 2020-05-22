<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'summary' => false,
        'columns' => [

            'id',
            [
			    'format' => ['date', 'dd-MM-Y hh:m:ss'],
				'attribute' => 'created_at',
				'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_normal',
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
			    ]),
            ],
			[
			    'format' => ['date', 'dd-MM-Y hh:m:ss'],
				'attribute' => 'updated_at',
				'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updated_normal',
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
			    ]),
            ],
			'user_id',
            'surname',
			'name',
            'email:email',
			[
                'attribute' => 'status',
				'filter' => array(
                    \common\models\Order::STATUS_NEW => 'Mới', 
                    \common\models\Order::STATUS_WAIT_CONFIRM => 'Chờ xác nhận',
                    \common\models\Order::STATUS_CONFIRM => 'Đã xác nhận', 
                    \common\models\Order::STATUS_ORDER => 'Đã order',
                    \common\models\Order::STATUS_CHINA_STORE => 'Hàng về kho Trung Quốc', 
                    \common\models\Order::STATUS_VIETNAM_STORE => 'Hàng về kho Việt Nam',
                    \common\models\Order::STATUS_PARTIAL_SHIP => 'Hàng giao 1 phần', 
                    \common\models\Order::STATUS_SHIP => 'Hàng đã giao',   
                    \common\models\Order::STATUS_BILL => 'Đã xuất hoá đơn', 
                    \common\models\Order::STATUS_CANCEL => 'Đã huỷ đơn'),
  				'value' => function($model){
					switch($model['status']){
                        case \common\models\Order::STATUS_NEW  : return  'Mới'; break;
                        case \common\models\Order::STATUS_WAIT_CONFIRM  : return  'Chờ xác nhận'; break;
                        case \common\models\Order::STATUS_CONFIRM  : return  'Đã xác nhận'; break;
                        case \common\models\Order::STATUS_ORDER  : return  'Đã order'; break;
                        case \common\models\Order::STATUS_CHINA_STORE  : return  'Hàng về kho Trung Quốc'; break;
                        case \common\models\Order::STATUS_VIETNAM_STORE  : return  'Hàng về kho Việt Nam'; break;
                        case \common\models\Order::STATUS_PARTIAL_SHIP  : return  'Hàng giao 1 phần'; break; 
                        case \common\models\Order::STATUS_SHIP  : return  'Hàng đã giao'; break;   
                        case \common\models\Order::STATUS_BILL  : return  'Đã xuất hoá đơn'; break;
                        case \common\models\Order::STATUS_CANCEL  : return  'Đã huỷ đơn'; break;
                    }
				}
			],
        ],
    ]); ?>
</div>
