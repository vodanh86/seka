<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = $model1->name;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">
	<h1> Hoá đơn </h1>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model1,
        'attributes' => [
            'id',
			[
                'attribute' => 'customer_type',
				'value' => function($model){
					switch($model['customer_type']){
						case \common\models\Order::GUEST : return 'Guest'; break;
						case \common\models\Order::USER : return 'Registered'; break;
					}
				}
			],
            'surname',
            'user_id',
            'name',
            'country',
            'region',
            'city',
            'address:ntext',
            'zip_code',
            'phone',
            'payment_method',
            'email:email',
            'notes:ntext',
			[
                'attribute' => 'status',
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
			[
			    'format' => ['date', 'dd.MM.Y'],
                'attribute' => 'created_at',
			],
			[
			    'format' => ['date', 'dd.MM.Y'],
                'attribute' => 'updated_at',
			],
        ],
    ]) ?>
	
	<h4>Items to this order</h4>
	<table style="width: 100%">

	<?php
	echo '<tr><td><h3>id</h3></td><td><h3>order id</h3></td><td><h3>product id</h3></td><td><h3>price</h3></td><td><h3>quantity</h3></td><td><h3>created at</h3></td><tr>';
	foreach($items as $item){
		echo '<tr><td>'.($item->id).'</td><td>'.$item->order_id.'</td><td>'.$item->product_id.'</td><td>'.$item->price.'</td><td>'.$item->quantity.'</td><td>'.date('d M Y H:i:s',$item->created_at).'</td><tr>';
	}
	 ?>
	</table>

</div>
