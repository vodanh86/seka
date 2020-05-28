<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $users = ArrayHelper::map(User::find()->all(),'id', 'username') ?>
    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'summary' => false,
        'columns' => [

            'id',
			[
			    'format' => ['date', 'dd.MM.Y'],
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
			    'format' => ['date', 'dd.MM.Y'],
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
            'username',
            [
                'attribute' => 'supporter',
				'value' => function($model) use ($users){
					return $users[$model["supporter"]];
				}
			],
            'email:email',
            [
                'attribute' => 'role',
				'filter' => array(\common\models\User::ROLE_ADMIN => 'Admin', \common\models\User::ROLE_USER => 'User', \common\models\User::ROLE_CUSTOMER => 'Customer'),
				'value' => function($model){
					switch($model['role']){
                        case \common\models\User::ROLE_ADMIN : return 'Admin'; break;
					    case \common\models\User::ROLE_USER : return 'User'; break;
					    case \common\models\User::ROLE_CUSTOMER : return 'Customer'; break;
					}
				}
			],
            [
                'attribute' => 'status',
				'filter' => array(\common\models\User::STATUS_ACTIVE => 'Active', \common\models\User::STATUS_DELETED => 'Banned'),
				'value' => function($model){
					switch($model['status']){
					    case \common\models\User::STATUS_DELETED : return 'Banned'; break;
					    case \common\models\User::STATUS_ACTIVE : return 'Active'; break;
					}
				}
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
