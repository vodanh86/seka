<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Product;
use backend\models\OrderSearch;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php
	//$form = ActiveForm::begin(); //Default Active Form begin
	$form = ActiveForm::begin([
		'id' => 'active-form',
		'options' => [
			'class' => 'form-horizontal',
			'enctype' => 'multipart/form-data',
			'method' => 'get',
		],
	])?>
		<div class="row">
			<div class="col-md-2">
			Từ ngày
			</div>
			<div class="col-md-4">

				<?= DatePicker::widget([
					'name' => 'from_date',
					'template' => '{addon}{input}',
						'clientOptions' => [
							'autoclose' => true,
							'format' => 'yyyy-mm-dd'
						]
				]);?>
			</div>
			<div class="col-md-2">
			Đến ngày
			</div>
			<div class="col-md-4">

				<?= DatePicker::widget([
					'name' => 'to_date',
					'template' => '{addon}{input}',
						'clientOptions' => [
							'autoclose' => true,
							'format' => 'dd-M-yyyy'
						]
				]);?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
			Khách hàng
			</div>
			<div class="col-md-4">
			<?= $form->field($model, 'surname')
				->dropDownList(ArrayHelper::map(User::find()->all(),'id','username'), ['prompt'=>'Select all'])->label(false)
			?>
			</div>
			<div class="col-md-2">
			Người chăm sóc
			</div>
			<div class="col-md-4">
			<?= $form->field($model, 'name')
				->dropDownList(ArrayHelper::map(User::find()->all(),'id','username'), ['prompt'=>'Select all'])->label(false)
			?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
			Mặt hàng
			</div>
			<div class="col-md-4">
			<?= $form->field($model, 'country')
				->dropDownList(ArrayHelper::map(Product::find()->all(),'id','title'), ['prompt'=>'Select all'])->label(false)
			?>
			</div>
			<div class="col-md-2">
			Trạng thái
			</div>
			<div class="col-md-4">
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
			], ['prompt'=>'Select all'])->label(false) ?>
			</div>
		</div>
	<div class="row">
		<div class="col-md-2">
			Hình thức thanh toán
		</div>
		<div class="col-md-4">
		<?= $form->field($model, 'payment_method')->dropDownList([
        \common\models\Order::PAYMENT_CASH => 'Tiền mặt', 
        \common\models\Order::PAYMENT_TRANSFER => 'Chuyển khoản',
        \common\models\Order::PAYMENT_COD_GHTK => 'COD GHTK', 
        \common\models\Order::PAYMENT_CODE_SHOPEE => 'COD SHOPEE',
        \common\models\Order::PAYMENT_TEXT => 'Khác', 
	], ['prompt'=>'Select all'])->label(false) ?>
		</div>
		<div class="col-md-2">
		</div>
		<div class="col-md-4">
		</div>
	</div>

	<?php
	echo Html::submitButton('Search', ['class' => 'btn btn-primary']);
	/* ADD FORM FIELDS */
	ActiveForm::end();
	?>
	<?php
	$gridColumns = [
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
		[
			'attribute' => 'customer_type',
			'filter' => array(\common\models\Order::GUEST => 'Guest', \common\models\Order::USER => 'Registered'),
			'value' => function($model){
				switch($model['customer_type']){
					case \common\models\Order::GUEST : return 'Guest'; break;
					case \common\models\Order::USER : return 'Registered'; break;
				}
			}
		],
		'user_id',
		'surname',
		'name',
		[
			'attribute' => 'orderItems',
			'value' => function($model){
				$items = array();
				foreach ( $model->getOrderItems()->all() as $item){
					array_push($items, Product::findOne($item->product_id)->title);
				}
				return implode("|",$items);;
			}
		],
		'payment_method',
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
				\common\models\Order::STATUS_CANCEL => 'Đã huỷ đơn',
			),
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

		['class' => 'yii\grid\ActionColumn'],
	];
	// Renders a export dropdown menu
	echo ExportMenu::widget([
		'dataProvider' => $dataProvider,
		'columns' => $gridColumns
	]);
	
	// You can choose to render your own GridView separately
	echo \kartik\grid\GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => $gridColumns
	]);
	?>
	
</div>
